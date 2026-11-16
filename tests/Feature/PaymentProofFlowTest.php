<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PaymentProofFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createQrisOrderFor(User $customer, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'TB-20261116-' . strtoupper(substr(md5((string) microtime(true)), 0, 4)),
            'user_id' => $customer->id,
            'order_type' => 'takeaway',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'qris',
            'subtotal' => 33000,
            'tax_amount' => 3630,
            'discount_amount' => 0,
            'total_amount' => 36630,
            'customer_name' => $customer->name,
            'customer_phone' => '08123456789',
        ], $overrides));
    }

    private function makeSamplePngDataUri(): string
    {
        $img = imagecreatetruecolor(8, 8);
        $bg = imagecolorallocate($img, 56, 88, 80);
        imagefill($img, 0, 0, $bg);
        ob_start();
        imagepng($img);
        $binary = ob_get_clean();
        imagedestroy($img);

        return 'data:image/png;base64,' . base64_encode($binary);
    }

    public function test_qris_order_page_has_no_whatsapp_link_and_shows_in_system_upload_form(): void
    {
        $customer = User::factory()->create();
        $order = $this->createQrisOrderFor($customer);

        $response = $this->actingAs($customer)->get(route('orders.show', $order->order_number));

        $response->assertOk();
        $response->assertDontSee('wa.me/', false);
        $response->assertDontSee('Kirim Bukti Transfer ke WhatsApp Admin');
        $response->assertSee(route('orders.payment.proof', $order->order_number), false);
        $response->assertSee('Kirim Bukti Pembayaran');
        $response->assertSee('data-auto-open-qris="true"', false);
    }

    public function test_customer_can_upload_proof_via_data_uri_and_admin_can_confirm_paid(): void
    {
        $customer = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $order = $this->createQrisOrderFor($customer);

        $dataUri = $this->makeSamplePngDataUri();

        $uploadResponse = $this->actingAs($customer)->post(
            route('orders.payment.proof', $order->order_number),
            [
                'proof_data' => $dataUri,
                'payment_proof_note' => 'Ditransfer via GoPay a.n. Rizky',
            ]
        );

        $uploadResponse->assertRedirect(route('orders.show', $order->order_number));
        $uploadResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertNotNull($order->payment_proof);
        $this->assertStringStartsWith('data:image/png;base64,', $order->payment_proof);
        $this->assertNotNull($order->payment_proof_uploaded_at);
        $this->assertSame('Ditransfer via GoPay a.n. Rizky', $order->payment_proof_note);
        $this->assertTrue($order->isAwaitingPaymentVerification());

        // Customer order page should reflect uploaded state & no longer auto-open QRIS popup
        $customerView = $this->actingAs($customer)->get(route('orders.show', $order->order_number));
        $customerView->assertOk();
        $customerView->assertSee('MENUNGGU VERIFIKASI ADMIN');
        $customerView->assertSee('Ditransfer via GoPay a.n. Rizky');
        $customerView->assertSee('data-auto-open-qris="false"', false);

        // Admin board and detail pages must show the uploaded proof for confirmation
        $adminBoard = $this->actingAs($admin)->get(route('admin.orders'));
        $adminBoard->assertOk();
        $adminBoard->assertSee('Bukti Masuk');

        $adminDetail = $this->actingAs($admin)->get(route('admin.orders.show', $order->order_number));
        $adminDetail->assertOk();
        $adminDetail->assertSee('Bukti Pembayaran Pelanggan');
        $adminDetail->assertSee('Ditransfer via GoPay a.n. Rizky');
        $adminDetail->assertSee('Konfirmasi Lunas');

        // Admin confirms payment as paid
        $confirmResponse = $this->actingAs($admin)->post(
            route('admin.orders.status', $order->id),
            [
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]
        );

        $confirmResponse->assertSessionHas('success');
        $order->refresh();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('confirmed', $order->status);
        $this->assertNotNull($order->paid_at);

        // Customer payment status polling endpoint reflects paid
        $poll = $this->actingAs($customer)->getJson(route('orders.payment.status', $order->order_number));
        $poll->assertOk()->assertJson([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'has_payment_proof' => true,
            'proof_rejected' => false,
        ]);
    }

    public function test_customer_can_upload_proof_via_multipart_file_fallback(): void
    {
        $customer = User::factory()->create();
        $order = $this->createQrisOrderFor($customer, ['payment_method' => 'bank_transfer']);

        $file = UploadedFile::fake()->image('bukti-transfer.jpg', 200, 200);

        $response = $this->actingAs($customer)->post(
            route('orders.payment.proof', $order->order_number),
            [
                'proof_image' => $file,
                'payment_proof_note' => 'Transfer BCA',
            ]
        );

        $response->assertRedirect(route('orders.show', $order->order_number));
        $order->refresh();
        $this->assertNotNull($order->payment_proof);
        $this->assertStringStartsWith('data:image/jpeg;base64,', $order->payment_proof);
    }

    public function test_admin_can_reject_proof_and_customer_cannot_access_other_users_order(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $order = $this->createQrisOrderFor($owner, [
            'payment_proof' => $this->makeSamplePngDataUri(),
            'payment_proof_uploaded_at' => now(),
        ]);

        // Stranger is forbidden
        $this->actingAs($stranger)->post(
            route('orders.payment.proof', $order->order_number),
            ['proof_data' => $this->makeSamplePngDataUri()]
        )->assertForbidden();

        // Admin rejects proof with reason
        $rejectResponse = $this->actingAs($admin)->post(
            route('admin.orders.payment.reject', $order->id),
            ['reason' => 'Foto buram, nominal tidak terbaca']
        );

        $rejectResponse->assertSessionHas('success');
        $order->refresh();
        $this->assertNull($order->payment_proof);
        $this->assertSame('unpaid', $order->payment_status);
        $this->assertSame('Foto buram, nominal tidak terbaca', $order->payment_proof_rejected_reason);

        // Customer polling & page show rejection reason cleanly
        $this->actingAs($owner)
            ->getJson(route('orders.payment.status', $order->order_number))
            ->assertOk()
            ->assertJson([
                'payment_status' => 'unpaid',
                'has_payment_proof' => false,
                'proof_rejected' => true,
            ]);

        $this->actingAs($owner)
            ->get(route('orders.show', $order->order_number))
            ->assertOk()
            ->assertSee('Foto buram, nominal tidak terbaca')
            ->assertSee('Bukti Pembayaran Perlu Diunggah Ulang');
    }

    public function test_invalid_proof_payload_does_not_flash_huge_data_into_session(): void
    {
        $customer = User::factory()->create();
        $order = $this->createQrisOrderFor($customer);

        $response = $this->actingAs($customer)
            ->from(route('orders.show', $order->order_number))
            ->post(route('orders.payment.proof', $order->order_number), [
                'proof_data' => 'not-an-image',
                'payment_proof_note' => 'Tes catatan',
            ]);

        $response->assertRedirect(route('orders.show', $order->order_number));
        $response->assertSessionHasErrors(['proof_image']);
        $this->assertArrayNotHasKey('proof_data', session()->getOldInput());
        $this->assertSame('Tes catatan', old('payment_proof_note'));
    }
}

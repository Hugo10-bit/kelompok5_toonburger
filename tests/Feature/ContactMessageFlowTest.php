<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Database\Seeders\ContactMessageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'username' => 'admin_msg_test',
            'role' => 'admin',
        ]);
    }

    public function test_guest_can_submit_contact_form_via_json_and_it_saves_unread(): void
    {
        $response = $this->postJson(route('contact.store'), [
            'name' => 'Andi Wijaya',
            'email' => 'Andi.Wijaya@Example.com',
            'phone' => '0812-3344-5566',
            'message' => 'Halo, apakah bisa pesan 15 burger untuk rapat kantor besok?',
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Andi Wijaya',
                ],
            ]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Andi Wijaya',
            'email' => 'andi.wijaya@example.com',
            'phone' => '0812-3344-5566',
            'message' => 'Halo, apakah bisa pesan 15 burger untuk rapat kantor besok?',
            'is_read' => false,
            'user_id' => null,
        ]);
    }

    public function test_authenticated_user_submission_links_user_id(): void
    {
        $customer = User::factory()->create([
            'username' => 'cust_msg_test',
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->post(route('contact.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '0813-9999-0000',
            'message' => 'Saya suka banget Very Cheese Burger!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'user_id' => $customer->id,
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'is_read' => false,
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->postJson(route('contact.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'phone' => '',
            'message' => '',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'message']);
    }

    public function test_admin_can_view_filter_sort_and_toggle_contact_messages(): void
    {
        $admin = $this->createAdmin();

        $this->seed(ContactMessageSeeder::class);
        $this->assertSame(9, ContactMessage::count());
        $this->assertSame(3, ContactMessage::where('is_read', false)->count());
        $this->assertSame(6, ContactMessage::where('is_read', true)->count());

        // View all messages
        $response = $this->actingAs($admin)->get(route('admin.messages'));
        $response->assertOk()
            ->assertSee('Pesan Terbaru')
            ->assertSee('Nama Pengguna')
            ->assertSee('Nomor Telfon')
            ->assertSee('Raka Pratama')
            ->assertSee('Belum Dibaca')
            ->assertSee('Dibaca');

        // Filter unread only
        $unreadResp = $this->actingAs($admin)->get(route('admin.messages', ['status' => 'unread']));
        $unreadResp->assertOk()
            ->assertSee('Raka Pratama')
            ->assertDontSee('Siti Rahmawati');

        // Filter read only
        $readResp = $this->actingAs($admin)->get(route('admin.messages', ['status' => 'read']));
        $readResp->assertOk()
            ->assertSee('Siti Rahmawati')
            ->assertDontSee('Raka Pratama');

        // Sort by name ascending
        $sortResp = $this->actingAs($admin)->get(route('admin.messages', ['sort' => 'name_asc']));
        $sortResp->assertOk()
            ->assertSeeInOrder(['Aulia Putri', 'Bima Mahendra', 'Clarissa Wijaya']);

        // Toggle status via AJAX PATCH
        $unreadMsg = ContactMessage::where('is_read', false)->firstOrFail();
        $patchResp = $this->actingAs($admin)->patchJson(route('admin.messages.status', $unreadMsg->id), [
            'is_read' => true,
        ]);

        $patchResp->assertOk()
            ->assertJson([
                'success' => true,
                'id' => $unreadMsg->id,
                'is_read' => true,
                'unread_count' => 2,
                'read_count' => 7,
            ]);

        $this->assertTrue($unreadMsg->fresh()->is_read);
        $this->assertNotNull($unreadMsg->fresh()->read_at);

        // Delete message
        $delResp = $this->actingAs($admin)->delete(route('admin.messages.delete', $unreadMsg->id));
        $delResp->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', ['id' => $unreadMsg->id]);
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(ContactMessageSeeder::class);
        $this->seed(ContactMessageSeeder::class);

        $this->assertSame(9, ContactMessage::count());
    }

    public function test_non_admin_cannot_access_admin_messages(): void
    {
        $customer = User::factory()->create([
            'username' => 'regular_cust_msg',
            'role' => 'customer',
        ]);

        $this->actingAs($customer)
            ->get(route('admin.messages'))
            ->assertRedirect(route('menu'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerProfileTest extends TestCase
{
    use RefreshDatabase;

    private function makePngDataUri(int $w = 16, int $h = 16): string
    {
        $img = imagecreatetruecolor($w, $h);
        $color = imagecolorallocate($img, 255, 160, 0);
        imagefilledrectangle($img, 0, 0, $w, $h, $color);
        ob_start();
        imagepng($img);
        $bin = ob_get_clean();

        return 'data:image/png;base64,'.base64_encode($bin);
    }

    private function makeGifDataUri(): string
    {
        $img = imagecreatetruecolor(8, 8);
        ob_start();
        imagegif($img);
        $bin = ob_get_clean();

        return 'data:image/gif;base64,'.base64_encode($bin);
    }

    public function test_guest_cannot_access_or_update_profile(): void
    {
        $this->get(route('profile.edit'))->assertRedirect(route('login'));

        $this->post(route('profile.update'), ['name' => 'Guest'])
            ->assertRedirect(route('login'));

        $this->post(route('profile.avatar.update'), [
            'avatar_data' => $this->makePngDataUri(),
        ])->assertRedirect(route('login'));
    }

    public function test_profile_link_in_dropdown_is_shown_only_for_regular_users_and_redirects_admin(): void
    {
        $customer = User::factory()->create([
            'name' => 'hugolahh',
            'username' => 'hugolahh',
            'email' => 'user@gmail.com',
            'role' => 'customer',
        ]);
        $admin = User::factory()->admin()->create();

        $customerHome = $this->actingAs($customer)->get('/');
        $customerHome->assertOk();
        $customerHome->assertSee(route('profile.edit'), false);
        $customerHome->assertSee('data-i18n-app="nav_profile"', false);
        $customerHome->assertSee('id="navbar-avatar-input"', false);

        $customerProfile = $this->actingAs($customer)->get(route('profile.edit'));
        $customerProfile->assertOk();
        $customerProfile->assertSee('INFO AKUN &amp; PROFIL', false);
        $customerProfile->assertSee('id="customer-profile-form"', false);
        $customerProfile->assertSee('id="customer-password-form"', false);

        $adminHome = $this->actingAs($admin)->get('/');
        $adminHome->assertOk();
        $adminHome->assertDontSee('data-i18n-app="nav_profile"', false);

        $this->actingAs($admin)
            ->get(route('profile.edit'))
            ->assertRedirect(route('admin.profile'));
    }

    public function test_customer_can_update_profile_avatar_and_password_on_profile_page(): void
    {
        $customer = User::factory()->create([
            'name' => 'hugolahh',
            'username' => 'hugolahh',
            'email' => 'user@gmail.com',
            'role' => 'customer',
            'avatar' => null,
        ]);

        // 1. Update biodata + avatar Data URI
        $res = $this->actingAs($customer)->post(route('profile.update'), [
            'name' => 'Hugo Pratama',
            'email' => 'hugo@gmail.com',
            'phone_number' => '081234567890',
            'address' => 'Banjarbaru Utara',
            'avatar_data' => $this->makePngDataUri(24, 24),
        ]);

        $res->assertRedirect(route('profile.edit'));
        $res->assertSessionHas('success');

        $customer->refresh();
        $this->assertSame('Hugo Pratama', $customer->name);
        $this->assertSame('hugo@gmail.com', $customer->email);
        $this->assertSame('0812-3456-7890', $customer->phone_number);
        $this->assertSame('Banjarbaru Utara', $customer->address);
        $this->assertStringStartsWith('data:image/png;base64,', (string) $customer->avatar);

        // 2. Update password via Form 2 (matching admin profile flow)
        $resPass = $this->actingAs($customer)->post(route('profile.update'), [
            'name' => 'Hugo Pratama',
            'email' => 'hugo@gmail.com',
            'password' => 'NewSecret123',
            'password_confirmation' => 'NewSecret123',
        ]);

        $resPass->assertRedirect(route('login'));
        $resPass->assertSessionHas('status');
        $this->assertTrue(Hash::check('NewSecret123', $customer->refresh()->password));
    }

    public function test_customer_can_update_avatar_directly_from_navbar_and_rejects_invalid_files(): void
    {
        $customer = User::factory()->create([
            'name' => 'hugolahh',
            'username' => 'hugolahh',
            'email' => 'user@gmail.com',
            'role' => 'customer',
            'avatar' => null,
        ]);

        $jpgFile = UploadedFile::fake()->image('avatar.jpg', 120, 120);
        $this->actingAs($customer)
            ->postJson(route('profile.avatar.update'), ['avatar' => $jpgFile])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertStringStartsWith('data:image/jpeg;base64,', (string) $customer->refresh()->avatar);

        $this->actingAs($customer)
            ->postJson(route('profile.avatar.update'), ['avatar_data' => $this->makeGifDataUri()])
            ->assertStatus(422)
            ->assertJson(['success' => false]);

        $webpFile = UploadedFile::fake()->create('avatar.webp', 10, 'image/webp');
        $this->actingAs($customer)
            ->post(route('profile.update'), [
                'name' => 'hugolahh',
                'email' => 'user@gmail.com',
                'avatar' => $webpFile,
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors(['avatar']);
    }
}

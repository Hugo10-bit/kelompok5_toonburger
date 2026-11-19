<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_wrong_password_casing(): void
    {
        $user = User::factory()->create([
            'username' => 'admin_case_test',
            'password' => Hash::make('Password123'),
        ]);

        $this->post('/login', [
            'email' => 'admin_case_test',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $user->refresh();
        $this->assertTrue(Hash::check('Password123', $user->password));
        $this->assertFalse(Hash::check('password123', $user->password));
    }

    public function test_users_can_not_authenticate_with_common_fallback_passwords(): void
    {
        $user = User::factory()->create([
            'username' => 'admin_fallback_test',
            'password' => Hash::make('Password123'),
        ]);

        foreach (['password', 'admin123', 'admin', '123456'] as $weakPassword) {
            $this->post('/login', [
                'email' => 'admin_fallback_test',
                'password' => $weakPassword,
            ]);

            $this->assertGuest();
        }

        $this->assertTrue(Hash::check('Password123', $user->refresh()->password));
    }

    public function test_users_can_authenticate_with_exact_case_sensitive_password(): void
    {
        $user = User::factory()->create([
            'username' => 'admin_exact_test',
            'password' => Hash::make('Password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin_exact_test',
            'password' => 'Password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}

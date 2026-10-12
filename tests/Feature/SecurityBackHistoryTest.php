<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityBackHistoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that web routes contain anti-cache headers preventing back button caching.
     */
    public function test_web_routes_have_prevent_back_history_headers(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $this->assertStringContainsString('no-cache', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('must-revalidate', $response->headers->get('Cache-Control'));
        $this->assertEquals('no-cache', $response->headers->get('Pragma'));
    }

    /**
     * Test that guest accessing admin dashboard is redirected to login.
     */
    public function test_guest_accessing_admin_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /**
     * Test that guest accessing pos is redirected to login.
     */
    public function test_guest_accessing_pos_is_redirected_to_login(): void
    {
        $response = $this->get('/pos');

        $response->assertRedirect('/login');
    }

    /**
     * Test that guest accessing my-orders is redirected to login.
     */
    public function test_guest_accessing_my_orders_is_redirected_to_login(): void
    {
        $response = $this->get('/my-orders');

        $response->assertRedirect('/login');
    }

    /**
     * Test that guest accessing dashboard is redirected to login.
     */
    public function test_guest_accessing_dashboard_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test logout redirects to login with anti-cache headers and revokes access on back navigation.
     */
    public function test_logout_redirects_and_prevents_back_history(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        // Subsequent access to protected admin route as unauthenticated guest must redirect to login
        $followResponse = $this->get('/admin');
        $followResponse->assertRedirect('/login');
    }
}

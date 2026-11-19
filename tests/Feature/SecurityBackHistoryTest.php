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
        $this->assertEquals('SAMEORIGIN', $response->headers->get('X-Frame-Options'));
        $this->assertEquals('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertEquals('strict-origin-when-cross-origin', $response->headers->get('Referrer-Policy'));
        $this->assertEquals("frame-ancestors 'self'", $response->headers->get('Content-Security-Policy'));
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

    public function test_public_product_endpoint_redacts_reviewer_pii_and_hides_unavailable_products(): void
    {
        $reviewer = User::factory()->create([
            'name' => 'Budi Reviewer',
            'email' => 'budi-secret@example.com',
            'phone_number' => '081299998888',
            'address' => 'Jl. Rahasia No. 1',
            'role' => 'customer',
        ]);
        $category = \App\Models\Category::create([
            'name' => 'Beef Burger',
            'slug' => 'beef-burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'name' => 'Classic Beef',
            'slug' => 'classic-beef',
            'price' => 35000,
            'is_available' => true,
        ]);
        $order = \App\Models\Order::create([
            'order_number' => 'TB-20261119-0001',
            'user_id' => $reviewer->id,
            'order_type' => 'takeaway',
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'qris',
            'subtotal' => 35000,
            'tax_amount' => 3850,
            'discount_amount' => 0,
            'total_amount' => 38850,
            'customer_name' => 'Budi Reviewer',
            'customer_phone' => '081299998888',
        ]);
        \App\Models\Review::create([
            'user_id' => $reviewer->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Mantap!',
        ]);

        $res = $this->getJson(route('product.show', $product->id));
        $res->assertOk();
        $reviewUser = $res->json('product.reviews.0.user');
        $this->assertSame('Budi Reviewer', $reviewUser['name'] ?? null);
        $this->assertArrayNotHasKey('email', $reviewUser);
        $this->assertArrayNotHasKey('phone_number', $reviewUser);
        $this->assertArrayNotHasKey('address', $reviewUser);
        $this->assertArrayNotHasKey('role', $reviewUser);

        $product->update(['is_available' => false]);
        $this->getJson(route('product.show', $product->id))->assertNotFound();
    }

    public function test_orphaned_null_user_order_cannot_be_accessed_by_unrelated_customer(): void
    {
        $stranger = User::factory()->create(['role' => 'customer']);
        $orphanedOrder = \App\Models\Order::create([
            'order_number' => 'TB-20261119-9999',
            'user_id' => null,
            'order_type' => 'takeaway',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'qris',
            'subtotal' => 30000,
            'tax_amount' => 3300,
            'discount_amount' => 0,
            'total_amount' => 33300,
            'customer_name' => 'Deleted Customer',
            'customer_phone' => '0811111111',
        ]);

        $this->actingAs($stranger)
            ->get(route('orders.show', $orphanedOrder->order_number))
            ->assertForbidden();
    }
}

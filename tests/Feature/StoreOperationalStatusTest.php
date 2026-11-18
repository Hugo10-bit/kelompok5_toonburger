<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreOperationalStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_close_and_reopen_store_and_blocking_enforces_no_orders_when_closed(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $category = Category::create([
            'name' => 'Cheese Burger',
            'slug' => 'cheese-burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Very Cheese Burger',
            'slug' => 'very-cheese-burger',
            'description' => 'Cheesy double patty burger',
            'price' => 35000,
            'image' => 'images/products/very-cheese-burger.png',
            'is_available' => true,
        ]);

        // Admin sidebar shows Status Operasional widget & Tutup Toko modal
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Status Operasional')
            ->assertSee('BUKA')
            ->assertSee('Tutup Toko Sekarang?')
            ->assertSee('Sudah Jam Tutup');

        // Non-admin customer cannot toggle store status
        $this->actingAs($customer)
            ->post(route('admin.store.status'), [
                'is_open' => 0,
                'closed_reason' => 'Tutup Mendadak',
            ])
            ->assertRedirect(route('menu'));

        $this->assertTrue(StoreSetting::current()->is_open);

        // Customer adds item while open so we also test existing-cart checkout blocking after close
        $this->actingAs($customer)
            ->postJson(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 1,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        // Admin closes outlet with quick reason
        $this->actingAs($admin)
            ->post(route('admin.store.status'), [
                'is_open' => 0,
                'closed_reason' => 'Sudah Jam Tutup',
            ])
            ->assertRedirect();

        $setting = StoreSetting::current();
        $this->assertFalse($setting->is_open);
        $this->assertSame('Sudah Jam Tutup', $setting->displayReason());

        // Admin UI reflects TUTUP state
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('TUTUP')
            ->assertSee('Buka Toko');

        // Public pages display closed notice banner and lock CTA
        $this->actingAs($customer)
            ->get(route('menu'))
            ->assertOk()
            ->assertSee('Outlet Sedang Tutup (Sudah Jam Tutup)')
            ->assertSee('Outlet Sedang Tutup');

        // Cart add blocked with 423 while closed
        $this->actingAs($customer)
            ->postJson(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 1,
            ])
            ->assertStatus(423)
            ->assertJsonPath('store_closed', true)
            ->assertJsonPath('closed_reason', 'Sudah Jam Tutup');

        // Increasing cart quantity blocked with 423 while closed
        $cart = session('cart');
        $cartKey = array_key_first($cart);
        $this->actingAs($customer)
            ->postJson(route('cart.update'), [
                'cart_key' => $cartKey,
                'quantity' => 3,
            ])
            ->assertStatus(423)
            ->assertJsonPath('store_closed', true);

        // Decreasing/removing cart item stays allowed
        $this->actingAs($customer)
            ->postJson(route('cart.update'), [
                'cart_key' => $cartKey,
                'quantity' => 1,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        // Checkout GET & POST blocked cleanly when closed
        $this->actingAs($customer)
            ->get(route('orders.checkout'))
            ->assertRedirect(route('menu'))
            ->assertSessionHas('error');

        $this->actingAs($customer)
            ->post(route('orders.store'), [
                'order_type' => 'takeaway',
                'customer_name' => 'Rizky',
                'customer_phone' => '085780153872',
                'payment_method' => 'cash',
            ])
            ->assertRedirect(route('menu'))
            ->assertSessionHas('error');

        $this->assertSame(0, Order::count());

        // Admin reopens the outlet
        $this->actingAs($admin)
            ->post(route('admin.store.status'), [
                'is_open' => 1,
            ])
            ->assertRedirect();

        $this->assertTrue(StoreSetting::current()->is_open);

        // Customer can add to cart and checkout again
        $this->actingAs($customer)
            ->postJson(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 1,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($customer)
            ->post(route('orders.store'), [
                'order_type' => 'takeaway',
                'customer_name' => 'Rizky',
                'customer_phone' => '085780153872',
                'payment_method' => 'cash',
            ])
            ->assertRedirect();

        $this->assertSame(1, Order::count());
    }
}

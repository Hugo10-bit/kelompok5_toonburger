<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BugFixesRegressionTest extends TestCase
{
    use RefreshDatabase;

    private function makePngDataUri(int $w = 10, int $h = 10): string
    {
        $img = imagecreatetruecolor($w, $h);
        $bg = imagecolorallocate($img, 222, 59, 40);
        imagefill($img, 0, 0, $bg);
        ob_start();
        imagepng($img);
        $binary = ob_get_clean();

        return 'data:image/png;base64,' . base64_encode($binary);
    }

    public function test_uploaded_data_uri_image_is_not_overridden_by_static_slug_asset(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create([
            'name' => 'Beef',
            'slug' => 'beef',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Slug matches existing public/images/products/beef-burger.png
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Beef Burger',
            'slug' => 'beef-burger',
            'price' => 30000,
            'is_available' => true,
            'image' => 'images/products/beef-burger.png',
        ]);

        $newDataUri = $this->makePngDataUri(14, 14);

        $this->actingAs($admin)
            ->post(route('admin.products.update', $product->id), [
                'name' => 'Beef Burger',
                'category_id' => $category->id,
                'price' => 32000,
                'is_available' => 1,
                'image_data' => $newDataUri,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $product->refresh();
        $this->assertStringStartsWith('data:image/png;base64,', $product->image);
        $this->assertSame($product->image, $product->image_url);

        $imgRes = $this->get(route('product.image', $product->id));
        $imgRes->assertOk();
        $imgRes->assertHeader('Content-Type', 'image/png');
        $expectedBinary = base64_decode(explode(',', $product->image, 2)[1], true);
        $this->assertSame($expectedBinary, $imgRes->getContent());
    }

    public function test_cart_prunes_unavailable_soft_deleted_and_inactive_category_products(): void
    {
        $customer = User::factory()->create();
        $activeCat = Category::create(['name' => 'Active', 'slug' => 'active', 'is_active' => true, 'sort_order' => 1]);
        $inactiveCat = Category::create(['name' => 'Inactive', 'slug' => 'inactive', 'is_active' => false, 'sort_order' => 2]);

        $validProduct = Product::create([
            'category_id' => $activeCat->id,
            'name' => 'Valid Burger',
            'slug' => 'valid-burger',
            'price' => 25000,
            'is_available' => true,
        ]);
        $unavailableProduct = Product::create([
            'category_id' => $activeCat->id,
            'name' => 'Sold Out Burger',
            'slug' => 'sold-out-burger',
            'price' => 25000,
            'is_available' => false,
        ]);
        $deletedProduct = Product::create([
            'category_id' => $activeCat->id,
            'name' => 'Deleted Burger',
            'slug' => 'deleted-burger',
            'price' => 25000,
            'is_available' => true,
        ]);
        $deletedProduct->delete();

        $inactiveCatProduct = Product::create([
            'category_id' => $inactiveCat->id,
            'name' => 'Hidden Category Burger',
            'slug' => 'hidden-cat-burger',
            'price' => 25000,
            'is_available' => true,
        ]);

        $res = $this->actingAs($customer)
            ->withSession([
                'cart' => [
                    'valid' => ['product_id' => $validProduct->id, 'quantity' => 1, 'options' => [], 'notes' => ''],
                    'soldout' => ['product_id' => $unavailableProduct->id, 'quantity' => 2, 'options' => [], 'notes' => ''],
                    'deleted' => ['product_id' => $deletedProduct->id, 'quantity' => 1, 'options' => [], 'notes' => ''],
                    'inactive' => ['product_id' => $inactiveCatProduct->id, 'quantity' => 1, 'options' => [], 'notes' => ''],
                ],
            ])
            ->getJson(route('cart.index'));

        $res->assertOk();
        $res->assertJsonCount(1, 'items');
        $res->assertJsonPath('items.0.product_id', $validProduct->id);
        $this->assertSame(['valid'], array_keys(session('cart')));
    }

    public function test_reorder_skips_soft_deleted_unavailable_and_inactive_category_products(): void
    {
        $customer = User::factory()->create();
        $activeCat = Category::create(['name' => 'Burgers', 'slug' => 'burgers', 'is_active' => true, 'sort_order' => 1]);
        $inactiveCat = Category::create(['name' => 'Archived', 'slug' => 'archived', 'is_active' => false, 'sort_order' => 2]);

        $good = Product::create(['category_id' => $activeCat->id, 'name' => 'Good Burger', 'slug' => 'good-burger', 'price' => 30000, 'is_available' => true]);
        $deleted = Product::create(['category_id' => $activeCat->id, 'name' => 'Old Burger', 'slug' => 'old-burger', 'price' => 30000, 'is_available' => true]);
        $hidden = Product::create(['category_id' => $inactiveCat->id, 'name' => 'Hidden Burger', 'slug' => 'hidden-burger', 'price' => 30000, 'is_available' => true]);

        $order = Order::create([
            'order_number' => 'TB-REORDER-001',
            'user_id' => $customer->id,
            'order_type' => 'takeaway',
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'qris',
            'subtotal' => 90000,
            'tax_amount' => 9900,
            'discount_amount' => 0,
            'total_amount' => 99900,
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
        ]);

        OrderItem::create(['order_id' => $order->id, 'product_id' => $good->id, 'product_name' => $good->name, 'price' => 30000, 'quantity' => 2, 'subtotal' => 60000]);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $deleted->id, 'product_name' => $deleted->name, 'price' => 30000, 'quantity' => 1, 'subtotal' => 30000]);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $hidden->id, 'product_name' => $hidden->name, 'price' => 30000, 'quantity' => 1, 'subtotal' => 30000]);

        $deleted->delete();

        $this->actingAs($customer)
            ->post(route('orders.reorder', $order->order_number))
            ->assertRedirect(route('orders.checkout'));

        $cart = session('cart');
        $this->assertCount(1, $cart);
        $entry = array_values($cart)[0];
        $this->assertSame($good->id, $entry['product_id']);
        $this->assertSame(2, $entry['quantity']);
    }

    public function test_cancelled_paid_order_cannot_be_reviewed(): void
    {
        $customer = User::factory()->create();
        $cat = Category::create(['name' => 'Burgers', 'slug' => 'burgers', 'is_active' => true, 'sort_order' => 1]);
        $product = Product::create(['category_id' => $cat->id, 'name' => 'Test Burger', 'slug' => 'test-burger', 'price' => 30000, 'is_available' => true]);

        $order = Order::create([
            'order_number' => 'TB-CANCEL-001',
            'user_id' => $customer->id,
            'order_type' => 'takeaway',
            'status' => 'cancelled',
            'payment_status' => 'paid',
            'payment_method' => 'qris',
            'subtotal' => 30000,
            'tax_amount' => 3300,
            'discount_amount' => 0,
            'total_amount' => 33300,
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
        ]);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'product_name' => $product->name, 'price' => 30000, 'quantity' => 1, 'subtotal' => 30000]);

        $this->actingAs($customer)
            ->from(route('orders.show', $order->order_number))
            ->post(route('orders.review', $order->order_number), [
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Should be rejected',
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_product_in_inactive_category_is_not_accessible_via_product_show(): void
    {
        $inactiveCat = Category::create(['name' => 'Hidden', 'slug' => 'hidden', 'is_active' => false, 'sort_order' => 1]);
        $product = Product::create([
            'category_id' => $inactiveCat->id,
            'name' => 'Secret Burger',
            'slug' => 'secret-burger',
            'price' => 35000,
            'is_available' => true,
        ]);

        $this->getJson(route('product.show', $product->id))->assertNotFound();
    }

    public function test_admin_update_product_preserves_optional_metadata_when_omitted(): void
    {
        $admin = User::factory()->admin()->create();
        $cat = Category::create(['name' => 'Burgers', 'slug' => 'burgers', 'is_active' => true, 'sort_order' => 1]);
        $product = Product::create([
            'category_id' => $cat->id,
            'name' => 'Mega Burger',
            'slug' => 'mega-burger',
            'price' => 45000,
            'original_price' => 55000,
            'calories' => 680,
            'prep_time_minutes' => 15,
            'is_available' => true,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.products.update', $product->id), [
                'name' => 'Mega Burger Deluxe',
                'category_id' => $cat->id,
                'price' => 48000,
                'is_available' => 1,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $product->refresh();
        $this->assertSame('Mega Burger Deluxe', $product->name);
        $this->assertSame(55000.0, (float) $product->original_price);
        $this->assertSame(680, $product->calories);
        $this->assertSame(15, $product->prep_time_minutes);
    }

    public function test_admin_profile_can_clear_phone_and_address(): void
    {
        $admin = User::factory()->admin()->create([
            'phone_number' => '081234567890',
            'address' => 'Jl. Panglima Batur No. 1',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'phone_number' => '',
                'address' => '',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $admin->refresh();
        $this->assertNull($admin->phone_number);
        $this->assertNull($admin->address);
    }

    public function test_admin_trashed_products_view_includes_products_from_trashed_categories(): void
    {
        $admin = User::factory()->admin()->create();
        $cat = Category::create(['name' => 'Temp Cat', 'slug' => 'temp-cat', 'is_active' => true, 'sort_order' => 1]);
        $product = Product::create([
            'category_id' => $cat->id,
            'name' => 'Orphaned Trashed Burger',
            'slug' => 'orphaned-trashed-burger',
            'price' => 28000,
            'is_available' => true,
        ]);

        $product->delete();
        $cat->delete();

        $res = $this->actingAs($admin)->get(route('admin.products', ['filter' => 'trashed']));
        $res->assertOk();
        $res->assertSee('Orphaned Trashed Burger');
    }

    public function test_admin_slug_generation_handles_duplicates_and_symbol_only_names(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), ['name' => '!!!', 'is_active' => 1])->assertRedirect();
        $this->actingAs($admin)->post(route('admin.categories.store'), ['name' => '???', 'is_active' => 1])->assertRedirect();

        $categories = Category::orderBy('id')->get();
        $this->assertCount(2, $categories);
        $this->assertNotSame($categories[0]->slug, $categories[1]->slug);
        $this->assertNotEmpty($categories[0]->slug);
        $this->assertNotEmpty($categories[1]->slug);

        $catId = $categories[0]->id;
        $this->actingAs($admin)->post(route('admin.products.store'), ['name' => 'Burger X', 'category_id' => $catId, 'price' => 20000, 'is_available' => 1])->assertRedirect();
        $this->actingAs($admin)->post(route('admin.products.store'), ['name' => 'Burger X', 'category_id' => $catId, 'price' => 22000, 'is_available' => 1])->assertRedirect();

        $products = Product::orderBy('id')->get();
        $this->assertCount(2, $products);
        $this->assertNotSame($products[0]->slug, $products[1]->slug);
    }

    public function test_admin_delete_and_restore_contact_message_preserves_timestamps(): void
    {
        $admin = User::factory()->admin()->create();
        $msg = ContactMessage::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'message' => 'Halo Toon Burger!',
            'is_read' => true,
            'read_at' => now(),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.messages'))
            ->delete(route('admin.messages.delete', $msg->id))
            ->assertRedirect(route('admin.messages'))
            ->assertSessionHas('undo_action');

        $this->assertDatabaseMissing('contact_messages', ['id' => $msg->id]);

        $this->actingAs($admin)
            ->from(route('admin.messages'))
            ->post(route('admin.messages.restore', $msg->id))
            ->assertRedirect(route('admin.messages'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'id' => $msg->id,
            'email' => 'budi@example.com',
            'is_read' => true,
        ]);
    }

    public function test_admin_pages_wrap_modals_for_pjax_and_order_receipt_shows_ppn_and_wita(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create();

        $adminProductsRes = $this->actingAs($admin)->get(route('admin.products'));
        $adminProductsRes->assertOk();
        $adminProductsRes->assertSee('id="admin-page-modals"', false);
        $adminProductsRes->assertSee('id="productModal"', false);

        $order = Order::create([
            'order_number' => 'TB-WITA-001',
            'user_id' => $customer->id,
            'order_type' => 'takeaway',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'cash',
            'subtotal' => 50000,
            'tax_amount' => 5500,
            'discount_amount' => 0,
            'total_amount' => 55500,
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
        ]);
        $order->forceFill(['created_at' => Carbon::create(2026, 6, 15, 2, 30, 0, 'UTC')])->save();

        $orderShowRes = $this->actingAs($customer)->get(route('orders.show', $order->order_number));
        $orderShowRes->assertOk();
        $orderShowRes->assertSee('Pajak PPN (11%):');
        $orderShowRes->assertDontSee('Pajak Restoran PB1 (10%):');
        // 02:30 UTC == 10:30 WITA (Asia/Makassar, UTC+8)
        $orderShowRes->assertSee('15 Jun 2026, 10:30 WITA');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUndoDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_product_and_undo_restores_it(): void
    {
        $admin = User::factory()->admin()->create();

        $category = Category::create([
            'name' => 'Burger',
            'slug' => 'burger',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Crispy Chicken Toon',
            'slug' => 'crispy-chicken-toon',
            'price' => 38000,
            'is_available' => true,
        ]);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'deleted_at' => null]);

        // 1. Delete product
        $deleteRes = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->delete(route('admin.products.delete', $product->id));

        $deleteRes->assertRedirect(route('admin.products'));
        $deleteRes->assertSessionHas('success');
        $deleteRes->assertSessionHas('undo_action');

        $undoAction = session('undo_action');
        $this->assertEquals('product', $undoAction['type']);
        $this->assertEquals($product->id, $undoAction['id']);
        $this->assertEquals(route('admin.products.restore', $product->id), $undoAction['url']);

        $this->assertSoftDeleted('products', ['id' => $product->id]);

        // 2. Undo / Restore product
        $restoreRes = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->post(route('admin.products.restore', $product->id));

        $restoreRes->assertRedirect(route('admin.products'));
        $restoreRes->assertSessionHas('success', "Menu 'Crispy Chicken Toon' berhasil dipulihkan!");

        $this->assertDatabaseHas('products', ['id' => $product->id, 'deleted_at' => null]);
    }

    public function test_admin_can_delete_category_and_undo_restores_it(): void
    {
        $admin = User::factory()->admin()->create();

        $category = Category::create([
            'name' => 'Dessert',
            'slug' => 'dessert',
            'is_active' => true,
            'sort_order' => 9,
        ]);

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);

        // 1. Delete empty category
        $deleteRes = $this->actingAs($admin)
            ->from(route('admin.categories'))
            ->delete(route('admin.categories.delete', $category->id));

        $deleteRes->assertRedirect(route('admin.categories'));
        $deleteRes->assertSessionHas('success');
        $deleteRes->assertSessionHas('undo_action');

        $undoAction = session('undo_action');
        $this->assertEquals('category', $undoAction['type']);
        $this->assertEquals($category->id, $undoAction['id']);
        $this->assertEquals(route('admin.categories.restore', $category->id), $undoAction['url']);

        $this->assertSoftDeleted('categories', ['id' => $category->id]);

        // 2. Undo / Restore category
        $restoreRes = $this->actingAs($admin)
            ->from(route('admin.categories'))
            ->post(route('admin.categories.restore', $category->id));

        $restoreRes->assertRedirect(route('admin.categories'));
        $restoreRes->assertSessionHas('success', "Kategori 'Dessert' berhasil dipulihkan!");

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $admin = User::factory()->admin()->create();

        $category = Category::create([
            'name' => 'Burger',
            'slug' => 'burger',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Beef Burger',
            'slug' => 'beef-burger',
            'price' => 29000,
            'is_available' => true,
        ]);

        $res = $this->actingAs($admin)
            ->from(route('admin.categories'))
            ->delete(route('admin.categories.delete', $category->id));

        $res->assertRedirect(route('admin.categories'));
        $res->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
    }

    public function test_guest_or_regular_user_cannot_restore_products_or_categories(): void
    {
        $regularUser = User::factory()->create();

        $category = Category::create([
            'name' => 'Sides',
            'slug' => 'sides',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'French Fries',
            'slug' => 'french-fries',
            'price' => 18000,
            'is_available' => true,
        ]);

        $product->delete();
        $category->delete();

        // Guest restore attempts
        $this->post(route('admin.products.restore', $product->id))->assertRedirect(route('login'));
        $this->post(route('admin.categories.restore', $category->id))->assertRedirect(route('login'));
        $this->post(route('admin.messages.restore', 999))->assertRedirect(route('login'));

        // Regular user restore attempts
        $this->actingAs($regularUser)->post(route('admin.products.restore', $product->id))->assertRedirect(route('menu'));
        $this->actingAs($regularUser)->post(route('admin.categories.restore', $category->id))->assertRedirect(route('menu'));
        $this->actingAs($regularUser)->post(route('admin.messages.restore', 999))->assertRedirect(route('menu'));
    }

    public function test_admin_can_delete_message_and_undo_restores_it(): void
    {
        $admin = User::factory()->admin()->create();

        $message = \App\Models\ContactMessage::create([
            'name' => 'Peter Parker',
            'email' => 'budisantoso@gmail.com',
            'phone' => '0813-6767-6767',
            'message' => 'Zixus X Rakha, Minta Game GTA 6 sama PS5 PRO SLIM',
            'is_read' => true,
        ]);

        $this->assertDatabaseHas('contact_messages', ['id' => $message->id]);

        // 1. Delete message
        $deleteRes = $this->actingAs($admin)
            ->from(route('admin.messages'))
            ->delete(route('admin.messages.delete', $message->id));

        $deleteRes->assertRedirect(route('admin.messages'));
        $deleteRes->assertSessionHas('success');
        $deleteRes->assertSessionHas('undo_action');

        $undoAction = session('undo_action');
        $this->assertEquals('message', $undoAction['type']);
        $this->assertEquals($message->id, $undoAction['id']);
        $this->assertEquals(route('admin.messages.restore', $message->id), $undoAction['url']);

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);

        // 2. Undo restore
        $restoreRes = $this->actingAs($admin)
            ->from(route('admin.messages'))
            ->post(route('admin.messages.restore', $message->id));

        $restoreRes->assertRedirect(route('admin.messages'));
        $restoreRes->assertSessionHas('success', "Pesan dari 'Peter Parker' berhasil dipulihkan!");

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'name' => 'Peter Parker',
            'message' => 'Zixus X Rakha, Minta Game GTA 6 sama PS5 PRO SLIM',
        ]);
    }
}

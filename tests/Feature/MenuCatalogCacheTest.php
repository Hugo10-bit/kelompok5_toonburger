<?php

namespace Tests\Feature;

use App\Http\Controllers\MenuController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MenuCatalogCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_caches_catalog_filters_cleanly_and_invalidates_on_product_update(): void
    {
        $category = Category::create([
            'name' => 'Cheese Burger',
            'slug' => 'cheese-burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $otherCategory = Category::create([
            'name' => 'Hot Dog',
            'slug' => 'hot-dog',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $burger = Product::create([
            'category_id' => $category->id,
            'name' => 'Alpha Cheese Melt',
            'slug' => 'alpha-cheese-melt',
            'description' => 'Keju cheddar leleh ganda.',
            'price' => 35000,
            'image' => 'images/products/very-cheese-burger.png',
            'is_available' => true,
        ]);

        Product::create([
            'category_id' => $otherCategory->id,
            'name' => 'Classic Hotdog',
            'slug' => 'classic-hotdog',
            'description' => 'Sosis panggang gurih.',
            'price' => 25000,
            'image' => 'images/products/classic-hotdog.png',
            'is_available' => true,
        ]);

        $this->assertFalse(Cache::has(MenuController::CATALOG_CACHE_KEY));

        $this->get('/menu')
            ->assertOk()
            ->assertSee('Alpha Cheese Melt')
            ->assertSee('Classic Hotdog');

        $this->assertTrue(Cache::has(MenuController::CATALOG_CACHE_KEY));

        $this->get('/menu?category=hot-dog')
            ->assertOk()
            ->assertSee('Classic Hotdog')
            ->assertDontSee('Alpha Cheese Melt');

        $this->getJson('/search-menu?q=Alpha')
            ->assertOk()
            ->assertJsonFragment(['name' => 'Alpha Cheese Melt']);

        $burger->update(['name' => 'Mega Cheese Melt']);

        $this->assertFalse(Cache::has(MenuController::CATALOG_CACHE_KEY));

        $this->get('/menu')
            ->assertOk()
            ->assertSee('Mega Cheese Melt');
    }
}

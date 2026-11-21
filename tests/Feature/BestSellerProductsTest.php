<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestSellerProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_always_displays_four_best_seller_products_even_if_fewer_are_featured(): void
    {
        $category = Category::create([
            'name' => 'Burgers',
            'slug' => 'burgers',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create 5 available products, but only 3 are marked is_featured = true
        for ($i = 1; $i <= 5; $i++) {
            Product::create([
                'id' => $i,
                'name' => "Product $i",
                'slug' => "product-$i",
                'category_id' => $category->id,
                'description' => "Enak dan lezat $i",
                'price' => 30000 + ($i * 1000),
                'calories' => 300,
                'is_available' => true,
                'is_featured' => ($i <= 3), // Only 3 featured
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertStatus(200);

        // Verify that the view receives exactly 4 bestSellers
        $bestSellers = $response->viewData('bestSellers');
        $this->assertCount(4, $bestSellers);
    }
}

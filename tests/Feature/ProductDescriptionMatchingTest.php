<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDescriptionMatchingTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_seeded_products_have_accurate_descriptions_matching_images(): void
    {
        $this->seed(DatabaseSeeder::class);

        $hotdogs = Product::where('name', 'like', '%Hotdog%')->get();
        $this->assertNotEmpty($hotdogs);
        foreach ($hotdogs as $hd) {
            $this->assertStringNotContainsString('Burger dengan patty daging', $hd->description);
            $this->assertStringContainsString('hotdog', strtolower($hd->description));
        }

        $chickens = Product::where('name', 'like', '%Chicken%')->get();
        $this->assertNotEmpty($chickens);
        foreach ($chickens as $ch) {
            $this->assertStringNotContainsString('Burger dengan patty daging yang juicy,', $ch->description);
            $this->assertStringContainsString('ayam', strtolower($ch->description));
        }

        $bbq = Product::where('name', 'like', '%BBQ%')->first();
        $this->assertNotNull($bbq);
        $this->assertStringContainsString('BBQ', $bbq->description);

        $cheese = Product::where('name', 'like', '%Cheese%')->get();
        $this->assertNotEmpty($cheese);
        foreach ($cheese as $cz) {
            $this->assertStringContainsString('keju', strtolower($cz->description));
        }
    }
}

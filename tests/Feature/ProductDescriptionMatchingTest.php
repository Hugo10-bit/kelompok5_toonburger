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

        // Test drink and snack fallback resolution
        $tea = new Product([
            'id' => 20,
            'name' => 'Lyce Tea',
            'slug' => 'lyce-tea',
            'description' => 'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel lezat, keju cheddar meleleh, dan bawang bombay panggang yang renyah.',
            'image' => 'data:image/jpeg;base64,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',
        ]);
        $this->assertStringNotContainsString('Beef patty', $tea->description);
        $this->assertStringContainsString('leci', strtolower($tea->description));

        $fries = new Product([
            'id' => 22,
            'name' => 'French Fries',
            'slug' => 'french-fries',
            'description' => 'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel lezat, keju cheddar meleleh, dan bawang bombay panggang yang renyah.',
            'image' => 'data:image/jpeg;base64,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',
        ]);
        $this->assertStringNotContainsString('Beef patty', $fries->description);
        $this->assertStringContainsString('kentang', strtolower($fries->description));

        // Test Chicken Wings resolution
        $wings = new Product([
            'id' => 24,
            'name' => 'Hot Chicken Wings',
            'slug' => 'hot-chicken-wings',
            'description' => '6 Potong Ayam Dan Saus Pedas Ala Toon',
        ]);
        $this->assertStringContainsString('sayap ayam', strtolower($wings->description));
        $this->assertStringContainsString('pedas', strtolower($wings->description));
    }
}

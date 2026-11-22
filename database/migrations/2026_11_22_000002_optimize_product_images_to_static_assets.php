<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Replaces embedded base64 data URIs with lightweight static asset paths.
     */
    public function up(): void
    {
        $map = [
            'soda' => 'images/products/soda.jpg',
            'soft-drink' => 'images/products/soda.jpg',
            'taro' => 'images/products/taro.jpg',
            'matcha' => 'images/products/matcha.jpg',
            'red-velvet' => 'images/products/red-velvet.jpg',
            'kopi-susu' => 'images/products/kopi-susu.jpg',
            'kopi-gula-aren' => 'images/products/kopi-gula-aren.jpg',
            'salted-caramel' => 'images/products/salted-caramel.jpg',
            'lycee-tea' => 'images/products/lycee-tea.jpg',
            'lyce-tea' => 'images/products/lycee-tea.jpg',
            'cotton-candy' => 'images/products/cotton-candy.jpg',
            'french-fries' => 'images/products/french-fries.jpg',
            'chessy-french-fries' => 'images/products/chessy-french-fries.jpg',
        ];

        foreach ($map as $slug => $path) {
            DB::table('products')
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug)
                      ->orWhere('slug', 'like', "%{$slug}%");
                })
                ->where('image', 'like', 'data:image%')
                ->update(['image' => $path]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed for static path optimization
    }
};

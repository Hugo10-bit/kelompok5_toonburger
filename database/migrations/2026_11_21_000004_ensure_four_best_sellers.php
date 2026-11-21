<?php

use App\Http\Controllers\MenuController;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Pastikan Very Cheese Burger (id 1) aktif & dijadikan featured/best seller
        DB::table('products')
            ->where('id', 1)
            ->orWhere('slug', 'very-cheese-burger')
            ->update([
                'is_featured' => true,
                'is_available' => true,
            ]);

        // 2. Pastikan 4 signature best sellers (1: Very Cheese Burger, 4: Double Cheese Burger, 5: Hot Chicken Burger, 8: Meat Cheesy Hotdog) aktif & featured
        $bestSellerIds = [1, 4, 5, 8];
        DB::table('products')
            ->whereIn('id', $bestSellerIds)
            ->update([
                'is_featured' => true,
                'is_available' => true,
            ]);

        // 3. Reset catalog cache agar perubahan langsung termuat
        Cache::forget(MenuController::CATALOG_CACHE_KEY);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};

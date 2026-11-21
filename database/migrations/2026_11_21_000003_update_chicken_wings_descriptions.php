<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        $wingsDescriptions = [
            24 => '6 potong sayap ayam goreng krispi renyah berbalut lumuran saus pedas spesial ala Toon Burger yang gurih, membakar lidah, dan nagih.',
            25 => '6 potong sayap ayam krispi keemasan berselimut saus smokey BBQ karamel gurih manis dengan aroma rempah panggang istimewa.',
        ];

        foreach ($wingsDescriptions as $id => $desc) {
            DB::table('products')->where('id', $id)->update(['description' => $desc]);
        }

        DB::table('products')
            ->whereRaw('LOWER(name) LIKE ?', ['%hot%wing%'])
            ->update(['description' => $wingsDescriptions[24]]);

        DB::table('products')
            ->whereRaw('LOWER(name) LIKE ?', ['%bbq%wing%'])
            ->update(['description' => $wingsDescriptions[25]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

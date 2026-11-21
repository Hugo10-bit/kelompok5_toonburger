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

        $descriptions = [
            1 => 'Dua lapis beef patty juicy dengan lelehan keju cheddar ganda berlimpah, bawang bombay karamel gurih manis, dan saus spesial Toon Burger di dalam bun brioche mentega hangat.',
            2 => 'Patty daging sapi pilihan 100% dipanggang sempurna dengan aroma asap khas, disajikan dengan selada segar, tomat renyah, acar timun, dan saus istimewa Toon Burger.',
            3 => 'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel lezat, keju cheddar meleleh, dan bawang bombay panggang yang renyah.',
            4 => 'Dua patty daging sapi panggang tebal dan juicy dengan limpahan keju cheddar ganda leleh, saus rahasia Toon Burger, dan bun brioche super lembut.',
            5 => 'Fillet paha ayam krispi pedas berbalut rempah cabai merah membara, dipadukan selada segar renyah dan mayones gurih untuk sensasi pedas mantap.',
            6 => 'Dada ayam goreng krispi keemasan yang juicy berpadu lelehan keju cheddar gurih, selada segar, tomat, dan saus creamy diapit bun wijen empuk.',
            7 => 'Sosis sapi premium panggang bertekstur juicy di dalam roti bun hotdog lembut beraroma mentega, diberi lumuran saus tomat segar dan mustard lembut.',
            8 => 'Sosis daging sapi juicy di dalam roti hotdog empuk, diselimuti limpahan keju leleh gurih dan taburan saus daging cincang berbumbu lezat.',
            9 => 'Porsi jumbo hotdog istimewa dengan sosis sapi panggang tebal, siraman saus daging cincang melimpah, dan double keju mozarella meleleh yang gurih nikmat.',
        ];

        foreach ($descriptions as $id => $desc) {
            DB::table('products')->where('id', $id)->update(['description' => $desc]);
        }

        // Also update any other legacy products that still have the generic placeholder
        $legacyRows = DB::table('products')
            ->where('description', 'like', 'Burger dengan patty daging yang juicy%')
            ->orWhereNull('description')
            ->orWhere('description', '')
            ->get();

        foreach ($legacyRows as $row) {
            if (! isset($descriptions[$row->id])) {
                $desc = Product::defaultDescriptionFor($row->id, $row->slug, $row->name, $row->image);
                DB::table('products')->where('id', $row->id)->update(['description' => $desc]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to revert to generic placeholder
    }
};

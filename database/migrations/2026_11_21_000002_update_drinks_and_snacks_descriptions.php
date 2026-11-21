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

        $drinkAndSnackDescriptions = [
            13 => 'Minuman soda dingin berkarbonasi yang segar dan melegakan, teman sempurna menikmati burger favoritmu.',
            14 => 'Minuman creamy taro beraroma khas dengan rasa manis lembut nan gurih, disajikan dingin menyegarkan.',
            15 => 'Perpaduan otentik teh hijau matcha Jepang yang kaya antioksidan dengan susu creamy yang lembut dan menenangkan.',
            16 => 'Minuman red velvet manis legit dengan sentuhan aroma cokelat vanila lembut yang siap memanjakan harimu.',
            17 => 'Espresso kopi mantap berpadu susu segar gurih yang seimbang, pas untuk penikmat kopi sehari-hari.',
            18 => 'Racikan kopi espresso pilihan dengan manis legit gula aren asli dan susu gurih dingin yang menyegarkan.',
            19 => 'Kombinasi kopi susu dengan sirup karamel manis gurih bertabur sedikit garam laut untuk sensasi rasa unik.',
            20 => 'Teh melati dingin segar berpadu manis harum sari buah leci dengan sensasi manis asam yang melegakan dahaga.',
            21 => 'Minuman manis bernuansa permen kapas (cotton candy) yang playful dan lembut, penuh warna ceria nan segar.',
            22 => 'Kentang goreng renyah di luar dan lembut di dalam, ditaburi garam gurih pas sebagai camilan pendamping burger.',
            23 => 'Kentang goreng renyah keemasan yang disiram limpahan saus keju cheddar leleh gurih dan taburan rempah lezat.',
        ];

        foreach ($drinkAndSnackDescriptions as $id => $desc) {
            DB::table('products')->where('id', $id)->update(['description' => $desc]);
        }

        // Also update any other products by matching name
        $nameMap = [
            'soda' => 'Minuman soda dingin berkarbonasi yang segar dan melegakan, teman sempurna menikmati burger favoritmu.',
            'taro' => 'Minuman creamy taro beraroma khas dengan rasa manis lembut nan gurih, disajikan dingin menyegarkan.',
            'matcha' => 'Perpaduan otentik teh hijau matcha Jepang yang kaya antioksidan dengan susu creamy yang lembut dan menenangkan.',
            'red velvet' => 'Minuman red velvet manis legit dengan sentuhan aroma cokelat vanila lembut yang siap memanjakan harimu.',
            'kopi susu' => 'Espresso kopi mantap berpadu susu segar gurih yang seimbang, pas untuk penikmat kopi sehari-hari.',
            'kopi gula aren' => 'Racikan kopi espresso pilihan dengan manis legit gula aren asli dan susu gurih dingin yang menyegarkan.',
            'salted caramel' => 'Kombinasi kopi susu dengan sirup karamel manis gurih bertabur sedikit garam laut untuk sensasi rasa unik.',
            'lyce tea' => 'Teh melati dingin segar berpadu manis harum sari buah leci dengan sensasi manis asam yang melegakan dahaga.',
            'cotton candy' => 'Minuman manis bernuansa permen kapas (cotton candy) yang playful dan lembut, penuh warna ceria nan segar.',
            'french fries' => 'Kentang goreng renyah di luar dan lembut di dalam, ditaburi garam gurih pas sebagai camilan pendamping burger.',
            'chessy french fries' => 'Kentang goreng renyah keemasan yang disiram limpahan saus keju cheddar leleh gurih dan taburan rempah lezat.',
        ];

        foreach ($nameMap as $nameKey => $desc) {
            DB::table('products')
                ->whereRaw('LOWER(name) = ?', [$nameKey])
                ->update(['description' => $desc]);
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

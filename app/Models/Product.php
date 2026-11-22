<?php

namespace App\Models;

use App\Models\Concerns\ClearsMenuCatalogCache;
use App\Services\ImageDataUriService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use ClearsMenuCatalogCache, HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image',
        'is_available',
        'is_featured',
        'calories',
        'prep_time_minutes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'calories' => 'integer',
            'prep_time_minutes' => 'integer',
        ];
    }

    public static function defaultDescriptionFor(int|string|null $id, ?string $slug = null, ?string $name = null, ?string $image = null): string
    {
        $map = [
            1 => 'Dua lapis beef patty juicy dengan lelehan keju cheddar ganda berlimpah, bawang bombay karamel gurih manis, dan saus spesial Toon Burger di dalam bun brioche mentega hangat.',
            2 => 'Patty daging sapi pilihan 100% dipanggang sempurna dengan aroma asap khas, disajikan dengan selada segar, tomat renyah, acar timun, dan saus istimewa Toon Burger.',
            3 => 'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel lezat, keju cheddar meleleh, dan bawang bombay panggang yang renyah.',
            4 => 'Dua patty daging sapi panggang tebal dan juicy dengan limpahan keju cheddar ganda leleh, saus rahasia Toon Burger, dan bun brioche super lembut.',
            5 => 'Fillet paha ayam krispi pedas berbalut rempah cabai merah membara, dipadukan selada segar renyah dan mayones gurih untuk sensasi pedas mantap.',
            6 => 'Dada ayam goreng krispi keemasan yang juicy berpadu lelehan keju cheddar gurih, selada segar, tomat, dan saus creamy diapit bun wijen empuk.',
            7 => 'Sosis sapi premium panggang bertekstur juicy di dalam roti bun hotdog lembut beraroma mentega, diberi lumuran saus tomat segar dan mustard lembut.',
            8 => 'Sosis daging sapi juicy di dalam roti hotdog empuk, diselimuti limpahan keju leleh gurih dan taburan saus daging cincang berbumbu lezat.',
            9 => 'Porsi jumbo hotdog istimewa dengan sosis sapi panggang tebal, siraman saus daging cincang melimpah, dan double keju mozarella meleleh yang gurih nikmat.',
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
            24 => '6 potong sayap ayam goreng krispi renyah berbalut lumuran saus pedas spesial ala Toon Burger yang gurih, membakar lidah, dan nagih.',
            25 => '6 potong sayap ayam krispi keemasan berselimut saus smokey BBQ karamel gurih manis dengan aroma rempah panggang istimewa.',
        ];

        if ($id && isset($map[(int) $id])) {
            return $map[(int) $id];
        }

        // Exclude base64 data URI to prevent false positives from base64 characters
        $imagePath = (is_string($image) && !str_starts_with($image, 'data:')) ? $image : '';
        $needle = strtolower(($slug ?? '') . ' ' . ($name ?? '') . ' ' . $imagePath);

        // Snacks
        if (str_contains($needle, 'fries') || str_contains($needle, 'kentang')) {
            if (str_contains($needle, 'chessy') || str_contains($needle, 'cheesy') || str_contains($needle, 'keju')) {
                return $map[23];
            }
            return $map[22];
        }

        // Drinks
        if (str_contains($needle, 'lyce') || str_contains($needle, 'lychee') || str_contains($needle, 'leci')) {
            return $map[20];
        }
        if (str_contains($needle, 'soda') || str_contains($needle, 'cola') || str_contains($needle, 'coke')) {
            return $map[13];
        }
        if (str_contains($needle, 'taro')) {
            return $map[14];
        }
        if (str_contains($needle, 'matcha') || str_contains($needle, 'green tea')) {
            return $map[15];
        }
        if (str_contains($needle, 'red velvet') || str_contains($needle, 'velvet')) {
            return $map[16];
        }
        if (str_contains($needle, 'gula aren') || str_contains($needle, 'aren')) {
            return $map[18];
        }
        if (str_contains($needle, 'caramel') || str_contains($needle, 'karamel')) {
            return $map[19];
        }
        if (str_contains($needle, 'kopi') || str_contains($needle, 'coffee') || str_contains($needle, 'latte') || str_contains($needle, 'cappuccino')) {
            return $map[17];
        }
        if (str_contains($needle, 'cotton candy') || str_contains($needle, 'permen')) {
            return $map[21];
        }
        if (str_contains($needle, 'tea') || str_contains($needle, 'teh')) {
            return $map[20];
        }

        // Chicken Wings
        if (str_contains($needle, 'wing') || str_contains($needle, 'sayap')) {
            if (str_contains($needle, 'bbq')) {
                return $map[25];
            }
            if (str_contains($needle, 'hot') || str_contains($needle, 'pedas') || str_contains($needle, 'spicy')) {
                return $map[24];
            }
            return '6 potong sayap ayam goreng krispi renyah nan juicy dengan racikan bumbu rempah pilihan khas dapur Toon Burger.';
        }

        // Burgers & Hotdogs
        if (str_contains($needle, 'hot-dog') || str_contains($needle, 'hotdog')) {
            if (str_contains($needle, 'classic')) {
                return $map[7];
            }
            return $map[8];
        }
        if (str_contains($needle, 'chicken')) {
            if (str_contains($needle, 'hot') || str_contains($needle, 'pedas')) {
                return $map[5];
            }
            return $map[6];
        }
        if (str_contains($needle, 'bbq')) {
            return $map[3];
        }
        if (str_contains($needle, 'double')) {
            return $map[4];
        }
        if (str_contains($needle, 'cheese')) {
            return $map[1];
        }
        if (str_contains($needle, 'beef')) {
            return $map[2];
        }

        return 'Pilihan menu istimewa dari Toon Burger yang diolah dengan bahan-bahan segar berkualitas terbaik setiap hari.';
    }

    public function getDescriptionAttribute($value): string
    {
        $raw = trim((string) $value);
        $genericPhrases = [
            'minuman bersoda',
            'minuman rasa taro',
            'cocok untuk menyenangi hari-harimu',
            'minuman memperbaiki mood kamu',
            'cocok penikmat kopi',
            'cocok buat kamu yang produktivitas tinggi',
            'kopi dengan rasa semanis dirimu',
            'minuman rasa cotton candy',
            '6 potong ayam dan saus pedas ala toon',
            '6 potong ayam dan saus bbq',
        ];

        $lowerRaw = strtolower($raw);

        // Detect if drinks/snacks were incorrectly assigned a beef burger description
        $isMismatchedBeefDesc = false;
        if (str_starts_with($raw, 'Beef patty') || str_starts_with($raw, 'Burger dengan patty')) {
            $nameLower = strtolower((string) $this->name);
            $slugLower = strtolower((string) $this->slug);
            if (str_contains($nameLower, 'tea') || str_contains($nameLower, 'fries') || str_contains($slugLower, 'fries') || str_contains($nameLower, 'minuman') || str_contains($nameLower, 'snack')) {
                $isMismatchedBeefDesc = true;
            }
        }

        if ($raw === '' 
            || str_starts_with($raw, 'Burger dengan patty daging yang juicy')
            || $isMismatchedBeefDesc
            || in_array($lowerRaw, $genericPhrases)
        ) {
            return self::defaultDescriptionFor($this->id, $this->slug, $this->name, $this->image);
        }
        return $raw;
    }

    public function getImageUrlAttribute(): string
    {
        $rawImage = trim((string) $this->image);

        // 1. If explicitly stored as a static path or external URL (not base64 data URI)
        if ($rawImage !== '' && !str_starts_with($rawImage, 'data:image/')) {
            return ImageDataUriService::toAssetUrl($rawImage, 'images/burger-bg.jpg') ?? asset('images/burger-bg.jpg');
        }

        // 2. If matching static file exists in public/images/products/, serve fast CDN asset
        $slug = $this->slug ?: '';
        $nameSlug = \Illuminate\Support\Str::slug($this->name);
        $candidateSlugs = array_filter(array_unique([
            $slug,
            $nameSlug,
            (str_contains($slug, 'soda') || str_contains($nameSlug, 'soda') || str_contains($slug, 'soft-drink')) ? 'soda' : null,
            (str_contains($slug, 'lyc') || str_contains($nameSlug, 'lyc')) ? 'lycee-tea' : null,
        ]));

        foreach ($candidateSlugs as $cSlug) {
            foreach (["images/products/{$cSlug}.jpg", "images/products/{$cSlug}.png", "images/products/{$cSlug}.webp"] as $candidate) {
                if (file_exists(public_path($candidate))) {
                    return asset($candidate);
                }
            }
        }

        // 3. Fallback to raw data URI or ImageDataUriService
        return ImageDataUriService::toAssetUrl($rawImage, 'images/burger-bg.jpg') ?? asset('images/burger-bg.jpg');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getOptionsAttribute()
    {
        return collect([]);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}

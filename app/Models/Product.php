<?php

namespace App\Models;

use App\Models\Concerns\ClearsMenuCatalogCache;
use App\Services\ImageDataUriService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use ClearsMenuCatalogCache, HasFactory;

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
        ];

        if ($id && isset($map[(int) $id])) {
            return $map[(int) $id];
        }

        $needle = strtolower(($slug ?? '') . ' ' . ($name ?? '') . ' ' . ($image ?? ''));
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
        if ($raw === '' || str_starts_with($raw, 'Burger dengan patty daging yang juicy')) {
            return self::defaultDescriptionFor($this->id, $this->slug, $this->name, $this->image);
        }
        return $raw;
    }

    public function getImageUrlAttribute(): string
    {
        return ImageDataUriService::toAssetUrl($this->image, 'images/burger-bg.jpg') ?? asset('images/burger-bg.jpg');
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

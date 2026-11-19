<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public const CATALOG_CACHE_KEY = 'tb_catalog_v1';

    /**
     * Cache active categories and available products to eliminate repeated catalog DB roundtrips.
     */
    private function getCatalogData(): array
    {
        return Cache::remember(self::CATALOG_CACHE_KEY, 300, function () {
            $categories = Category::where('is_active', true)
                ->withCount(['products' => function ($q) {
                    $q->where('is_available', true);
                }])
                ->orderBy('sort_order')
                ->get();

            $products = Product::with('category')
                ->where('is_available', true)
                ->whereHas('category', fn ($q) => $q->where('is_active', true))
                ->orderBy('id')
                ->get();

            return [
                'categories' => $categories,
                'products' => $products,
            ];
        });
    }

    /**
     * Display the Home landing page.
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display the main food catalog page.
     */
    public function index(Request $request)
    {
        $catalog = $this->getCatalogData();
        $categories = $catalog['categories'];
        $allProducts = $catalog['products'];

        $totalAllProducts = $allProducts->count();
        $selectedCategory = $request->query('category', 'all');
        $search = trim((string) $request->query('q', ''));
        $tableNum = $request->query('table'); // If scanned QR: ?table=Meja 01

        $cardMetadata = [
            1  => ['badge' => 'CHEESE BURGER',  'bg' => '#FFC83B'],
            2  => ['badge' => 'BEEF BURGER',    'bg' => '#FCE5D3'],
            3  => ['badge' => 'BEEF BURGER',    'bg' => '#E51D1D'],
            4  => ['badge' => 'CHEESE BURGER',  'bg' => '#A4D477'],
            5  => ['badge' => 'CHICKEN BURGER', 'bg' => '#BFE1FD'],
            6  => ['badge' => 'CHICKEN BURGER', 'bg' => '#F67A24'],
            7  => ['badge' => 'HOT DOG',        'bg' => '#D5C8F6'],
            8  => ['badge' => 'SNACKS',         'bg' => '#F5B8DC'],
            9  => ['badge' => 'MINUMAN',        'bg' => '#FED7AA'],
            10 => ['badge' => 'CHICKEN WING',   'bg' => '#F5C518'],
            11 => ['badge' => 'CHEESE BURGER',  'bg' => '#A7D79E'],
            12 => ['badge' => 'BEEF BURGER',    'bg' => '#FCE5D3'],
        ];

        $products = $allProducts;

        if ($selectedCategory !== 'all' && ! empty($selectedCategory)) {
            $products = $products->filter(fn ($p) => ($p->category->slug ?? null) === $selectedCategory);
        }

        if ($search !== '') {
            $products = $products->filter(function ($p) use ($search) {
                return mb_stripos((string) $p->name, $search) !== false
                    || mb_stripos((string) $p->description, $search) !== false;
            });
        }

        $products = $products->values();
        $tables = collect();

        return view('menu.index', compact('categories', 'products', 'selectedCategory', 'search', 'tableNum', 'tables', 'cardMetadata', 'totalAllProducts'));
    }

    /**
     * Display the About Us (Tentang Kami) page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the Contact & Location (Kontak & Lokasi) page.
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Get single product detail with options for AJAX modal.
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'reviews' => fn ($q) => $q->latest(),
            'reviews.user:id,name,avatar',
        ])->where('is_available', true)->findOrFail($id);

        $cardMetadata = [
            1  => ['badge' => 'CHEESE BURGER',  'bg' => '#FFC83B'],
            2  => ['badge' => 'BEEF BURGER',    'bg' => '#FCE5D3'],
            3  => ['badge' => 'BEEF BURGER',    'bg' => '#E51D1D'],
            4  => ['badge' => 'CHEESE BURGER',  'bg' => '#A4D477'],
            5  => ['badge' => 'CHICKEN BURGER', 'bg' => '#BFE1FD'],
            6  => ['badge' => 'CHICKEN BURGER', 'bg' => '#FFC83B'],
            7  => ['badge' => 'HOT DOG',        'bg' => '#D5C8F6'],
            8  => ['badge' => 'SNACKS',         'bg' => '#F5B8DC'],
            9  => ['badge' => 'MINUMAN',        'bg' => '#FED7AA'],
            10 => ['badge' => 'CHICKEN WING',   'bg' => '#F5C518'],
            11 => ['badge' => 'CHEESE BURGER',  'bg' => '#A7D79E'],
            12 => ['badge' => 'BEEF BURGER',    'bg' => '#FCE5D3'],
        ];

        $palettes = ['#FFC83B', '#FCE5D3', '#E51D1D', '#A4D477', '#BFE1FD', '#FFC83B', '#D5C8F6', '#F5B8DC', '#FED7AA', '#F5C518', '#A7D79E', '#FCE5D3'];
        $meta = $cardMetadata[$product->id] ?? [
            'badge' => strtoupper($product->category->name ?? 'BURGER'),
            'bg' => $palettes[($product->id - 1) % count($palettes)],
        ];

        // Rich appetizing descriptions matching mockup quality (R-02 compliant: zero em dashes)
        $richDescriptions = [
            1 => 'Dua lapis beef patty juicy, double keju cheddar leleh berlimpah, caramelized onion manis gurih, dan saus spesial Toon Burger di dalam bun brioche mentega hangat.',
            2 => 'Patty daging sapi pilihan 100% dipanggang sempurna dengan aroma asap khas, disajikan dengan selada segar, tomat, acar timun, dan saus istimewa.',
            3 => 'Beef patty daging asli gurih berselimut saus smokey BBQ karamel, keju cheddar meleleh, dan bawang bombay panggang yang renyah.',
            4 => 'Dua patty daging sapi panggang juicy dengan limpahan keju cheddar ganda leleh, saus rahasia Toon Burger, dan bun brioche lembut.',
            5 => 'Ayam krispi pedas berbalut bumbu rempah cabai merah membara, dipadukan selada segar dan keju leleh untuk sensasi pedas mantap.',
            6 => 'Dada ayam krispi juicy berpadu lelehan keju cheddar, selada segar, dan tomat diapit dua bun wijen panggang yang empuk nan gurih.',
            7 => 'Sosis sapi premium panggang dengan mustard lembut, saus tomat pilihan, dan roti bun hotdog empuk beraroma mentega.',
            8 => 'Sosis daging sapi juicy diselimuti lelehan keju mozarella dan cheddar gurih serta taburan daging cincang panggang lezat.',
        ];

        $desc = $richDescriptions[$product->id] ?? ($product->description ?: 'Pilihan menu istimewa dari Toon Burger dengan bahan berkualitas segar setiap hari.');

        $productData = $product->toArray();
        $productData['reviews'] = $product->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'product_id' => $review->product_id,
                'rating' => (int) $review->rating,
                'comment' => $review->comment,
                'created_at' => optional($review->created_at)->toIso8601String(),
                'user' => $review->user ? [
                    'id' => $review->user->id,
                    'name' => $review->user->name,
                    'avatar_url' => $review->user->avatar_url,
                ] : null,
            ];
        })->values()->all();
        $productData['badge'] = $meta['badge'];
        $productData['bg'] = $meta['bg'];
        $productData['description'] = $desc;
        $productData['image_url'] = $product->image_url;
        $productData['formatted_price'] = 'Rp ' . number_format($product->price, 0, ',', '.');

        return response()->json([
            'success' => true,
            'product' => $productData,
        ]);
    }

    /**
     * Live search for menu products (Navbar Search Bar).
     */
    public function liveSearch(Request $request)
    {
        $q = trim($request->query('q', ''));
        if (strlen($q) < 1) {
            return response()->json(['products' => []]);
        }

        $products = $this->getCatalogData()['products']
            ->filter(function ($p) use ($q) {
                return mb_stripos((string) $p->name, $q) !== false
                    || mb_stripos((string) $p->description, $q) !== false;
            })
            ->take(6)
            ->values()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'price_formatted' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                    'image' => $p->image_url,
                    'url' => route('menu', ['q' => $p->name]),
                ];
            });

        return response()->json(['products' => $products]);
    }
}

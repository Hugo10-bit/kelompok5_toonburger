<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    public const CATALOG_CACHE_KEY = 'tb_catalog_v5';

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
        $catalog = $this->getCatalogData();
        $products = $catalog['products'];

        $bestSellers = $products
            ->where('is_featured', true)
            ->sortBy(function ($p) {
                return match ($p->id) {
                    1 => 1,
                    4 => 2,
                    5 => 3,
                    8 => 4,
                    2 => 5,
                    3 => 6,
                    default => 10 + $p->id,
                };
            })
            ->take(4)
            ->values();

        // Pastikan menu Best Seller selalu menampilkan 4 produk lengkap
        if ($bestSellers->count() < 4) {
            $needed = 4 - $bestSellers->count();
            $existingIds = $bestSellers->pluck('id')->all();

            $fillers = $products
                ->whereNotIn('id', $existingIds)
                ->sortBy(function ($p) {
                    return match ($p->id) {
                        1 => 1,
                        4 => 2,
                        5 => 3,
                        8 => 4,
                        2 => 5,
                        3 => 6,
                        default => 10 + $p->id,
                    };
                })
                ->take($needed)
                ->values();

            $bestSellers = $bestSellers->concat($fillers);
        }

        return view('home', compact('bestSellers'));
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
     * Store a new message submitted from the Contact page.
     */
    public function storeContact(Request $request)
    {
        $request->merge([
            'name' => trim((string) $request->input('name', '')),
            'email' => strtolower(trim((string) $request->input('email', ''))),
            'phone' => trim((string) $request->input('phone', '')),
            'message' => trim((string) $request->input('message', '')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'phone' => ['required', 'regex:/^[0-9]+(-[0-9]+)*$/', 'max:30'],
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        $contactMessage = ContactMessage::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => \App\Support\PhoneFormatter::format($validated['phone']) ?? $validated['phone'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Terima kasih {$contactMessage->name}, pesan Anda telah diterima oleh tim Toon Burger. Kami akan segera menghubungi Anda.",
                'data' => [
                    'id' => $contactMessage->id,
                    'name' => $contactMessage->name,
                ],
            ], 201);
        }

        return back()->with('success', "Terima kasih {$contactMessage->name}, pesan Anda telah diterima oleh tim Toon Burger.");
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
        ])
            ->where('is_available', true)
            ->whereHas('category', fn ($q) => $q->where('is_active', true))
            ->findOrFail($id);

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
            9 => 'Porsi jumbo hotdog istimewa dengan sosis sapi panggang tebal, siraman saus daging cincang melimpah, dan double keju mozarella meleleh yang gurih nikmat.',
        ];

        $desc = $product->description ?: ($richDescriptions[$product->id] ?? 'Pilihan menu istimewa dari Toon Burger dengan bahan berkualitas segar setiap hari.');

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
        $productData['image'] = $product->image_url;
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

    /**
     * Auto-translate dynamic Indonesian product names/descriptions to English (cached 30 days).
     */
    public function translateTexts(Request $request)
    {
        $validated = $request->validate([
            'texts' => ['required', 'array', 'max:40'],
            'texts.*' => ['required', 'string', 'max:500'],
        ]);

        $uniqueTexts = collect($validated['texts'])
            ->map(fn ($t) => trim((string) $t))
            ->filter(fn ($t) => $t !== '')
            ->unique()
            ->values();

        $translations = [];

        foreach ($uniqueTexts as $text) {
            $cacheKey = 'tb_auto_en_' . sha1($text);
            $cached = Cache::get($cacheKey);
            if (is_string($cached) && $cached !== '') {
                $translations[$text] = $cached;
                continue;
            }

            $translated = $this->fetchEnglishTranslation($text);
            if ($translated !== null && $translated !== '') {
                Cache::put($cacheKey, $translated, now()->addDays(30));
                $translations[$text] = $translated;
            } else {
                $translations[$text] = $text;
            }
        }

        return response()->json([
            'translations' => $translations,
        ]);
    }

    private function fetchEnglishTranslation(string $text): ?string
    {
        try {
            $res = Http::timeout(4)->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => 'id',
                'tl' => 'en',
                'dt' => 't',
                'q' => $text,
            ]);

            if ($res->successful()) {
                $payload = $res->json();
                if (is_array($payload) && isset($payload[0]) && is_array($payload[0])) {
                    $combined = '';
                    foreach ($payload[0] as $segment) {
                        if (is_array($segment) && isset($segment[0]) && is_string($segment[0])) {
                            $combined .= $segment[0];
                        }
                    }
                    $combined = trim($combined);
                    if ($combined !== '') {
                        return $combined;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Fall through to secondary provider
        }

        try {
            $res = Http::timeout(4)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'id|en',
            ]);

            if ($res->successful()) {
                $translated = trim((string) ($res->json('responseData.translatedText') ?? ''));
                if ($translated !== '' && stripos($translated, 'MYMEMORY WARNING') === false) {
                    return $translated;
                }
            }
        } catch (\Throwable $e) {
            // Ignore offline/network failures gracefully
        }

        return null;
    }

    /**
     * Stream a product image binary with immutable client/CDN caching headers.
     */
    public function productImage(Product $product)
    {
        $image = trim((string) $product->image);

        if (str_starts_with($image, 'data:image/') && preg_match('/^data:image\/([a-zA-Z0-9]+);base64,(.+)$/', $image, $m)) {
            $ext = strtolower($m[1]);
            $mime = $ext === 'png' ? 'image/png' : ($ext === 'webp' ? 'image/webp' : 'image/jpeg');
            $binary = base64_decode($m[2], true);
            if ($binary !== false && $binary !== '') {
                return response($binary, 200, [
                    'Content-Type' => $mime,
                    'Content-Length' => strlen($binary),
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                    'ETag' => '"' . md5($binary) . '"',
                ]);
            }
        }

        if ($image !== '' && ! str_starts_with($image, 'data:image/')) {
            $resolved = \App\Services\ImageDataUriService::toAssetUrl($image);
            if ($resolved) {
                return redirect($resolved, 302);
            }
        }

        $slug = $product->slug ?: '';
        $nameSlug = \Illuminate\Support\Str::slug($product->name);
        $candidateSlugs = array_filter(array_unique([
            $slug,
            $nameSlug,
            (str_contains($slug, 'soda') || str_contains($nameSlug, 'soda') || str_contains($slug, 'soft-drink')) ? 'soda' : null,
            (str_contains($slug, 'lyc') || str_contains($nameSlug, 'lyc')) ? 'lycee-tea' : null,
        ]));

        foreach ($candidateSlugs as $cSlug) {
            foreach (["images/products/{$cSlug}.jpg", "images/products/{$cSlug}.png", "images/products/{$cSlug}.webp"] as $candidate) {
                if (file_exists(public_path($candidate))) {
                    return redirect(asset($candidate), 301);
                }
            }
        }

        return redirect(asset('images/burger-bg.jpg'));
    }
}

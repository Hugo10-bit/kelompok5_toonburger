<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class MenuController extends Controller
{
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
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('is_available', true);
            }])
            ->orderBy('sort_order')
            ->get();

        $totalAllProducts = Product::where('is_available', true)->count();
        $selectedCategory = $request->query('category', 'all');
        $search = $request->query('q');
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

        $query = Product::with('category')
            ->where('is_available', true);

        if ($selectedCategory !== 'all' && !empty($selectedCategory)) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('id')->get();

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
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);

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
        $productData['badge'] = $meta['badge'];
        $productData['bg'] = $meta['bg'];
        $productData['description'] = $desc;
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

        $products = Product::where('is_available', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->take(6)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'price_formatted' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                    'image' => $p->image ? asset($p->image) : asset('images/burger-bg.jpg'),
                    'url' => route('menu', ['q' => $p->name]),
                ];
            });

        return response()->json(['products' => $products]);
    }
}

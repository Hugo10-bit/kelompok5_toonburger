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
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $featuredProducts = collect([
            (object) [
                'id' => 1,
                'name' => 'Very Cheese Burger',
                'category_label' => 'CHEESE BURGER',
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 35000,
                'image' => 'images/bestseller_very_cheese.png',
            ],
            (object) [
                'id' => 6,
                'name' => 'Cheese Chicken Burger',
                'category_label' => 'CHICKEN BURGER',
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 23000,
                'image' => 'images/bestseller_cheese_chicken.png',
            ],
            (object) [
                'id' => 3,
                'name' => 'BBQ Beef Burger',
                'category_label' => 'BEEF BURGER',
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 37000,
                'image' => 'images/bestseller_bbq_beef.png',
            ],
            (object) [
                'id' => 4,
                'name' => 'Double Cheese Burger',
                'category_label' => 'CHEESE BURGER',
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/bestseller_double_cheese.png',
            ],
        ]);

        return view('home', compact('categories', 'featuredProducts'));
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

        if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
            $query = Product::with(['category', 'reviews.user'])
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

            $perPage = 12;
            $totalProductsCount = (clone $query)->count();

            // When there are 12 or fewer real items, simulate pagination up to 6 pages (matching target mockup)
            if ($totalProductsCount > 0 && $totalProductsCount <= $perPage) {
                $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage('page') ?: 1;
                $simulatedTotal = $totalProductsCount * 6;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $query->orderBy('id')->get(),
                    $simulatedTotal,
                    $perPage,
                    $currentPage,
                    [
                        'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    ]
                );
                $products->withQueryString();
            } else {
                $products = $query->orderBy('id')->paginate($perPage)->withQueryString();
            }
        } else {
            $products = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
        }

        $tables = RestaurantTable::where('status', 'available')->get();

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

        return response()->json([
            'success' => true,
            'product' => $product,
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

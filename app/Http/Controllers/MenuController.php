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

        if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
            $featuredProducts = Product::with(['category', 'reviews.user'])
                ->where('is_available', true)
                ->where('is_featured', true)
                ->take(4)
                ->get();

            // Fallback if not enough featured products
            if ($featuredProducts->isEmpty()) {
                $featuredProducts = Product::with(['category', 'reviews.user'])
                    ->where('is_available', true)
                    ->take(4)
                    ->get();
            }
        } else {
            $featuredProducts = collect([]);
        }

        return view('home', compact('categories', 'featuredProducts'));
    }

    /**
     * Display the main food catalog page.
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = $request->query('category', 'all');
        $search = $request->query('q');
        $tableNum = $request->query('table'); // If scanned QR: ?table=Meja 01

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

            $products = $query->orderByDesc('is_featured')->orderBy('name')->get();
        } else {
            $products = collect([]);
        }

        $tables = RestaurantTable::where('status', 'available')->get();

        return view('menu.index', compact('categories', 'products', 'selectedCategory', 'search', 'tableNum', 'tables'));
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
}

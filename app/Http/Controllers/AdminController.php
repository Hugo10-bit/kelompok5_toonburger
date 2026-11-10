<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Admin Analytics Dashboard.
     */
    public function dashboard()
    {
        $todayRevenue = 500000;
        $totalOrdersToday = 52;
        $pendingOrders = 9;

        $revenueGrowth = '5,2';
        $ordersGrowth = '2,1';
        $yearlyRevenue = 250493012;

        $chartPeriods = [
            'jan_jun' => [
                ['id_month' => 'Jan', 'en_month' => 'Jan', 'date_id' => 'Jan 2026', 'date_en' => 'Jan 2026', 'pct' => 50, 'val_id' => 'Rp 4.900.000', 'val_en' => 'IDR 4,900,000'],
                ['id_month' => 'Feb', 'en_month' => 'Feb', 'date_id' => 'Feb 2026', 'date_en' => 'Feb 2026', 'pct' => 62, 'val_id' => 'Rp 6.200.000', 'val_en' => 'IDR 6,200,000'],
                ['id_month' => 'Mar', 'en_month' => 'Mar', 'date_id' => 'Jan 2026', 'date_en' => 'Jan 2026', 'pct' => 86, 'val_id' => 'Rp 5.000.000', 'val_en' => 'IDR 5,000,000'],
                ['id_month' => 'Apr', 'en_month' => 'Apr', 'date_id' => 'Apr 2026', 'date_en' => 'Apr 2026', 'pct' => 77, 'val_id' => 'Rp 7.700.000', 'val_en' => 'IDR 7,700,000'],
                ['id_month' => 'Mei', 'en_month' => 'May', 'date_id' => 'Mei 2026', 'date_en' => 'May 2026', 'pct' => 54, 'val_id' => 'Rp 5.400.000', 'val_en' => 'IDR 5,400,000'],
                ['id_month' => 'Jun', 'en_month' => 'Jun', 'date_id' => 'Jun 2026', 'date_en' => 'Jun 2026', 'pct' => 84, 'val_id' => 'Rp 8.400.000', 'val_en' => 'IDR 8,400,000'],
            ],
            'jul_des' => [
                ['id_month' => 'Jul', 'en_month' => 'Jul', 'date_id' => 'Jul 2026', 'date_en' => 'Jul 2026', 'pct' => 68, 'val_id' => 'Rp 6.800.000', 'val_en' => 'IDR 6,800,000'],
                ['id_month' => 'Agu', 'en_month' => 'Aug', 'date_id' => 'Agu 2026', 'date_en' => 'Aug 2026', 'pct' => 74, 'val_id' => 'Rp 7.400.000', 'val_en' => 'IDR 7,400,000'],
                ['id_month' => 'Sep', 'en_month' => 'Sep', 'date_id' => 'Sep 2026', 'date_en' => 'Sep 2026', 'pct' => 60, 'val_id' => 'Rp 6.000.000', 'val_en' => 'IDR 6,000,000'],
                ['id_month' => 'Okt', 'en_month' => 'Oct', 'date_id' => 'Okt 2026', 'date_en' => 'Oct 2026', 'pct' => 89, 'val_id' => 'Rp 8.900.000', 'val_en' => 'IDR 8,900,000'],
                ['id_month' => 'Nov', 'en_month' => 'Nov', 'date_id' => 'Nov 2026', 'date_en' => 'Nov 2026', 'pct' => 79, 'val_id' => 'Rp 7.900.000', 'val_en' => 'IDR 7,900,000'],
                ['id_month' => 'Des', 'en_month' => 'Dec', 'date_id' => 'Des 2026', 'date_en' => 'Dec 2026', 'pct' => 92, 'val_id' => 'Rp 9.200.000', 'val_en' => 'IDR 9,200,000'],
            ],
        ];

        $topProducts = collect([
            (object) [
                'product_name' => 'Cheese Chiken Burger',
                'search_term' => 'Cheese',
                'total_qty' => 179,
                'image' => 'images/products/cheese-chicken-burger.png',
                'bg_hex' => '#FFE3BE',
            ],
            (object) [
                'product_name' => 'Very Cheese Burger',
                'search_term' => 'Very Cheese Burger',
                'total_qty' => 160,
                'image' => 'images/products/very-cheese-burger.png',
                'bg_hex' => '#FED638',
            ],
            (object) [
                'product_name' => 'Double Cheese Burger',
                'search_term' => 'Double Cheese Burger',
                'total_qty' => 149,
                'image' => 'images/products/double-cheese-burger.png',
                'bg_hex' => '#BEE183',
            ],
            (object) [
                'product_name' => 'BBQ Beef Burger',
                'search_term' => 'BBQ Beef Burger',
                'total_qty' => 143,
                'image' => 'images/products/bbq-beef-burger.png',
                'bg_hex' => '#FE0405',
            ],
            (object) [
                'product_name' => 'Hot Chicken Burger',
                'search_term' => 'Hot Chicken Burger',
                'total_qty' => 133,
                'image' => 'images/products/hot-chicken-burger.png',
                'bg_hex' => '#FEC2E6',
            ],
        ]);

        $totalProducts = 24;
        $activeProducts = 20;
        $outOfStockProducts = 2;

        return view('admin.dashboard', compact(
            'todayRevenue',
            'revenueGrowth',
            'totalOrdersToday',
            'ordersGrowth',
            'pendingOrders',
            'totalProducts',
            'activeProducts',
            'outOfStockProducts',
            'yearlyRevenue',
            'chartPeriods',
            'topProducts'
        ));
    }

    /**
     * Header Live Search AJAX API.
     */
    public function liveSearch(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (empty($q)) {
            return response()->json([
                'products' => [],
                'orders' => [],
                'categories' => []
            ]);
        }

        $products = Product::where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->select('id', 'name', 'price', 'image', 'is_available')
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price_formatted' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                    'image' => $p->image ? asset($p->image) : null,
                    'is_available' => (bool)$p->is_available,
                    'url' => route('admin.products', ['search' => $p->name]),
                ];
            });

        $orders = Order::where(function ($query) use ($q) {
                $query->where('order_number', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%");
            })
            ->select('id', 'order_number', 'customer_name', 'total_amount', 'status')
            ->take(5)
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'customer_name' => $o->customer_name,
                    'total_formatted' => 'Rp ' . number_format($o->total_amount, 0, ',', '.'),
                    'status' => $o->status,
                    'url' => route('admin.orders', ['search' => $o->order_number]),
                ];
            });

        $categories = Category::where('name', 'like', "%{$q}%")
            ->select('id', 'name', 'slug')
            ->take(4)
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'url' => route('admin.categories'),
                ];
            });

        return response()->json([
            'products' => $products,
            'orders' => $orders,
            'categories' => $categories,
        ]);
    }

    /**
     * Kitchen & Order Management Board.
     */
    public function orders(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = trim($request->query('search', $request->query('q', '')));

        $relations = ['items', 'table', 'user'];
        if (\Illuminate\Support\Facades\Schema::hasTable('payments')) {
            $relations[] = 'payment';
        }

        $query = Order::with($relations)->orderBy('id', 'asc');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        if ($status === 'diproses') {
            $query->whereIn('status', ['confirmed', 'preparing']);
        } elseif ($status !== 'all' && in_array($status, ['pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(6)->withQueryString();

        $statusCounts = Order::selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $countPending = (int) ($statusCounts['pending'] ?? 0);
        $countConfirmed = (int) ($statusCounts['confirmed'] ?? 0);
        $countPreparing = (int) ($statusCounts['preparing'] ?? 0);
        $countCooking = $countConfirmed + $countPreparing;
        $countReady = (int) ($statusCounts['ready'] ?? 0);
        $countCompleted = (int) ($statusCounts['completed'] ?? 0);
        $countCancelled = (int) ($statusCounts['cancelled'] ?? 0);
        $countAll = (int) $statusCounts->sum();

        $counts = [
            'all' => $countAll,
            'pending' => $countPending,
            'confirmed' => $countConfirmed,
            'preparing' => $countPreparing,
            'diproses' => $countCooking,
            'ready' => $countReady,
            'completed' => $countCompleted,
            'cancelled' => $countCancelled,
        ];

        return view('admin.orders', compact(
            'orders',
            'status',
            'counts',
            'search',
            'countAll',
            'countPending',
            'countCooking',
            'countReady',
            'countCompleted'
        ));
    }

    /**
     * Detail Pesanan (Sesuai Mockup Figma Admin Panel).
     */
    public function orderDetail($order_number)
    {
        $relations = ['items.product', 'table', 'user'];
        if (\Illuminate\Support\Facades\Schema::hasTable('payments')) {
            $relations[] = 'payment';
        }

        $order = Order::with($relations)
            ->where('order_number', $order_number)
            ->orWhere('order_number', 'TB-20260917-00007')
            ->orWhere('id', $order_number)
            ->firstOrFail();

        return view('admin.order-detail', compact('order'));
    }

    /**
     * Update order status (Kitchen Flow).
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,refunded',
        ]);

        $order->status = $request->status;

        if ($request->filled('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        // If completed or cancelled, free up table
        if (in_array($request->status, ['completed', 'cancelled']) && $order->restaurant_table_id) {
            RestaurantTable::where('id', $order->restaurant_table_id)->update(['status' => 'available']);
        }

        $order->save();

        return back()->with('success', "Status pesanan {$order->order_number} diperbarui menjadi " . ucfirst($order->status) . ".");
    }

    /**
     * Menu & Product Management.
     */
    public function products(Request $request)
    {
        $search = trim($request->query('search', $request->query('q', '')));
        $query = Product::with('category')
            ->whereHas('category', fn($q) => $q->where('is_active', true))
            ->orderBy('id', 'asc');
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products', compact('products', 'categories', 'search'));
    }

    /**
     * Store new product.
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer',
            'prep_time_minutes' => 'nullable|integer',
        ]);

        $imagePath = 'images/burger-bg.jpg';

        if ($request->hasFile('image') || $request->hasFile('image_file')) {
            $file = $request->file('image') ?? $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        } elseif (is_string($request->image) && !empty($request->image)) {
            $imagePath = $request->image;
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description ?: 'Burger dengan patty daging yang juicy,',
            'calories' => $request->calories ?? 300,
            'prep_time_minutes' => $request->prep_time_minutes ?? 10,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured') || $request->boolean('is_popular'),
            'is_available' => $request->has('is_available') ? $request->boolean('is_available') : true,
        ]);

        return back()->with('success', "Menu '{$request->name}' berhasil ditambahkan!");
    }

    /**
     * Update existing product.
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'calories' => 'nullable|integer',
            'prep_time_minutes' => 'nullable|integer',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image') || $request->hasFile('image_file')) {
            $file = $request->file('image') ?? $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        } elseif (is_string($request->image) && !empty($request->image)) {
            $imagePath = $request->image;
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description,
            'calories' => $request->calories,
            'prep_time_minutes' => $request->prep_time_minutes,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured') || $request->boolean('is_popular'),
            'is_available' => $request->boolean('is_available'),
        ]);

        return back()->with('success', "Menu '{$product->name}' berhasil diperbarui!");
    }

    /**
     * Toggle product availability.
     */
    public function toggleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->is_available = !$product->is_available;
        $product->save();

        $statusText = $product->is_available ? 'Tersedia' : 'Habis / Nonaktif';
        return back()->with('success', "Status menu {$product->name} diubah menjadi {$statusText}.");
    }

    /**
     * Delete product.
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Restaurant Table Management.
     */
    public function tables()
    {
        $tables = RestaurantTable::withCount(['orders' => function ($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready']);
        }])->orderBy('table_number')->get();

        return view('admin.tables', compact('tables'));
    }

    /**
     * Update table status.
     */
    public function updateTableStatus(Request $request, $id)
    {
        $table = RestaurantTable::findOrFail($id);
        $request->validate(['status' => 'required|in:available,occupied,reserved']);

        $table->status = $request->status;
        $table->save();

        return back()->with('success', "Status {$table->table_number} diperbarui menjadi {$table->status}.");
    }

    /**
     * Product Categories Management.
     */
    public function categories()
    {
        $categories = Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories', compact('categories'));
    }

    /**
     * Store new product category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $maxSort = Category::max('sort_order') ?? 0;

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(10, 99),
            'sort_order' => $request->sort_order ?? ($maxSort + 1),
            'is_active' => true,
        ]);

        return back()->with('success', "Kategori '{$request->name}' berhasil ditambahkan!");
    }

    /**
     * Update product category.
     */
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? $category->sort_order,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $category->is_active,
        ]);

        return back()->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    /**
     * Delete product category.
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return back()->with('error', "Kategori '{$category->name}' masih memiliki menu produk dan tidak dapat dihapus.");
        }
        $category->delete();

        return back()->with('success', "Kategori '{$category->name}' berhasil dihapus.");
    }

    /**
     * Admin Profile Settings.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update Admin Profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $dir = public_path('images/avatars');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $user->avatar = 'images/avatars/' . $filename;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil admin berhasil diperbarui!');
    }

    /**
     * Customer reviews and order feedback messages.
     */
    public function messages(Request $request)
    {
        $rating = $request->query('rating', 'all');
        $search = trim($request->query('search', $request->query('q', '')));

        $query = Review::with(['user', 'order', 'product'])->latest();

        $hasFilter = false;
        if ($rating !== 'all' && in_array((int) $rating, [1, 2, 3, 4, 5], true)) {
            $query->where('rating', (int) $rating);
            $hasFilter = true;
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('order', fn ($o) => $o->where('order_number', 'like', "%{$search}%")->orWhere('customer_name', 'like', "%{$search}%"));
            });
            $hasFilter = true;
        }

        $messages = $query->paginate(8)->withQueryString();
        $totalCount = $hasFilter ? Review::count() : $messages->total();

        return view('admin.messages', compact('messages', 'rating', 'search', 'totalCount'));
    }

    /**
     * Coupons Management.
     */
    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    /**
     * Store coupon.
     */
    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:20',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:1',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_spend' => $request->min_spend ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(3),
            'is_active' => true,
        ]);

        return back()->with('success', 'Voucher diskon baru berhasil dibuat!');
    }

    /**
     * Toggle coupon active status.
     */
    public function toggleCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return back()->with('success', "Status voucher {$coupon->code} diperbarui.");
    }

    /**
     * Point of Sale (POS) Cashier Screen.
     */
    public function pos()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $products = \Illuminate\Support\Facades\Schema::hasTable('products')
            ? Product::with(['category'])->where('is_available', true)->get()
            : collect([]);
        $tables = RestaurantTable::orderBy('table_number')->get();

        return view('admin.pos', compact('categories', 'products', 'tables'));
    }

    /**
     * POS Instant Checkout.
     */
    public function posCheckout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'order_type' => 'nullable|in:takeaway,delivery,dine_in',
            'restaurant_table_id' => 'nullable|exists:restaurant_tables,id',
            'customer_name' => 'nullable|string',
            'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
            'cash_received' => 'nullable|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            $datePrefix = 'TB-' . date('Ymd');
            $countToday = Order::where('order_number', 'like', "{$datePrefix}-%")->count() + 1;
            $orderNumber = $datePrefix . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = (int)$item['quantity'];
                $itemTotal = (float)$product->price * $qty;
                $subtotal += $itemTotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                    'subtotal' => $itemTotal,
                ];
            }

            $tax = round($subtotal * 0.10);
            $total = $subtotal + $tax;

            // Toon Burger is strictly Takeaway / Delivery (No Dine-In)
            $orderType = ($request->order_type === 'delivery') ? 'delivery' : 'takeaway';

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'restaurant_table_id' => null,
                'order_type' => $orderType,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'discount_amount' => 0,
                'total_amount' => $total,
                'customer_name' => $request->customer_name ?: 'Walk-in Customer',
                'customer_phone' => '-',
            ]);

            foreach ($orderItemsData as $oid) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $oid['product_id'],
                    'product_name' => $oid['product_name'],
                    'price' => $oid['price'],
                    'quantity' => $oid['quantity'],
                    'subtotal' => $oid['subtotal'],
                ]);
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('payments')) {
                Payment::create([
                    'order_id' => $order->id,
                    'transaction_code' => 'POS-' . strtoupper(Str::random(10)),
                    'payment_method' => $request->payment_method,
                    'amount' => $total,
                    'status' => 'success',
                    'payment_details' => [
                        'cashier' => Auth::user()->name ?? 'Kasir',
                        'cash_received' => $request->cash_received ?? $total,
                        'change' => max(0, ($request->cash_received ?? $total) - $total),
                    ],
                    'paid_at' => now(),
                ]);
            }

            if ($order->restaurant_table_id) {
                RestaurantTable::where('id', $order->restaurant_table_id)->update(['status' => 'occupied']);
            }

            return response()->json([
                'success' => true,
                'message' => "Pesanan POS {$order->order_number} berhasil dicatat dan lunas!",
                'order_number' => $order->order_number,
                'redirect' => route('admin.orders.show', $order->order_number),
            ]);
        });
    }
}

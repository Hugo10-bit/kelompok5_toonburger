<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\Review;
use App\Models\StoreSetting;
use App\Models\User;
use App\Services\ImageDataUriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
     * Toggle operational status (open / closed) for the Toon Burger outlet.
     */
    public function toggleStoreStatus(Request $request)
    {
        $request->validate([
            'is_open' => 'required|boolean',
            'closed_reason' => 'nullable|string|max:120',
        ]);

        $setting = StoreSetting::first() ?? new StoreSetting([
            'operating_hours' => StoreSetting::DEFAULT_HOURS,
        ]);

        $isOpen = $request->boolean('is_open');
        $reason = trim((string) $request->input('closed_reason', ''));

        $setting->is_open = $isOpen;
        $setting->closed_reason = $isOpen ? null : ($reason !== '' ? $reason : StoreSetting::DEFAULT_CLOSED_REASON);
        $setting->closed_at = $isOpen ? null : now();
        $setting->updated_by = Auth::id();
        $setting->save();

        if ($isOpen) {
            return back()->with('success', 'Toko kembali BUKA. Pelanggan sudah dapat melakukan pemesanan dan checkout.');
        }

        return back()->with('success', "Toko berhasil DITUTUP sementara ({$setting->displayReason()}). Pemesanan pelanggan dinonaktifkan.");
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
                $query->whereLike('name', "%{$q}%")
                    ->orWhereLike('description', "%{$q}%");
            })
            ->select('id', 'name', 'price', 'image', 'is_available')
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price_formatted' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                    'image' => $p->image ? $p->image_url : null,
                    'is_available' => (bool)$p->is_available,
                    'url' => route('admin.products', ['search' => $p->name]),
                ];
            });

        $orders = Order::where(function ($query) use ($q) {
                $query->whereLike('order_number', "%{$q}%")
                    ->orWhereLike('customer_name', "%{$q}%");
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

        $categories = Category::whereLike('name', "%{$q}%")
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
                $q->whereLike('order_number', "%{$search}%")
                  ->orWhereLike('customer_name', "%{$search}%");
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
            ->where(function ($q) use ($order_number) {
                $q->where('order_number', $order_number);
                if (ctype_digit((string) $order_number)) {
                    $q->orWhere('id', (int) $order_number);
                }
            })
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
            if ($request->payment_status === 'paid') {
                if (! $order->paid_at) {
                    $order->paid_at = now();
                }
                $order->payment_proof_rejected_reason = null;
                $order->payment_gateway = $order->payment_gateway ?: 'manual_verification';
            }
        }

        // If completed or cancelled, free up table
        if (in_array($request->status, ['completed', 'cancelled']) && $order->restaurant_table_id) {
            RestaurantTable::where('id', $order->restaurant_table_id)->update(['status' => 'available']);
        }

        $order->save();

        if ($request->payment_status === 'paid' && Schema::hasTable('payments')) {
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_code' => $order->payment?->transaction_code ?? ('PAY-' . strtoupper(Str::random(10))),
                    'payment_method' => $order->payment_method,
                    'amount' => $order->total_amount,
                    'status' => 'success',
                    'paid_at' => $order->paid_at,
                ]
            );
        }

        if ($request->payment_status === 'paid') {
            return back()->with('success', "Pembayaran pesanan {$order->order_number} berhasil dikonfirmasi LUNAS.");
        }

        return back()->with('success', "Status pesanan {$order->order_number} diperbarui menjadi " . ucfirst($order->status) . ".");
    }

    /**
     * Reject customer payment proof so customer can re-upload a valid screenshot.
     */
    public function rejectPaymentProof(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah lunas.');
        }

        $request->validate([
            'reason' => 'nullable|string|max:255',
        ], [
            'reason.max' => 'Alasan penolakan maksimal 255 karakter.',
        ]);

        $reason = trim((string) $request->input('reason', ''));
        $order->update([
            'payment_proof' => null,
            'payment_proof_uploaded_at' => null,
            'payment_proof_rejected_reason' => $reason !== '' ? $reason : 'Bukti transfer kurang jelas atau nominal belum sesuai. Silakan unggah ulang.',
        ]);

        return back()->with('success', "Bukti pembayaran {$order->order_number} ditolak. Pelanggan diminta mengunggah ulang bukti transfer.");
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
                $q->whereLike('name', "%{$search}%")
                  ->orWhereLike('description', "%{$search}%");
            });
        }

        $products = $query->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products', compact('products', 'categories', 'search'));
    }

    /**
     * Store new product.
     */
    public function storeProduct(Request $request, ImageDataUriService $imageService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000|max:1000000',
            'original_price' => 'nullable|numeric|min:1000|max:1000000',
            'description' => 'nullable|string|max:1000',
            'calories' => 'nullable|integer',
            'prep_time_minutes' => 'nullable|integer',
            'image' => $request->hasFile('image') ? 'image|mimes:jpeg,jpg,png|max:5120' : ['nullable', 'string', 'max:255', 'regex:/^\/?images\/[A-Za-z0-9_.\-\/]+\.(webp|png|jpe?g)$/i'],
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'image_data' => 'nullable|string|max:4194304',
        ], [
            'image.image' => 'Gambar produk wajib berupa foto JPG atau PNG.',
            'image.mimes' => 'Format gambar produk hanya diperbolehkan JPG atau PNG.',
            'image.max' => 'Ukuran gambar produk maksimal 5 MB.',
            'image_file.image' => 'Gambar produk wajib berupa foto JPG atau PNG.',
            'image_file.mimes' => 'Format gambar produk hanya diperbolehkan JPG atau PNG.',
            'image_file.max' => 'Ukuran gambar produk maksimal 5 MB.',
            'price.required' => 'Harga produk/pesanan wajib diisi.',
            'price.numeric' => 'Harga produk/pesanan harus berupa angka nominal valid.',
            'price.min' => 'Harga produk/pesanan minimal Rp 1.000.',
            'price.max' => 'Harga produk/pesanan terlalu berlebihan (maksimal Rp 1.000.000).',
            'original_price.numeric' => 'Harga asli/coret harus berupa angka.',
            'original_price.min' => 'Harga asli/coret minimal Rp 1.000.',
            'original_price.max' => 'Harga asli/coret terlalu berlebihan (maksimal Rp 1.000.000).',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except(['image_data', 'image', 'image_file']));
        }

        $resolved = $imageService->resolveJpgOrPngDataUri($request, ['image', 'image_file'], 'image_data', 900);
        if ($resolved['error'] !== null) {
            return back()
                ->withErrors(['image' => $resolved['error']])
                ->withInput($request->except(['image_data', 'image', 'image_file']));
        }

        $imagePath = 'images/burger-bg.jpg';
        if ($resolved['provided']) {
            $imagePath = $resolved['data_uri'];
        } elseif (is_string($request->image) && ! empty($request->image) && ! str_contains($request->image, '..')) {
            $imagePath = ltrim($request->image, '/');
        }

        ImageDataUriService::saveWithLongTextFallback('products', 'image', fn () => Product::create([
            'name' => $request->name,
            'slug' => Str::limit(Str::slug($request->name), 75, '') . '-' . rand(100, 999),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description ?: 'Burger dengan patty daging yang juicy,',
            'calories' => $request->calories ?? 300,
            'prep_time_minutes' => $request->prep_time_minutes ?? 10,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured') || $request->boolean('is_popular'),
            'is_available' => $request->has('is_available') ? $request->boolean('is_available') : true,
        ]));

        return back()->with('success', "Menu '{$request->name}' berhasil ditambahkan!");
    }

    /**
     * Update existing product.
     */
    public function updateProduct(Request $request, $id, ImageDataUriService $imageService)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000|max:1000000',
            'original_price' => 'nullable|numeric|min:1000|max:1000000',
            'description' => 'nullable|string|max:1000',
            'calories' => 'nullable|integer',
            'prep_time_minutes' => 'nullable|integer',
            'image' => $request->hasFile('image') ? 'image|mimes:jpeg,jpg,png|max:5120' : ['nullable', 'string', 'max:255', 'regex:/^\/?images\/[A-Za-z0-9_.\-\/]+\.(webp|png|jpe?g)$/i'],
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'image_data' => 'nullable|string|max:4194304',
        ], [
            'image.image' => 'Gambar produk wajib berupa foto JPG atau PNG.',
            'image.mimes' => 'Format gambar produk hanya diperbolehkan JPG atau PNG.',
            'image.max' => 'Ukuran gambar produk maksimal 5 MB.',
            'image_file.image' => 'Gambar produk wajib berupa foto JPG atau PNG.',
            'image_file.mimes' => 'Format gambar produk hanya diperbolehkan JPG atau PNG.',
            'image_file.max' => 'Ukuran gambar produk maksimal 5 MB.',
            'price.required' => 'Harga produk/pesanan wajib diisi.',
            'price.numeric' => 'Harga produk/pesanan harus berupa angka nominal valid.',
            'price.min' => 'Harga produk/pesanan minimal Rp 1.000.',
            'price.max' => 'Harga produk/pesanan terlalu berlebihan (maksimal Rp 1.000.000).',
            'original_price.numeric' => 'Harga asli/coret harus berupa angka.',
            'original_price.min' => 'Harga asli/coret minimal Rp 1.000.',
            'original_price.max' => 'Harga asli/coret terlalu berlebihan (maksimal Rp 1.000.000).',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except(['image_data', 'image', 'image_file']));
        }

        $resolved = $imageService->resolveJpgOrPngDataUri($request, ['image', 'image_file'], 'image_data', 900);
        if ($resolved['error'] !== null) {
            return back()
                ->withErrors(['image' => $resolved['error']])
                ->withInput($request->except(['image_data', 'image', 'image_file']));
        }

        $imagePath = $product->image;
        if ($resolved['provided']) {
            $imagePath = $resolved['data_uri'];
        } elseif (is_string($request->image) && ! empty($request->image) && ! str_contains($request->image, '..')) {
            $imagePath = ltrim($request->image, '/');
        }

        ImageDataUriService::saveWithLongTextFallback('products', 'image', fn () => $product->update([
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
        ]));

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
            'name' => 'required|string|max:36',
            'sort_order' => 'nullable|integer',
        ]);

        $maxSort = Category::max('sort_order') ?? 0;

        Category::create([
            'name' => $request->name,
            'slug' => Str::limit(Str::slug($request->name), 36, '') . '-' . rand(10, 99),
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
            'name' => 'required|string|max:36',
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
    public function updateProfile(Request $request, ImageDataUriService $imageService)
    {
        $user = Auth::user();

        if ($request->filled('email')) {
            $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:60|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
            'avatar_data' => 'nullable|string|max:4194304',
            'current_password' => 'nullable|current_password',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'avatar.image' => 'Foto profil wajib berupa file gambar JPG atau PNG.',
            'avatar.mimes' => 'Format foto profil hanya diperbolehkan JPG atau PNG.',
            'avatar.max' => 'Ukuran foto profil maksimal 4 MB.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except(['avatar_data', 'avatar', 'password', 'password_confirmation']));
        }

        $resolved = $imageService->resolveJpgOrPngDataUri($request, ['avatar'], 'avatar_data', 512);
        if ($resolved['error'] !== null) {
            return back()
                ->withErrors(['avatar' => $resolved['error']])
                ->withInput($request->except(['avatar_data', 'avatar', 'password', 'password_confirmation']));
        }

        $emailChanged = $user->email !== $request->email;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($emailChanged) {
            $user->email_verified_at = null;
        }
        if ($request->filled('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($resolved['provided']) {
            $user->avatar = $resolved['data_uri'];
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->setRememberToken(Str::random(60));
        }

        ImageDataUriService::saveWithLongTextFallback('users', 'avatar', fn () => $user->save());

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
                $q->whereLike('comment', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->whereLike('name', "%{$search}%"))
                    ->orWhereHas('order', fn ($o) => $o->whereLike('order_number', "%{$search}%")->orWhereLike('customer_name', "%{$search}%"));
            });
            $hasFilter = true;
        }

        $messages = $query->paginate(8)->withQueryString();
        $totalCount = $hasFilter ? Review::count() : $messages->total();

        return view('admin.messages', compact('messages', 'rating', 'search', 'totalCount'));
    }
}

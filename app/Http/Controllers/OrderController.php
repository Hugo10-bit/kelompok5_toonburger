<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\Payment;
use App\Models\RestaurantTable;
use App\Models\Review;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Show checkout page.
     */
    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Wajib login terlebih dahulu untuk checkout pesanan.');
        }

        $cartController = new CartController();
        $cart = $cartController->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('menu')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $tables = RestaurantTable::orderBy('table_number')->get();
        $selectedTable = $request->query('table');

        return view('orders.checkout', compact('cart', 'tables', 'selectedTable'));
    }

    /**
     * Store new order from checkout.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Wajib login terlebih dahulu.');
        }

        $cartController = new CartController();
        $cart = $cartController->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('menu')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'order_type' => 'required|in:takeaway,delivery,dine_in',
            'customer_name' => 'required|string|max:60',
            'customer_phone' => 'required|string|max:15',
            'restaurant_table_id' => 'nullable',
            'delivery_address' => 'nullable|required_if:order_type,delivery|string|max:500',
            'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
            'notes' => 'nullable|string|max:500',
        ], [
            'delivery_address.required_if' => 'Alamat pengiriman wajib diisi untuk Pesan Antar (Delivery).',
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        return DB::transaction(function () use ($request, $cart) {
            // Force order type to takeaway if dine_in was sent
            $orderType = in_array($request->order_type, ['takeaway', 'delivery']) ? $request->order_type : 'takeaway';

            // Generate unique order number TB-YYYYMMDD-XXXX (Toon Burger)
            $datePrefix = 'TB-' . date('Ymd');
            $countToday = Order::where('order_number', 'like', "{$datePrefix}-%")->count() + 1;
            $orderNumber = $datePrefix . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
            while (Order::where('order_number', $orderNumber)->exists()) {
                $countToday++;
                $orderNumber = $datePrefix . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
            }

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'restaurant_table_id' => null,
                'order_type' => $orderType,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'subtotal' => $cart['subtotal'],
                'tax_amount' => $cart['tax'],
                'discount_amount' => $cart['discount'],
                'total_amount' => $cart['total'],
                'notes' => $request->notes,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
            ]);

            // Save order items & options
            foreach ($cart['items'] as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['total_price'],
                    'notes' => $item['notes'] ?? null,
                ]);

                if (!empty($item['options']) && \Illuminate\Support\Facades\Schema::hasTable('order_item_options')) {
                    foreach ($item['options'] as $opt) {
                        OrderItemOption::create([
                            'order_item_id' => $orderItem->id,
                            'option_name' => $opt['option_name'],
                            'option_value_name' => $opt['value_name'],
                            'additional_price' => $opt['additional_price'],
                        ]);
                    }
                }
            }

            // Create initial payment record if table exists
            if (\Illuminate\Support\Facades\Schema::hasTable('payments')) {
                Payment::create([
                    'order_id' => $order->id,
                    'transaction_code' => 'PAY-' . strtoupper(Str::random(10)),
                    'payment_method' => $request->payment_method,
                    'amount' => $order->total_amount,
                    'status' => 'pending',
                    'payment_details' => [
                        'created_by' => Auth::check() ? Auth::user()->name : 'Guest',
                        'order_type' => $request->order_type,
                    ],
                ]);
            }

            // If table occupied, update table status
            if ($order->restaurant_table_id) {
                RestaurantTable::where('id', $order->restaurant_table_id)->update(['status' => 'occupied']);
            }

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->order_number)->with('success', 'Pesanan Anda berhasil dibuat!');
        });
    }

    /**
     * Show live order tracker & invoice page.
     */
    public function show($order_number, MidtransService $midtrans)
    {
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isStaff())) {
            return redirect()->route('admin.orders.show', $order_number);
        }

        $relations = ['items', 'table', 'reviews'];
        if (\Illuminate\Support\Facades\Schema::hasTable('payments')) {
            $relations[] = 'payment';
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
            $relations[] = 'items.product';
        }

        $order = Order::with($relations)
            ->where('order_number', $order_number)
            ->firstOrFail();

        $this->authorizeOrderOwner($order);

        $midtransConfigured = $midtrans->isConfigured();
        if ($midtransConfigured && $order->payment_status !== 'paid' && $order->payment_method !== 'cash' && empty($order->snap_token)) {
            $midtrans->createSnapTransaction($order);
            $order->refresh();
        }

        $snapScriptUrl = $midtrans->snapScriptUrl();
        $midtransClientKey = $midtrans->clientKey();

        return view('orders.show', compact(
            'order',
            'midtransConfigured',
            'snapScriptUrl',
            'midtransClientKey'
        ));
    }

    /**
     * Ensure the authenticated user owns the order (or is admin/staff).
     */
    private function authorizeOrderOwner(Order $order): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        if (Auth::user()->isAdmin() || Auth::user()->isStaff()) {
            return;
        }

        if ($order->user_id && (int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }

    /**
     * Create or regenerate a Midtrans Snap token for an unpaid order.
     */
    public function createMidtransToken(Request $request, $order_number, MidtransService $midtrans)
    {
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();
        $this->authorizeOrderOwner($order);

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'already_paid' => true,
                'message' => 'Pesanan ini sudah lunas.',
            ]);
        }

        $forceNew = $request->boolean('force_new', false);
        $result = $midtrans->createSnapTransaction($order, $forceNew);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * Query Midtrans directly to synchronize verified payment status.
     */
    public function syncMidtransPayment($order_number, MidtransService $midtrans)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        $this->authorizeOrderOwner($order);

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'payment_status' => 'paid',
                'status' => $order->status,
            ]);
        }

        $reference = $order->payment_reference ?: $order->order_number;
        $statusPayload = $midtrans->fetchTransactionStatus($reference);
        if ($statusPayload) {
            $midtrans->applyGatewayStatus($order, $statusPayload);
            $order->refresh();
        }

        return response()->json([
            'success' => true,
            'payment_status' => $order->payment_status,
            'status' => $order->status,
        ]);
    }

    /**
     * Lightweight endpoint for auto-polling live order payment status.
     */
    public function paymentStatus($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        $this->authorizeOrderOwner($order);

        return response()->json([
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'paid_at' => optional($order->paid_at)->toIso8601String(),
        ]);
    }

    /**
     * Receive and verify automatic webhook notifications from Midtrans.
     */
    public function handleMidtransWebhook(Request $request, MidtransService $midtrans)
    {
        $payload = $request->all();

        if (! $midtrans->verifySignature($payload)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $midtransOrderId = (string) ($payload['order_id'] ?? '');
        $order = $midtrans->findOrderForReference($midtransOrderId);
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $result = $midtrans->applyGatewayStatus($order, $payload);

        return response()->json([
            'message' => 'Webhook processed',
            'result' => $result,
        ]);
    }

    /**
     * Customer past orders history.
     */
    public function myOrders()
    {
        $orders = Order::with(['items', 'table'])
            ->where(function ($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('id', 0); // empty for unauthenticated
                }
            })
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Submit review and rating for an ordered product.
     */
    public function storeReview(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        $this->authorizeOrderOwner($order);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id() ?? 1,
                'order_id' => $order->id,
                'product_id' => $request->product_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Terima kasih atas ulasan dan penilaian Anda!');
    }
}

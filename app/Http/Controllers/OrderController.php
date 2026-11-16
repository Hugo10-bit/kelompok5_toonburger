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
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
     * Store customer-uploaded payment proof directly in the system for admin verification.
     */
    public function uploadPaymentProof(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        $this->authorizeOrderOwner($order);

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Pembayaran pesanan ini sudah berstatus LUNAS.');
        }

        if ($order->status === 'cancelled') {
            return redirect()->route('orders.show', $order->order_number)
                ->with('error', 'Pesanan yang dibatalkan tidak dapat mengunggah bukti pembayaran.');
        }

        if ($order->payment_method === 'cash') {
            return redirect()->route('orders.show', $order->order_number)
                ->with('error', 'Pembayaran tunai dilakukan langsung ke kasir tanpa perlu unggah bukti.');
        }

        $validator = Validator::make($request->all(), [
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'proof_data' => 'nullable|string',
            'payment_proof_note' => 'nullable|string|max:255',
        ], [
            'proof_image.image' => 'Bukti pembayaran wajib berupa gambar/screenshot (JPEG, PNG, atau WEBP).',
            'proof_image.mimes' => 'Format gambar bukti harus JPEG, PNG, JPG, atau WEBP.',
            'proof_image.max' => 'Ukuran gambar bukti maksimal 5 MB.',
            'payment_proof_note.max' => 'Catatan pengiriman maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.show', $order->order_number)
                ->withErrors($validator)
                ->withInput($request->except(['proof_data', 'proof_image']));
        }

        $dataUri = $this->resolvePaymentProofDataUri($request);
        if (! $dataUri) {
            return redirect()->route('orders.show', $order->order_number)
                ->withErrors(['proof_image' => 'Pilih atau unggah foto screenshot bukti transfer yang valid terlebih dahulu.'])
                ->withInput($request->except(['proof_data', 'proof_image']));
        }

        $note = $request->filled('payment_proof_note')
            ? trim((string) $request->input('payment_proof_note'))
            : null;

        $order->update([
            'payment_proof' => $dataUri,
            'payment_proof_uploaded_at' => now(),
            'payment_proof_note' => $note,
            'payment_proof_rejected_reason' => null,
            'payment_gateway' => $order->payment_gateway ?: 'manual_upload',
        ]);

        if (Schema::hasTable('payments')) {
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_code' => $order->payment?->transaction_code ?? ('PAY-' . strtoupper(Str::random(10))),
                    'payment_method' => $order->payment_method,
                    'amount' => $order->total_amount,
                    'status' => 'pending',
                    'payment_details' => [
                        'uploaded_by' => Auth::user()?->name ?? $order->customer_name,
                        'uploaded_at' => now()->toIso8601String(),
                        'note' => $note,
                    ],
                ]
            );
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Bukti pembayaran berhasil dikirim ke sistem! Admin / Kasir akan segera mengonfirmasi pesanan Anda.');
    }

    /**
     * Extract, validate, and optionally optimize the uploaded proof image into a base64 data URI.
     */
    private function resolvePaymentProofDataUri(Request $request): ?string
    {
        $rawDataUrl = trim((string) $request->input('proof_data', ''));
        if ($rawDataUrl !== '' && preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,([A-Za-z0-9+\/=]+)$/', $rawDataUrl, $matches)) {
            $binary = base64_decode($matches[2], true);
            if ($binary !== false && strlen($binary) > 0 && strlen($binary) <= 2097152 && @getimagesizefromstring($binary) !== false) {
                $mime = $matches[1] === 'jpg' ? 'jpeg' : $matches[1];
                return "data:image/{$mime};base64," . base64_encode($binary);
            }
        }

        if (! $request->hasFile('proof_image')) {
            return null;
        }

        $file = $request->file('proof_image');
        if (! $file->isValid()) {
            return null;
        }

        $binary = @file_get_contents($file->getRealPath());
        if ($binary === false || @getimagesizefromstring($binary) === false) {
            return null;
        }

        $mime = strtolower((string) $file->getMimeType());
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            $mime = 'image/jpeg';
        }

        return $this->optimizeProofImageBinary($binary, $mime);
    }

    /**
     * Downscale oversized images with GD when available so DB storage remains compact.
     */
    private function optimizeProofImageBinary(string $binary, string $mime): string
    {
        if (function_exists('imagecreatefromstring') && function_exists('imagejpeg')) {
            $img = @imagecreatefromstring($binary);
            if ($img !== false) {
                $width = imagesx($img);
                $height = imagesy($img);
                $maxDim = 1280;

                if ($width > $maxDim || $height > $maxDim || strlen($binary) > 350000) {
                    $scale = min(1, $maxDim / max($width, $height));
                    $newW = max(1, (int) round($width * $scale));
                    $newH = max(1, (int) round($height * $scale));
                    $canvas = imagecreatetruecolor($newW, $newH);
                    $white = imagecolorallocate($canvas, 255, 255, 255);
                    imagefill($canvas, 0, 0, $white);
                    imagecopyresampled($canvas, $img, 0, 0, 0, 0, $newW, $newH, $width, $height);

                    ob_start();
                    imagejpeg($canvas, null, 82);
                    $jpegData = ob_get_clean();
                    imagedestroy($canvas);
                    imagedestroy($img);

                    if ($jpegData !== false && $jpegData !== '') {
                        return 'data:image/jpeg;base64,' . base64_encode($jpegData);
                    }
                } else {
                    imagedestroy($img);
                }
            }
        }

        return "data:{$mime};base64," . base64_encode($binary);
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
            'has_payment_proof' => $order->hasPaymentProof(),
            'proof_rejected' => ! empty($order->payment_proof_rejected_reason),
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

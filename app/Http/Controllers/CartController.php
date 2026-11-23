<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOptionValue;
use App\Models\StoreSetting;
use App\Services\ImageDataUriService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Return consistent JSON rejection when the outlet is closed.
     */
    private function storeClosedResponse(StoreSetting $store)
    {
        return response()->json([
            'success' => false,
            'store_closed' => true,
            'closed_reason' => $store->displayReason(),
            'message' => "Maaf, outlet Toon Burger sedang tutup ({$store->displayReason()}). Silakan pesan kembali saat outlet buka.",
        ], 423);
    }
    /**
     * Get current cart items from session.
     */
    public function getCart()
    {
        if (!auth()->check()) {
            return [
                'items' => [],
                'item_count' => 0,
                'subtotal' => 0,
                'discount' => 0,
                'coupon' => null,
                'tax' => 0,
                'total' => 0,
            ];
        }

        $cart = session()->get('cart', []);

        $productIds = array_values(array_unique(array_filter(array_column($cart, 'product_id'))));
        $dbProducts = ! empty($productIds)
            ? Product::with('category')->whereIn('id', $productIds)->get(['id', 'category_id', 'name', 'price', 'image', 'is_available'])->keyBy('id')
            : collect();

        $subtotal = 0;
        $items = [];
        $cartPruned = false;
        foreach ($cart as $cartKey => $item) {
            $pid = $item['product_id'] ?? null;
            $dbProd = $pid !== null ? $dbProducts->get($pid) : null;
            if (! $dbProd || ! $dbProd->is_available || ($dbProd->category && ! $dbProd->category->is_active) || ! $dbProd->category) {
                unset($cart[$cartKey]);
                $cartPruned = true;
                continue;
            }
            $optExtra = 0.0;
            if (! empty($item['options']) && is_array($item['options'])) {
                foreach ($item['options'] as $opt) {
                    $optExtra += (float) ($opt['additional_price'] ?? 0);
                }
            }
            $item['name'] = $dbProd->name;
            $item['base_price'] = (float) $dbProd->price;
            $item['unit_price'] = (float) $dbProd->price + $optExtra;
            $qty = max(1, min(100, (int) ($item['quantity'] ?? 1)));
            $item['quantity'] = $qty;
            $item['total_price'] = (float) $item['unit_price'] * $qty;
            $subtotal += $item['total_price'];

            $rawImage = ! empty($dbProd->image)
                ? $dbProd->image
                : ($item['image'] ?? null);
            $item['image'] = $rawImage;
            $item['image_url'] = ImageDataUriService::toAssetUrl($rawImage, 'images/burger-bg.jpg');
            $items[] = $item;
        }

        if ($cartPruned) {
            session()->put('cart', $cart);
        }

        $discount = 0;
        $tax = round($subtotal * 0.11);
        $total = max(0, $subtotal + $tax);

        return [
            'items' => $items,
            'item_count' => array_sum(array_column($items, 'quantity')),
            'subtotal' => $subtotal,
            'discount' => 0,
            'coupon' => null,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    /**
     * Return JSON for cart drawer/sidebar.
     */
    public function index()
    {
        return response()->json($this->getCart());
    }

    /**
     * Add an item to cart with options.
     */
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'require_login' => true,
                'message' => 'Wajib login terlebih dahulu untuk menambahkan menu ke keranjang.',
                'redirect' => route('login'),
            ], 401);
        }

        $store = StoreSetting::current();
        if ($store->isClosed()) {
            return $this->storeClosedResponse($store);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:100',
            'options' => 'nullable|array',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);
        if (! $product->is_available || ($product->category && ! $product->category->is_active)) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, menu ini sedang habis atau tidak tersedia.',
            ], 422);
        }

        $quantity = (int) $request->input('quantity', 1);
        $selectedOptions = $request->input('options', []);
        $notes = $request->input('notes', '');

        $optionDetails = [];
        $additionalPrice = 0;

        if (!empty($selectedOptions) && \Illuminate\Support\Facades\Schema::hasTable('product_option_values')) {
            $values = ProductOptionValue::with('option')
                ->whereIn('id', $selectedOptions)
                ->whereHas('option', fn ($q) => $q->where('product_id', $product->id))
                ->get();
            foreach ($values as $val) {
                $optionDetails[] = [
                    'option_id' => $val->product_option_id,
                    'option_name' => $val->option->name ?? 'Option',
                    'value_id' => $val->id,
                    'value_name' => $val->name,
                    'additional_price' => (float)$val->additional_price,
                ];
                $additionalPrice += (float)$val->additional_price;
            }
        }

        $unitPrice = (float)$product->price + $additionalPrice;
        $totalPrice = $unitPrice * $quantity;

        sort($selectedOptions);
        $cartKey = $product->id . '_' . md5(json_encode($selectedOptions) . $notes);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = min(100, $cart[$cartKey]['quantity'] + $quantity);
            $cart[$cartKey]['total_price'] = $cart[$cartKey]['quantity'] * $cart[$cartKey]['unit_price'];
        } else {
            $cart[$cartKey] = [
                'cart_key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => ($product->image && ! str_starts_with($product->image, 'data:')) ? $product->image : null,
                'base_price' => (float)$product->price,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'options' => $optionDetails,
                'notes' => $notes,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => "{$product->name} berhasil ditambahkan ke keranjang!",
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'require_login' => true,
                'message' => 'Wajib login terlebih dahulu.',
                'redirect' => route('login'),
            ], 401);
        }

        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:0|max:100',
        ]);

        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;

        if (isset($cart[$cartKey])) {
            $store = StoreSetting::current();
            if ($store->isClosed() && $request->quantity > ($cart[$cartKey]['quantity'] ?? 0)) {
                return $this->storeClosedResponse($store);
            }
            if ($request->quantity <= 0) {
                unset($cart[$cartKey]);
            } else {
                $cart[$cartKey]['quantity'] = $request->quantity;
                $cart[$cartKey]['total_price'] = $cart[$cartKey]['quantity'] * $cart[$cartKey]['unit_price'];
            }
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'require_login' => true,
                'message' => 'Wajib login terlebih dahulu.',
                'redirect' => route('login'),
            ], 401);
        }

        $request->validate(['cart_key' => 'required|string']);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus dari keranjang.',
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * Clear the whole cart.
     */
    public function clear()
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'require_login' => true,
                'message' => 'Wajib login terlebih dahulu.',
                'redirect' => route('login'),
            ], 401);
        }

        session()->forget('cart');
        return response()->json([
            'success' => true,
            'message' => 'Keranjang dikosongkan.',
            'cart' => $this->getCart(),
        ]);
    }
}

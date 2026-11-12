<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOptionValue;
use Illuminate\Http\Request;

class CartController extends Controller
{
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

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['total_price'];
        }

        $discount = 0;
        $tax = round($subtotal * 0.11); // 11% PPN tax
        $total = max(0, $subtotal + $tax);

        return [
            'items' => array_values($cart),
            'item_count' => array_sum(array_column($cart, 'quantity')),
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

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'options' => 'nullable|array',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);
        $selectedOptions = $request->input('options', []); // array of value IDs
        $notes = $request->input('notes', '');

        // Fetch selected option values to calculate extra cost
        $optionDetails = [];
        $additionalPrice = 0;

        if (!empty($selectedOptions) && \Illuminate\Support\Facades\Schema::hasTable('product_option_values')) {
            $values = ProductOptionValue::with('option')->whereIn('id', $selectedOptions)->get();
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

        // Unique item key based on product and selected option IDs
        sort($selectedOptions);
        $cartKey = $product->id . '_' . md5(json_encode($selectedOptions) . $notes);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
            $cart[$cartKey]['total_price'] = $cart[$cartKey]['quantity'] * $cart[$cartKey]['unit_price'];
        } else {
            $cart[$cartKey] = [
                'cart_key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
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
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;

        if (isset($cart[$cartKey])) {
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

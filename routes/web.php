<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'home'])->name('welcome');
Route::get('/home', [MenuController::class, 'home'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/search-menu', [MenuController::class, 'liveSearch'])->name('menu.search.live');
Route::post('/translate-texts', [MenuController::class, 'translateTexts'])->middleware('throttle:60,1')->name('translate.texts');
Route::get('/about', [MenuController::class, 'about'])->name('about');
Route::get('/contact', [MenuController::class, 'contact'])->name('contact');
Route::post('/contact', [MenuController::class, 'storeContact'])->name('contact.store');
Route::get('/product/{id}', [MenuController::class, 'show'])->name('product.show');
Route::get('/product-image/{product}', [MenuController::class, 'productImage'])->name('product.image');

Route::get('/gofood', function () {
    return redirect()->away('https://gofood.co.id/en/banjarmasin/restaurant/toon-burger-banjarbaru-utara-jln-berlian-7d536afb-38c5-46a8-8a80-e3171a0d6ce9');
})->name('gofood');

Route::get('/whatsapp', function () {
    return redirect()->away('https://wa.me/6281345956487?text=' . urlencode('Halo Toon Burger, saya ingin bertanya mengenai menu dan pemesanan.'));
})->name('whatsapp');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Preview error pages
Route::get('/error/500', fn () => response()->view('errors.500', [], 500))->name('preview.error.500');
Route::get('/error/404', fn () => response()->view('errors.404', [], 404))->name('preview.error.404');
Route::get('/error/503', fn () => response()->view('errors.503', [], 503))->name('preview.error.503');

// Payment Gateway Webhook (CSRF exempted in bootstrap/app.php, verified via SHA-512 signature)
Route::post('/payment/webhook', [OrderController::class, 'handleMidtransWebhook'])->name('payment.webhook');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order_number}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::post('/orders/{order_number}/midtrans-token', [OrderController::class, 'createMidtransToken'])->name('orders.midtrans.token');
    Route::post('/orders/{order_number}/sync-payment', [OrderController::class, 'syncMidtransPayment'])->name('orders.payment.sync');
    Route::get('/orders/{order_number}/payment-status', [OrderController::class, 'paymentStatus'])->name('orders.payment.status');
    Route::post('/orders/{order_number}/payment-proof', [OrderController::class, 'uploadPaymentProof'])->name('orders.payment.proof');
    Route::post('/orders/{order_number}/review', [OrderController::class, 'storeReview'])->name('orders.review');

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::post('/store-status', [AdminController::class, 'toggleStoreStatus'])->name('store.status');
            Route::get('/search-live', [AdminController::class, 'liveSearch'])->name('search.live');

            Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
            Route::get('/orders/{order_number}', [AdminController::class, 'orderDetail'])->name('orders.show');
            Route::match(['post', 'patch'], '/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
            Route::post('/orders/{id}/reject-payment-proof', [AdminController::class, 'rejectPaymentProof'])->name('orders.payment.reject');

            Route::get('/products', [AdminController::class, 'products'])->name('products');
            Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
            Route::match(['post', 'put'], '/products/{id}/update', [AdminController::class, 'updateProduct'])->name('products.update');
            Route::match(['post', 'put'], '/products/{id}', [AdminController::class, 'updateProduct']);
            Route::match(['post', 'patch'], '/products/{id}/toggle', [AdminController::class, 'toggleProduct'])->name('products.toggle');
            Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
            Route::post('/products/{id}/restore', [AdminController::class, 'restoreProduct'])->name('products.restore');

            Route::get('/tables', [AdminController::class, 'tables'])->name('tables');
            Route::post('/tables/{id}/status', [AdminController::class, 'updateTableStatus'])->name('tables.status');

            Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
            Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('categories.store');
            Route::match(['post', 'put'], '/categories/{id}/update', [AdminController::class, 'updateCategory'])->name('categories.update');
            Route::match(['post', 'put'], '/categories/{id}', [AdminController::class, 'updateCategory']);
            Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
            Route::post('/categories/{id}/restore', [AdminController::class, 'restoreCategory'])->name('categories.restore');

            Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
            Route::match(['post', 'patch'], '/messages/{id}/status', [AdminController::class, 'updateMessageStatus'])->name('messages.status');
            Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])->name('messages.delete');
            Route::post('/messages/{id}/restore', [AdminController::class, 'restoreMessage'])->name('messages.restore');

            Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
            Route::match(['post', 'put'], '/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
        });
    });
});

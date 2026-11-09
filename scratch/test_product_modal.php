<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;

echo "=== 1. TEST PRODUCT DETAILS API (MenuController::show) ===\n";
$menuCtrl = new MenuController();

for ($i = 1; $i <= 8; $i++) {
    $res = $menuCtrl->show($i);
    $data = $res->getData(true);
    if (!($data['success'] ?? false)) {
        echo "FAIL product $i: success is false\n";
        exit(1);
    }
    $p = $data['product'];
    echo "Product #{$p['id']}: {$p['name']} | Badge: {$p['badge']} | Price: {$p['formatted_price']} | BG: {$p['bg']}\n";
    echo "  Desc: " . substr($p['description'], 0, 70) . "...\n";
}

echo "\n=== 2. TEST ADD TO CART WITH CUSTOM NOTES (CartController::add) ===\n";
session()->flush();
$cartCtrl = new CartController();

$req = Request::create('/cart/add', 'POST', [
    'product_id' => 6,
    'quantity' => 2,
    'notes' => 'saus dipisah, tanpa selada'
]);

$addRes = $cartCtrl->add($req);
$addData = $addRes->getData(true);

if (!($addData['success'] ?? false)) {
    echo "FAIL add to cart: success is false\n";
    exit(1);
}

$cart = session()->get('cart', []);
echo "Cart items count: " . count($cart) . "\n";
foreach ($cart as $key => $item) {
    echo "Item: {$item['name']} | Qty: {$item['quantity']} | Unit: {$item['unit_price']} | Total: {$item['total_price']}\n";
    echo "Notes: '{$item['notes']}'\n";
    if ($item['notes'] !== 'saus dipisah, tanpa selada') {
        echo "FAIL: notes mismatch!\n";
        exit(1);
    }
}

echo "\nALL TESTS PASSED!\n";

echo "\n=== 3. CHECK EM DASHES IN MODIFIED FILES ===\n";
foreach (['app/Http/Controllers/MenuController.php', 'resources/views/home.blade.php', 'resources/views/layouts/app.blade.php'] as $file) {
    $content = file_get_contents(__DIR__ . '/../' . $file);
    if (strpos($content, "\xE2\x80\x94") !== false) {
        echo "FAIL: Em dash found in $file\n";
        exit(1);
    }
}
echo "Zero em dashes found in all modified files. PASS!\n";

echo "\n=== 4. TEST ROUTE RENDERING ===\n";
foreach (['/', '/menu'] as $uri) {
    $r = Request::create($uri, 'GET');
    $response = $app->handle($r);
    $status = $response->getStatusCode();
    echo "Route $uri: HTTP $status\n";
    if ($status !== 200) {
        echo "FAIL: $uri returned $status\n";
        exit(1);
    }
}
echo "All routes rendered HTTP 200 successfully!\n";

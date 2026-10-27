<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "Verifying all 12 products exist in DB:\n";
for ($i = 1; $i <= 12; $i++) {
    $p = Product::find($i);
    if ($p) {
        echo "Product $i: {$p->name} | Rp {$p->price} | Image: {$p->image} | Exists: " . (file_exists(public_path($p->image)) ? 'YES' : 'NO') . "\n";
    } else {
        echo "Product $i: NOT FOUND!\n";
    }
}

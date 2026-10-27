<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;

echo "Categories count: " . Category::count() . "\n";
foreach(Category::all() as $cat) {
    echo "- ID: {$cat->id}, Name: {$cat->name}, Slug: {$cat->slug}\n";
}

echo "\nProducts count: " . Product::count() . "\n";
foreach(Product::all() as $prod) {
    echo "- ID: {$prod->id}, Name: {$prod->name}, Price: {$prod->price}, Img: {$prod->image}\n";
}

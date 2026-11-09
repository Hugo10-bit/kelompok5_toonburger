<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProductOption;
use App\Models\ProductOptionValue;

$options = ProductOption::with('values')->get();
foreach ($options as $opt) {
    echo "Product ID: {$opt->product_id}, Option: {$opt->name}, Type: {$opt->type}\n";
    foreach ($opt->values as $val) {
        echo "  - Val: {$val->name}, +Rp {$val->additional_price}, Def: {$val->is_default}\n";
    }
}

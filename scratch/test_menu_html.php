<?php
$html = file_get_contents('http://127.0.0.1:8000/menu');
echo "HTML Length: " . strlen($html) . "\n";
echo "Has 'SEMUA MENU': " . (strpos($html, 'SEMUA MENU') !== false ? 'YES' : 'NO') . "\n";
$items = [
    'Very Cheese Burger',
    'Cheese Chicken Burger',
    'BBQ Beef Burger',
    'Double Cheese Burger',
    'Regular Cheese Burger',
    'Beef Burger',
    'Regular Chicken Burger',
    'Hot Chicken Burger',
    'Classic Hotdog',
    'Meat Cheesy Hotdog',
];
foreach ($items as $item) {
    $count = substr_count($html, $item);
    echo "Found '{$item}': {$count} times\n";
}

$colors = ['#F5C518', '#FDE2B8', '#E60000', '#A7D79E', '#B9D7F9', '#FB923C', '#DDD6FE', '#FBCFE8', '#FED7AA'];
foreach ($colors as $color) {
    echo "Found color '{$color}': " . substr_count($html, $color) . "\n";
}

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$catCheese = Category::firstOrCreate(['slug' => 'cheese-burger'], ['name' => 'Cheese Burger', 'is_active' => true, 'sort_order' => 1]);
$catChicken = Category::firstOrCreate(['slug' => 'chicken-burger'], ['name' => 'Chicken Burger', 'is_active' => true, 'sort_order' => 2]);
$catBeef = Category::firstOrCreate(['slug' => 'beef-burger'], ['name' => 'Beef Burger', 'is_active' => true, 'sort_order' => 3]);
$catHotdog = Category::firstOrCreate(['slug' => 'hotdog'], ['name' => 'Hotdog', 'is_active' => true, 'sort_order' => 4]);

$productsData = [
    [
        'id' => 1,
        'name' => 'Very Cheese Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 35000,
        'image' => 'images/products/very-cheese-burger.png',
        'bg_color' => '#F5C518',
        'slug' => 'very-cheese-burger',
    ],
    [
        'id' => 2,
        'name' => 'Cheese Chicken Burger',
        'category_id' => $catChicken->id,
        'category_badge' => 'CHICKEN BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 23000,
        'image' => 'images/products/cheese-chicken-burger.png',
        'bg_color' => '#FDE2B8',
        'slug' => 'cheese-chicken-burger',
    ],
    [
        'id' => 3,
        'name' => 'BBQ Beef Burger',
        'category_id' => $catBeef->id,
        'category_badge' => 'BEEF BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 37000,
        'image' => 'images/products/bbq-beef-burger.png',
        'bg_color' => '#E60000',
        'slug' => 'bbq-beef-burger',
    ],
    [
        'id' => 4,
        'name' => 'Double Cheese Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 33000,
        'image' => 'images/products/double-cheese-burger.png',
        'bg_color' => '#A7D79E',
        'slug' => 'double-cheese-burger-1',
    ],
    [
        'id' => 5,
        'name' => 'Regular Cheese Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 25000,
        'image' => 'images/products/regular-cheese-burger.png',
        'bg_color' => '#B9D7F9',
        'slug' => 'regular-cheese-burger',
    ],
    [
        'id' => 6,
        'name' => 'Beef Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 23000,
        'image' => 'images/products/beef-burger.png',
        'bg_color' => '#FB923C',
        'slug' => 'beef-burger',
    ],
    [
        'id' => 7,
        'name' => 'Regular Chicken Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 35000,
        'image' => 'images/products/regular-chicken-burger.png',
        'bg_color' => '#DDD6FE',
        'slug' => 'regular-chicken-burger',
    ],
    [
        'id' => 8,
        'name' => 'Hot Chicken Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 33000,
        'image' => 'images/products/hot-chicken-burger.png',
        'bg_color' => '#FBCFE8',
        'slug' => 'hot-chicken-burger',
    ],
    [
        'id' => 9,
        'name' => 'Classic Hotdog',
        'category_id' => $catHotdog->id,
        'category_badge' => 'HOTDOG',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 20000,
        'image' => 'images/products/classic-hotdog.png',
        'bg_color' => '#FED7AA',
        'slug' => 'classic-hotdog',
    ],
    [
        'id' => 10,
        'name' => 'Meat Cheesy Hotdog',
        'category_id' => $catHotdog->id,
        'category_badge' => 'HOTDOG',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 33000,
        'image' => 'images/products/meat-cheesy-hotdog.png',
        'bg_color' => '#F5C518',
        'slug' => 'meat-cheesy-hotdog',
    ],
    [
        'id' => 11,
        'name' => 'Double Cheese Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 33000,
        'image' => 'images/products/double-cheese-burger.png',
        'bg_color' => '#A7D79E',
        'slug' => 'double-cheese-burger-2',
    ],
    [
        'id' => 12,
        'name' => 'Double Cheese Burger',
        'category_id' => $catCheese->id,
        'category_badge' => 'CHEESE BURGER',
        'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
        'price' => 33000,
        'image' => 'images/products/double-cheese-burger.png',
        'bg_color' => '#A7D79E',
        'slug' => 'double-cheese-burger-3',
    ],
];

foreach ($productsData as $data) {
    Product::updateOrCreate(
        ['id' => $data['id']],
        [
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
            'slug' => $data['slug'],
            'is_available' => true,
            'is_featured' => ($data['id'] <= 4),
            'calories' => 550,
            'prep_time_minutes' => 10,
        ]
    );
}

echo "Successfully synchronized " . count($productsData) . " products in DB!\n";

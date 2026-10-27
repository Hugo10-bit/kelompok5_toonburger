<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
// use App\Models\OrderItemOption;
// use App\Models\Payment;
use App\Models\Product;
// use App\Models\ProductOption;
// use App\Models\ProductOptionValue;
use App\Models\RestaurantTable;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $defaultAdmin = User::firstOrCreate(
            ['email' => 'admin@toonburger.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'phone_number' => '081234567890',
                'role' => 'admin',
                'address' => 'Jl. Boulevard Utama No. 1, Banjarbaru',
                'password' => Hash::make('Password123'),
            ]
        );

        $admin = User::firstOrCreate(
            ['email' => 'hugo@toonburger.com'],
            [
                'name' => 'Hugo Putra',
                'username' => 'hugo',
                'phone_number' => '081345956487',
                'role' => 'admin',
                'address' => 'Jl. Boulevard Utama No. 1, Banjarbaru',
                'password' => Hash::make('Password123'),
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'kasir@toonburger.com'],
            [
                'name' => 'Kasir Toon Burger',
                'username' => 'kasir_utama',
                'phone_number' => '081298765432',
                'role' => 'staff',
                'address' => 'Outlet Toon Burger Banjarbaru',
                'password' => Hash::make('Password123'),
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'username' => 'budisantoso',
                'phone_number' => '081377889900',
                'role' => 'customer',
                'address' => 'Jl. Mawar Indah No. 12, Banjarmasin',
                'password' => Hash::make('Password123'),
            ]
        );

        // 2. Restaurant Tables
        $tables = [];
        for ($i = 1; $i <= 10; $i++) {
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            $tables[] = RestaurantTable::firstOrCreate(
                ['table_number' => "Meja $num"],
                [
                    'capacity' => ($i % 3 === 0) ? 6 : (($i % 2 === 0) ? 4 : 2),
                    'qr_code' => "QR-TABLE-$num",
                    'status' => ($i === 2) ? 'occupied' : 'available',
                ]
            );
        }

        // 3. Coupons
        Coupon::firstOrCreate(
            ['code' => 'WELCOMEBITE'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 15000,
                'min_spend' => 40000,
                'max_discount' => 15000,
                'valid_from' => now()->subDays(1),
                'valid_until' => now()->addMonths(6),
                'usage_limit' => 500,
                'usage_count' => 12,
                'is_active' => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'TOONBURGER50'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'min_spend' => 60000,
                'max_discount' => 30000,
                'valid_from' => now()->subDays(1),
                'valid_until' => now()->addMonths(3),
                'usage_limit' => 200,
                'usage_count' => 45,
                'is_active' => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'CHEESEFEAST'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 20000,
                'min_spend' => 80000,
                'max_discount' => 20000,
                'valid_from' => now()->subDays(5),
                'valid_until' => now()->addMonths(1),
                'usage_limit' => 100,
                'usage_count' => 8,
                'is_active' => true,
            ]
        );

        // 4. Categories
        $catBurgers = Category::firstOrCreate(
            ['slug' => 'burgers'],
            [
                'name' => 'Signature Burgers',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $catCombos = Category::firstOrCreate(
            ['slug' => 'combos'],
            [
                'name' => 'Rush Combos',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $catChicken = Category::firstOrCreate(
            ['slug' => 'chicken'],
            [
                'name' => 'Crispy Chicken',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        $catSides = Category::firstOrCreate(
            ['slug' => 'sides'],
            [
                'name' => 'Sides & Snacks',
                'is_active' => true,
                'sort_order' => 4,
            ]
        );

        $catDrinks = Category::firstOrCreate(
            ['slug' => 'drinks'],
            [
                'name' => 'Drinks & Shakes',
                'is_active' => true,
                'sort_order' => 5,
            ]
        );

        $catDesserts = Category::firstOrCreate(
            ['slug' => 'desserts'],
            [
                'name' => 'Sweet Desserts',
                'is_active' => true,
                'sort_order' => 6,
            ]
        );

        // 5. Products Matching Screenshot media_1792999772746.png
        $catCheese = Category::firstOrCreate(['slug' => 'cheese-burger'], ['name' => 'Cheese Burger', 'is_active' => true, 'sort_order' => 1]);
        $catChicken = Category::firstOrCreate(['slug' => 'chicken-burger'], ['name' => 'Chicken Burger', 'is_active' => true, 'sort_order' => 2]);
        $catBeef = Category::firstOrCreate(['slug' => 'beef-burger'], ['name' => 'Beef Burger', 'is_active' => true, 'sort_order' => 3]);
        $catHotdog = Category::firstOrCreate(['slug' => 'hotdog'], ['name' => 'Hotdog', 'is_active' => true, 'sort_order' => 4]);

        $menuProducts = [
            [
                'id' => 1,
                'name' => 'Very Cheese Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 35000,
                'image' => 'images/products/very-cheese-burger.png',
                'slug' => 'very-cheese-burger',
            ],
            [
                'id' => 2,
                'name' => 'Cheese Chicken Burger',
                'category_id' => $catChicken->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 23000,
                'image' => 'images/products/cheese-chicken-burger.png',
                'slug' => 'cheese-chicken-burger',
            ],
            [
                'id' => 3,
                'name' => 'BBQ Beef Burger',
                'category_id' => $catBeef->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 37000,
                'image' => 'images/products/bbq-beef-burger.png',
                'slug' => 'bbq-beef-burger',
            ],
            [
                'id' => 4,
                'name' => 'Double Cheese Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/products/double-cheese-burger.png',
                'slug' => 'double-cheese-burger-1',
            ],
            [
                'id' => 5,
                'name' => 'Regular Cheese Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 25000,
                'image' => 'images/products/regular-cheese-burger.png',
                'slug' => 'regular-cheese-burger',
            ],
            [
                'id' => 6,
                'name' => 'Beef Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 23000,
                'image' => 'images/products/beef-burger.png',
                'slug' => 'beef-burger',
            ],
            [
                'id' => 7,
                'name' => 'Regular Chicken Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 35000,
                'image' => 'images/products/regular-chicken-burger.png',
                'slug' => 'regular-chicken-burger',
            ],
            [
                'id' => 8,
                'name' => 'Hot Chicken Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/products/hot-chicken-burger.png',
                'slug' => 'hot-chicken-burger',
            ],
            [
                'id' => 9,
                'name' => 'Classic Hotdog',
                'category_id' => $catHotdog->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 20000,
                'image' => 'images/products/classic-hotdog.png',
                'slug' => 'classic-hotdog',
            ],
            [
                'id' => 10,
                'name' => 'Meat Cheesy Hotdog',
                'category_id' => $catHotdog->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/products/meat-cheesy-hotdog.png',
                'slug' => 'meat-cheesy-hotdog',
            ],
            [
                'id' => 11,
                'name' => 'Double Cheese Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/products/double-cheese-burger.png',
                'slug' => 'double-cheese-burger-2',
            ],
            [
                'id' => 12,
                'name' => 'Double Cheese Burger',
                'category_id' => $catCheese->id,
                'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...',
                'price' => 33000,
                'image' => 'images/products/double-cheese-burger.png',
                'slug' => 'double-cheese-burger-3',
            ],
        ];

        $p1 = null;
        foreach ($menuProducts as $data) {
            $p = Product::updateOrCreate(
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
            if ($data['id'] === 1) {
                $p1 = $p;
            }
        }

        // 6. Sample Completed Order & Payment
        $order = Order::firstOrCreate(
            ['order_number' => 'TB-20260820-0001'],
            [
                'user_id' => $customer->id,
                'restaurant_table_id' => null,
                'order_type' => 'takeaway',
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'qris',
                'subtotal' => 87000,
                'tax_amount' => 8700,
                'discount_amount' => 15000,
                'total_amount' => 80700,
                'notes' => 'Tolong saus sambal diperbanyak ya.',
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone_number,
            ]
        );

        $item1 = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'product_id' => $p1->id],
            [
                'product_name' => $p1->name,
                'price' => 55000,
                'quantity' => 1,
                'subtotal' => 55000,
                'notes' => 'Brioche bun agak garing',
            ]
        );

        // OrderItemOption::firstOrCreate(
        //     ['order_item_id' => $item1->id, 'option_name' => 'Pilihan Patty'],
        //     ['option_value_name' => 'Double Patty (Standard)', 'additional_price' => 0]
        // );
        // OrderItemOption::firstOrCreate(
        //     ['order_item_id' => $item1->id, 'option_name' => 'Ekstra Topping'],
        //     ['option_value_name' => 'Extra Melted Cheddar', 'additional_price' => 6000]
        // );

        $item2 = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'product_name' => 'Loaded Cheese & Bacon Fries'],
            [
                'product_id' => null,
                'price' => 32000,
                'quantity' => 1,
                'subtotal' => 32000,
                'notes' => null,
            ]
        );

        // Payment::firstOrCreate(
        //     ['order_id' => $order->id],
        //     [
        //         'transaction_code' => 'TRX-' . strtoupper(Str::random(10)),
        //         'payment_method' => 'qris',
        //         'amount' => 80700,
        //         'status' => 'success',
        //         'payment_details' => [
        //             'provider' => 'QRIS GoPay / BCA',
        //             'reference_id' => 'QRIS-' . time(),
        //         ],
        //         'paid_at' => now()->subMinutes(30),
        //     ]
        // );

        Review::firstOrCreate(
            ['user_id' => $customer->id, 'product_id' => $p1->id],
            [
                'order_id' => $order->id,
                'rating' => 5,
                'comment' => 'Burger paling juicy dan enak! Keju dan sausnya mantap banget!',
            ]
        );
    }
}

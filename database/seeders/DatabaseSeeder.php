<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $defaultAdmin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Toon Burger',
                'email' => 'Toonburger@gmail.com',
                'phone_number' => '085780153872',
                'role' => 'admin',
                'address' => 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714',
                'password' => Hash::make('Password123'),
            ]
        );

        $admin = User::updateOrCreate(
            ['username' => 'hugo'],
            [
                'name' => 'Hugo Putra',
                'email' => 'hugo@toonburger.com',
                'phone_number' => '081345956487',
                'role' => 'admin',
                'address' => 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714',
                'password' => Hash::make('Password123'),
            ]
        );

        $staff = User::updateOrCreate(
            ['username' => 'kasir_utama'],
            [
                'name' => 'Kasir Toon Burger',
                'email' => 'kasir@toonburger.com',
                'phone_number' => '081298765432',
                'role' => 'staff',
                'address' => 'Outlet Toon Burger Banjarbaru',
                'password' => Hash::make('Password123'),
            ]
        );

        $customer = User::updateOrCreate(
            ['username' => 'budisantoso'],
            [
                'name' => 'Budi Santoso',
                'email' => 'customer@gmail.com',
                'phone_number' => '081377889900',
                'role' => 'customer',
                'address' => 'Jl. Mawar Indah No. 12, Banjarmasin',
                'password' => Hash::make('Password123'),
            ]
        );

        for ($i = 1; $i <= 10; $i++) {
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            RestaurantTable::firstOrCreate(
                ['table_number' => "Meja $num"],
                [
                    'capacity' => ($i % 3 === 0) ? 6 : (($i % 2 === 0) ? 4 : 2),
                    'qr_code' => "QR-TABLE-$num",
                    'status' => ($i === 2) ? 'occupied' : 'available',
                ]
            );
        }

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

        // 7 exact categories from Image 5 (Data Kategori)
        \Illuminate\Support\Facades\DB::table('categories')->update([
            'slug' => \Illuminate\Support\Facades\DB::raw("CONCAT('cat-tmp-', id)")
        ]);
        $categoriesData = [
            ['id' => 1, 'slug' => 'cheese-burger', 'name' => 'Cheese Burger', 'sort_order' => 1],
            ['id' => 2, 'slug' => 'beef-burger', 'name' => 'Beef Burger', 'sort_order' => 2],
            ['id' => 3, 'slug' => 'chicken-burger', 'name' => 'Chicken Burger', 'sort_order' => 3],
            ['id' => 4, 'slug' => 'chicken-wing', 'name' => 'Chicken Wing', 'sort_order' => 4],
            ['id' => 5, 'slug' => 'hot-dog', 'name' => 'Hot Dog', 'sort_order' => 5],
            ['id' => 6, 'slug' => 'snacks', 'name' => 'Snacks', 'sort_order' => 6],
            ['id' => 7, 'slug' => 'minuman', 'name' => 'Minuman', 'sort_order' => 7],
        ];

        $catMap = [];
        foreach ($categoriesData as $catItem) {
            $catMap[$catItem['slug']] = Category::updateOrCreate(
                ['id' => $catItem['id']],
                [
                    'slug' => $catItem['slug'],
                    'name' => $catItem['name'],
                    'is_active' => true,
                    'sort_order' => $catItem['sort_order'],
                ]
            );
        }
        Category::where('id', '>', 7)->update(['is_active' => false]);
        $archivedCat = Category::updateOrCreate(
            ['id' => 8],
            ['slug' => 'archived-menu', 'name' => 'Archived', 'is_active' => false, 'sort_order' => 99]
        );

        // 9 exact products from Image 4 (Data Produk)
        \Illuminate\Support\Facades\DB::table('products')->update([
            'slug' => \Illuminate\Support\Facades\DB::raw("CONCAT('prod-tmp-', id)")
        ]);
        $menuProducts = [
            [
                'id' => 1,
                'name' => 'very Cheese Burger',
                'category_id' => $catMap['cheese-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 33000,
                'calories' => 300,
                'is_available' => true,
                'image' => 'images/products/very-cheese-burger.png',
                'slug' => 'very-cheese-burger',
            ],
            [
                'id' => 2,
                'name' => 'Beef Burger',
                'category_id' => $catMap['beef-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 29000,
                'calories' => 320,
                'is_available' => true,
                'image' => 'images/products/beef-burger.png',
                'slug' => 'beef-burger',
            ],
            [
                'id' => 3,
                'name' => 'BBQ Burger',
                'category_id' => $catMap['beef-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 29000,
                'calories' => 280,
                'is_available' => true,
                'image' => 'images/products/bbq-beef-burger.png',
                'slug' => 'bbq-burger',
            ],
            [
                'id' => 4,
                'name' => 'Double Cheese Burger',
                'category_id' => $catMap['cheese-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 43000,
                'calories' => 480,
                'is_available' => true,
                'image' => 'images/products/double-cheese-burger.png',
                'slug' => 'double-cheese-burger',
            ],
            [
                'id' => 5,
                'name' => 'Hot Chicken Burger',
                'category_id' => $catMap['chicken-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 33000,
                'calories' => 450,
                'is_available' => true,
                'image' => 'images/products/hot-chicken-burger.png',
                'slug' => 'hot-chicken-burger',
            ],
            [
                'id' => 6,
                'name' => 'Cheese Chicken Burger',
                'category_id' => $catMap['chicken-burger']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 35000,
                'calories' => 370,
                'is_available' => true,
                'image' => 'images/products/cheese-chicken-burger.png',
                'slug' => 'cheese-chicken-burger',
            ],
            [
                'id' => 7,
                'name' => 'Classic Hotdog',
                'category_id' => $catMap['hot-dog']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 27500,
                'calories' => 250,
                'is_available' => false,
                'image' => 'images/products/classic-hotdog.png',
                'slug' => 'classic-hotdog',
            ],
            [
                'id' => 8,
                'name' => 'Meat Cheesy Hotdog',
                'category_id' => $catMap['hot-dog']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 33000,
                'calories' => 270,
                'is_available' => false,
                'image' => 'images/products/meat-cheesy-hotdog.png',
                'slug' => 'meat-cheesy-hotdog-1',
            ],
            [
                'id' => 9,
                'name' => 'Meat Cheesy Hotdog',
                'category_id' => $catMap['hot-dog']->id,
                'description' => 'Burger dengan patty daging yang juicy,',
                'price' => 60000,
                'calories' => 250,
                'is_available' => false,
                'image' => 'images/products/meat-cheesy-hotdog.png',
                'slug' => 'meat-cheesy-hotdog-2',
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
                    'is_available' => $data['is_available'],
                    'is_featured' => ($data['id'] <= 4),
                    'calories' => $data['calories'],
                    'prep_time_minutes' => 10,
                ]
            );
            if ($data['id'] === 1) {
                $p1 = $p;
            }
        }
        Product::where('id', '>', 9)->update(['category_id' => $archivedCat->id]);

        // 12 Orders matching Image 3 (Proses pesanan):
        // Counts: Semua (12), Menunggu (2), Dimasak (5), Siap Saji (3), Selesai (2)
        \Illuminate\Support\Facades\DB::table('orders')->update([
            'order_number' => \Illuminate\Support\Facades\DB::raw("CONCAT('ORD-TMP-', id)")
        ]);
        $ordersData = [
            [
                'order_number' => 'TB-20260917-00012',
                'customer_name' => 'Hugo Putra',
                'status' => 'pending',
                'total_amount' => 125000,
                'notes' => '3 Menit yang lalu',
                'mins_ago' => 3,
            ],
            [
                'order_number' => 'TB-20260917-00011',
                'customer_name' => 'Adzriel Fathi',
                'status' => 'pending',
                'total_amount' => 125000,
                'notes' => '5 Menit yang lalu',
                'mins_ago' => 5,
            ],
            [
                'order_number' => 'TB-20260917-00010',
                'customer_name' => 'Cornelius Hugo',
                'status' => 'preparing',
                'total_amount' => 125000,
                'notes' => '8 Menit yang lalu',
                'mins_ago' => 8,
            ],
            [
                'order_number' => 'TB-20260917-00009',
                'customer_name' => 'Waiz Fadillah',
                'status' => 'preparing',
                'total_amount' => 125000,
                'notes' => '10 Menit yang lalu',
                'mins_ago' => 10,
            ],
            [
                'order_number' => 'TB-20260917-00008',
                'customer_name' => 'Rakha Azhar',
                'status' => 'preparing',
                'total_amount' => 125000,
                'notes' => '11 menit yang lalu',
                'mins_ago' => 11,
            ],
            [
                'order_number' => 'TB-20260917-00007',
                'customer_name' => 'Hugo Putra',
                'status' => 'preparing',
                'total_amount' => 125000,
                'notes' => '25 menityang lalu',
                'mins_ago' => 25,
            ],
            [
                'order_number' => 'TB-20260917-00006',
                'customer_name' => 'Rizki Prawira',
                'status' => 'preparing',
                'total_amount' => 87500,
                'notes' => '30 Menit yang lalu',
                'mins_ago' => 30,
            ],
            [
                'order_number' => 'TB-20260917-00005',
                'customer_name' => 'Hugo Putra',
                'status' => 'ready',
                'total_amount' => 60500,
                'notes' => '35 Menit yang lalu',
                'mins_ago' => 35,
            ],
            [
                'order_number' => 'TB-20260917-00004',
                'customer_name' => 'Budi Santoso',
                'status' => 'ready',
                'total_amount' => 125000,
                'notes' => '40 Menit yang lalu',
                'mins_ago' => 40,
            ],
            [
                'order_number' => 'TB-20260917-00003',
                'customer_name' => 'Nadia Putri',
                'status' => 'ready',
                'total_amount' => 125000,
                'notes' => '45 Menit yang lalu',
                'mins_ago' => 45,
            ],
            [
                'order_number' => 'TB-20260917-00002',
                'customer_name' => 'Adzriel Fathi',
                'status' => 'completed',
                'total_amount' => 66000,
                'notes' => '50 Menit yang lalu',
                'mins_ago' => 50,
            ],
            [
                'order_number' => 'TB-20260917-00001',
                'customer_name' => 'Dimas Pratama',
                'status' => 'completed',
                'total_amount' => 125000,
                'notes' => '55 Menit yang lalu',
                'mins_ago' => 55,
            ],
        ];

        foreach ($ordersData as $idx => $ordInfo) {
            $order = Order::updateOrCreate(
                ['id' => $idx + 1],
                [
                    'order_number' => $ordInfo['order_number'],
                    'user_id' => $customer->id,
                    'restaurant_table_id' => null,
                    'order_type' => 'takeaway',
                    'status' => $ordInfo['status'],
                    'payment_status' => 'paid',
                    'payment_method' => 'qris',
                    'subtotal' => 114000,
                    'tax_amount' => 11000,
                    'discount_amount' => 0,
                    'total_amount' => $ordInfo['total_amount'],
                    'notes' => $ordInfo['notes'],
                    'customer_name' => $ordInfo['customer_name'],
                    'customer_phone' => '085780153872',
                    'created_at' => now()->subMinutes($ordInfo['mins_ago']),
                    'updated_at' => now()->subMinutes($ordInfo['mins_ago']),
                ]
            );

            $existingItems = OrderItem::where('order_id', $order->id)->orderBy('id')->get();
            for ($k = 0; $k < 3; $k++) {
                if (isset($existingItems[$k])) {
                    $existingItems[$k]->update([
                        'product_id' => $p1->id,
                        'product_name' => 'Very cheese Burger',
                        'price' => 38000,
                        'quantity' => 1,
                        'subtotal' => 38000,
                    ]);
                } else {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p1->id,
                        'product_name' => 'Very cheese Burger',
                        'price' => 38000,
                        'quantity' => 1,
                        'subtotal' => 38000,
                    ]);
                }
            }
        }

        $firstOrder = Order::first();
        if ($firstOrder && $p1) {
            Review::firstOrCreate(
                ['user_id' => $customer->id, 'product_id' => $p1->id],
                [
                    'order_id' => $firstOrder->id,
                    'rating' => 5,
                    'comment' => 'Burger paling juicy dan enak! Keju dan sausnya mantap banget!',
                ]
            );
        }
    }
}

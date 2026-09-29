<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminMockupSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;
        $category = Category::first() ?? Category::create([
            'name' => 'Signature Burgers',
            'slug' => 'signature-burgers',
        ]);

        // 1. Seed Top Products exactly as named in the mockup
        $mockProducts = [
            ['name' => 'Cheese Chiken Burger', 'price' => 35000, 'sold' => 179, 'is_available' => true],
            ['name' => 'Very Cheese Burger', 'price' => 42000, 'sold' => 170, 'is_available' => true],
            ['name' => 'Double Beef Burger', 'price' => 48000, 'sold' => 156, 'is_available' => true],
            ['name' => 'BBQ Beef Burger', 'price' => 45000, 'sold' => 150, 'is_available' => true],
            ['name' => 'Hot Chiken Burger', 'price' => 38000, 'sold' => 138, 'is_available' => true],
        ];

        foreach ($mockProducts as $pData) {
            Product::updateOrCreate(
                ['name' => $pData['name']],
                [
                    'category_id' => $category->id,
                    'slug' => Str::slug($pData['name']),
                    'description' => 'Burger lezat khas Toon Burger dengan bahan berkualitas.',
                    'price' => $pData['price'],
                    'original_price' => $pData['price'] + 5000,
                    'is_available' => $pData['is_available'],
                    'is_featured' => true,
                ]
            );
        }

        // Fill products up to 24 (20 active, 2 out of stock, 2 drafts or reserved)
        Product::whereNotIn('name', array_column($mockProducts, 'name'))->delete();
        // 5 mock products are active. Need 15 more active to make 20 active.
        for ($i = 6; $i <= 20; $i++) {
            Product::create([
                'name' => 'Toon Special Menu ' . $i,
                'category_id' => $category->id,
                'slug' => 'toon-special-menu-' . $i,
                'description' => 'Pilihan menu lezat Toon Burger.',
                'price' => 25000 + ($i * 1000),
                'is_available' => true,
            ]);
        }
        // 2 out of stocks
        for ($i = 21; $i <= 22; $i++) {
            Product::create([
                'name' => 'Toon Seasonal Burger ' . $i,
                'category_id' => $category->id,
                'slug' => 'toon-seasonal-burger-' . $i,
                'description' => 'Menu musiman Toon Burger.',
                'price' => 45000,
                'is_available' => false,
            ]);
        }
        // 2 more items to make total 24
        for ($i = 23; $i <= 24; $i++) {
            Product::create([
                'name' => 'Toon Limited Edition ' . $i,
                'category_id' => $category->id,
                'slug' => 'toon-limited-edition-' . $i,
                'description' => 'Menu edisi terbatas.',
                'price' => 50000,
                'is_available' => false,
            ]);
        }

        // 2. Seed 5 Latest Orders from Mockup
        $latestOrders = [
            [
                'order_number' => 'TB-20260917-0007',
                'customer_name' => 'Adzriel Fathi',
                'customer_phone' => '081234567801',
                'total_amount' => 66000,
                'status' => 'completed',
                'created_at' => Carbon::now()->subMinutes(15),
            ],
            [
                'order_number' => 'TB-20260917-0008',
                'customer_name' => 'Hugo Putra',
                'customer_phone' => '081234567802',
                'total_amount' => 60500,
                'status' => 'ready',
                'created_at' => Carbon::now()->subMinutes(25),
            ],
            [
                'order_number' => 'TB-20260917-0009',
                'customer_name' => 'Cornelius Hugo',
                'customer_phone' => '081234567803',
                'total_amount' => 126500,
                'status' => 'preparing',
                'created_at' => Carbon::now()->subMinutes(35),
            ],
            [
                'order_number' => 'TB-20260917-0010',
                'customer_name' => 'Rizki Prawira',
                'customer_phone' => '081234567804',
                'total_amount' => 87500,
                'status' => 'preparing',
                'created_at' => Carbon::now()->subMinutes(45),
            ],
            [
                'order_number' => 'TB-20260917-0011',
                'customer_name' => 'Waiz Fadillah',
                'customer_phone' => '081234567805',
                'total_amount' => 55000,
                'status' => 'pending',
                'created_at' => Carbon::now()->subMinutes(55),
            ],
        ];

        foreach ($latestOrders as $ord) {
            $createdOrder = Order::updateOrCreate(
                ['order_number' => $ord['order_number']],
                [
                    'user_id' => $adminId,
                    'customer_name' => $ord['customer_name'],
                    'customer_phone' => $ord['customer_phone'],
                    'order_type' => 'dine_in',
                    'status' => $ord['status'],
                    'payment_status' => 'paid',
                    'payment_method' => 'qris',
                    'subtotal' => $ord['total_amount'],
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $ord['total_amount'],
                    'created_at' => $ord['created_at'],
                    'updated_at' => $ord['created_at'],
                ]
            );

            // Add dummy item to order
            OrderItem::firstOrCreate(
                ['order_id' => $createdOrder->id],
                [
                    'product_name' => 'Cheese Chiken Burger',
                    'price' => $ord['total_amount'],
                    'quantity' => 1,
                    'subtotal' => $ord['total_amount'],
                ]
            );
        }

        // 3. Ensure Best Selling Menu aggregates match the mockup numbers
        foreach ($mockProducts as $pData) {
            $existingQty = OrderItem::where('product_name', $pData['name'])->sum('quantity');
            $diff = $pData['sold'] - $existingQty;
            if ($diff > 0) {
                $refOrder = Order::first();
                OrderItem::create([
                    'order_id' => $refOrder->id,
                    'product_name' => $pData['name'],
                    'price' => $pData['price'],
                    'quantity' => $diff,
                    'subtotal' => $pData['price'] * $diff,
                ]);
            }
        }
    }
}

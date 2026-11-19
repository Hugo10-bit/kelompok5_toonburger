<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Raka Pratama',
                'phone' => '0812-3456-7890',
                'email' => 'raka.pratama@gmail.com',
                'message' => 'Halo admin Toon Burger, apakah paket Very Cheese Burger tersedia untuk pesanan acara ulang tahun sebanyak 25 porsi akhir pekan ini?',
                'is_read' => false,
                'minutes_ago' => 12,
            ],
            [
                'name' => 'Nadia Azzahra',
                'phone' => '0857-9012-3344',
                'email' => 'nadia.azzahra@yahoo.com',
                'message' => 'Kak mau tanya, saus keju pada Double Cheese Burger apakah bisa dipisah dan apakah semua bahan daging di Toon Burger sudah halal?',
                'is_read' => false,
                'minutes_ago' => 38,
            ],
            [
                'name' => 'Dimas Saputra',
                'phone' => '0813-4455-6677',
                'email' => 'dimas.saputra@gmail.com',
                'message' => 'Tadi saya pesan takeaway Hot Chicken Burger tapi lupa menambahkan catatan tanpa acar. Apakah masih bisa disesuaikan sebelum dimasak?',
                'is_read' => false,
                'minutes_ago' => 75,
            ],
            [
                'name' => 'Siti Rahmawati',
                'phone' => '0821-7788-1122',
                'email' => 'siti.rahma98@gmail.com',
                'message' => 'Mau kasih masukan, burger BBQ Beef kemarin enak banget dan rotinya empuk! Semoga ke depannya ada tambahan menu kentang goreng keju.',
                'is_read' => true,
                'minutes_ago' => 180,
            ],
            [
                'name' => 'Fajar Nugroho',
                'phone' => '0852-6611-9988',
                'email' => 'fajar.nugroho@hotmail.com',
                'message' => 'Permisi kak, outlet Toon Burger di Loktabat Utara apakah menerima pembayaran QRIS dan apakah ada area duduk untuk makan di tempat?',
                'is_read' => true,
                'minutes_ago' => 340,
            ],
            [
                'name' => 'Aulia Putri',
                'phone' => '0819-2233-4455',
                'email' => 'aulia.putri22@gmail.com',
                'message' => 'Halo tim Toon Burger, kemarin saya coba Cheese Chicken Burger lewat GoFood dan rasanya juara. Apakah ada promo bundling untuk pelajar?',
                'is_read' => true,
                'minutes_ago' => 620,
            ],
            [
                'name' => 'Bima Mahendra',
                'phone' => '0811-5566-7788',
                'email' => 'bima.mahendra@gmail.com',
                'message' => 'Selamat malam, apakah Toon Burger buka sampai jam 22.00 WITA setiap hari termasuk hari libur nasional? Rencana mau mampir malam ini.',
                'is_read' => true,
                'minutes_ago' => 1120,
            ],
            [
                'name' => 'Clarissa Wijaya',
                'phone' => '0878-3344-9900',
                'email' => 'clarissa.wijaya@yahoo.com',
                'message' => 'Halo kak, saya tertarik kerja sama untuk event bazar kampus bulan depan di Banjarbaru. Boleh minta kontak PIC untuk kemitraan tenant?',
                'is_read' => true,
                'minutes_ago' => 1850,
            ],
            [
                'name' => 'Hendra Kusuma',
                'phone' => '0812-9988-7766',
                'email' => 'hendra.kusuma@gmail.com',
                'message' => 'Terima kasih pelayanannya sangat ramah dan cepat! Classic Hotdog dan Beef Burger sampai rumah masih hangat dengan kemasan yang rapi.',
                'is_read' => true,
                'minutes_ago' => 2700,
            ],
        ];

        foreach ($messages as $item) {
            $timestamp = now()->subMinutes($item['minutes_ago']);

            ContactMessage::updateOrCreate(
                [
                    'email' => $item['email'],
                    'name' => $item['name'],
                ],
                [
                    'phone' => $item['phone'],
                    'message' => $item['message'],
                    'is_read' => $item['is_read'],
                    'read_at' => $item['is_read'] ? $timestamp->copy()->addMinutes(10) : null,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]
            );
        }
    }
}

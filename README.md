# Toon Burger

Toon Burger adalah aplikasi web pemesanan burger berbasis Laravel yang dirancang untuk mempermudah proses pemesanan pelanggan serta manajemen operasional restoran. Project ini mencakup sisi pelanggan untuk menjelajahi menu, menambahkan produk ke keranjang, melakukan checkout, hingga melihat riwayat dan memberikan review pesanan, serta panel admin untuk mengelola produk, kategori, meja, pesanan, dan pesan pelanggan.

## Tentang Project

Project ini dikembangkan untuk mendukung operasional Toon Burger dengan fokus pada:

- Pemesanan online yang cepat dan responsif
- Dukungan pemesanan takeaway, delivery, dan dine-in
- Manajemen menu, kategori, dan ketersediaan produk
- Panel admin untuk pemrosesan pesanan dan manajemen meja
- Sistem review pelanggan
- Integrasi redirect ke GoFood dan WhatsApp resmi Toon Burger
- Dukungan pengalihan bahasa (Indonesia / English) pada antarmuka pengguna

## Fitur Utama

### Untuk Pelanggan

- Halaman utama, tentang kami (`/about`), dan kontak (`/contact`)
- Katalog menu, detail produk, dan pencarian menu secara langsung (*live search*)
- Keranjang belanja dinamis (memerlukan autentikasi untuk menambah item dan checkout)
- Proses checkout dan pembuatan pesanan
- Detail pesanan, pembayaran, dan pemantauan status pesanan
- Riwayat pesanan pelanggan (`/my-orders`)
- Fitur review produk setelah pemesanan
- Pengalihan bahasa antarmuka (ID / EN)
- Pintasan redirect ke GoFood dan WhatsApp

### Untuk Admin / Staff

- Dashboard admin dengan ringkasan operasional dan pencarian *live*
- Manajemen pesanan dan pembaruan status pesanan
- Manajemen produk (tambah, edit, hapus, dan toggle ketersediaan)
- Manajemen kategori menu
- Manajemen meja restoran dan status meja
- Daftar pesan pelanggan
- Manajemen profil admin

## Teknologi yang Digunakan

- PHP 8.4+
- Laravel 12 (dengan Laravel Breeze & Socialite)
- JavaScript & Alpine.js
- Vite
- Tailwind CSS
- Composer
- MySQL / SQLite

## Struktur Project

```text
.
├── app/
│   ├── Http/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   ├── images/
│   ├── js/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── tests/
├── .env.example
├── composer.json
├── package.json
├── README.md
```

## Persyaratan Sistem

Sebelum menjalankan project, pastikan sistem Anda sudah memiliki:

- PHP >= 8.4+
- Composer
- Node.js dan npm
- Database (MySQL atau SQLite)

## Cara Menjalankan Project

1. Clone repository

```bash
git clone <repository-url>
cd kelompok5_toonburger
```

2. Install dependency PHP

```bash
composer install
```

3. Install dependency frontend

```bash
npm install
```

4. Salin file environment

```bash
# Windows (CMD / PowerShell)
copy .env.example .env

# Linux / macOS
cp .env.example .env
```

5. Generate application key

```bash
php artisan key:generate
```

6. Konfigurasi database di file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kelompok5_toonburger
DB_USERNAME=root
DB_PASSWORD=
```

Atau jika menggunakan SQLite, ubah `DB_CONNECTION=sqlite` dan sesuaikan konfigurasi database sesuai kebutuhan.

7. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

8. Jalankan aplikasi

Untuk mode development terintegrasi (menjalankan server Laravel pada port `8008`, queue listener, log Pail, dan Vite secara bersamaan):

```bash
composer run dev
```

Atau jalankan secara terpisah:

```bash
php artisan serve
npm run dev
```

## Akun Dummy (Seeder)

Setelah menjalankan `php artisan migrate --seed`, akun berikut tersedia untuk pengujian:

| Role | Username | Email | Password |
| --- | --- | --- | --- |
| Admin | `admin` | `Toonburger@gmail.com` | `Password123` |
| Customer | `customer` | `customer@toonburger.com` | `Password123` |

## Route Utama

- `/` : halaman utama
- `/menu` : katalog menu
- `/product/{id}` : detail produk
- `/about` : tentang Toon Burger
- `/contact` : kontak dan lokasi
- `/gofood` : redirect ke halaman GoFood Toon Burger
- `/whatsapp` : redirect ke WhatsApp Toon Burger
- `/cart` : keranjang belanja
- `/checkout` : halaman checkout
- `/my-orders` : daftar pesanan pelanggan
- `/login` : login user
- `/register` : registrasi user
- `/admin` : dashboard admin
- `/admin/orders` : manajemen pesanan
- `/admin/products` : manajemen produk
- `/admin/categories` : manajemen kategori
- `/admin/tables` : manajemen meja restoran
- `/admin/messages` : pesan pelanggan
- `/admin/profile` : profil admin

## Catatan Pengembangan

Project ini dikembangkan untuk kebutuhan operasional bisnis Toon Burger dengan fokus pada pengalaman pelanggan dan kemudahan pengelolaan oleh admin. Fitur dapat terus dikembangkan sesuai kebutuhan seperti integrasi pembayaran digital otomatis, notifikasi WhatsApp, dan dashboard analitik lanjutan.

# Toon Burger

Toon Burger adalah aplikasi website pemesanan burger berbasis Laravel yang dirancang untuk mempermudah proses pemesanan, checkout, dan manajemen operasional restoran. Project ini mencakup sisi pelanggan untuk browsing menu, menambahkan produk ke keranjang, menggunakan kupon promo, hingga melihat riwayat order, serta sisi admin untuk mengelola produk, kategori, pesanan, meja, dan promo.

## Tentang Project

Project ini dikembangkan dengan konsep delivery dan takeaway, sesuai dengan operasional Toon Burger yang fokus pada:

- Pemesanan online
- Pesanan takeaway dan delivery
- Manajemen menu dan kategori
- Panel admin untuk operasional kasir dan kitchen
- Sistem review pelanggan
- Integrasi redirect ke GoFood dan link outlet

## Fitur Utama

### Untuk Pelanggan

- Halaman utama dan katalog menu
- Pencarian produk berdasarkan nama
- Keranjang belanja dinamis
- Penerapan kupon promo
- Proses checkout dan pembuatan pesanan
- Detail pesanan dan status order
- Riwayat pesanan pelanggan
- Fitur review produk setelah pemesanan

### Untuk Admin / Staff

- Dashboard admin
- Manajemen produk
- Manajemen kategori
- Manajemen kupon dan promo
- Manajemen meja restoran
- Proses status pesanan
- Panel POS untuk transaksi langsung
- Manajemen profil admin

## Teknologi yang Digunakan

- PHP 8.2
- Laravel 12
- JavaScript
- Vite
- Tailwind CSS
- Composer
- MySQL / SQLite

## Struktur Project

```bash
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
├── vite.config.js
├── artisan
├── phpunit.xml
└── README.md
```

## Persyaratan Sistem

Sebelum menjalankan project, pastikan sistem Anda sudah memiliki:

- PHP >= 8.2
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
copy .env.example .env
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
DB_DATABASE=toon_burger
DB_USERNAME=root
DB_PASSWORD=
```

Atau jika menggunakan SQLite, sesuaikan konfigurasi database sesuai kebutuhan.

7. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

8. Jalankan aplikasi

```bash
php artisan serve
```

9. Jalankan frontend vite

```bash
npm run dev
```

Untuk mode development yang sudah terintegrasi, project juga menyediakan script:

```bash
composer run dev
```

## Route Utama

- `/` : halaman utama
- `/menu` : katalog menu
- `/about` : tentang Toon Burger
- `/contact` : kontak dan lokasi
- `/cart` : keranjang belanja
- `/checkout` : halaman checkout
- `/my-orders` : daftar pesanan pelanggan
- `/login` : login user
- `/register` : registrasi user
- `/admin` : dashboard admin
- `/admin/orders` : manajemen pesanan
- `/admin/products` : manajemen produk
- `/admin/categories` : manajemen kategori
- `/admin/coupons` : manajemen kupon
- `/pos` : POS kasir

## Catatan Pengembangan

Project ini masih dikembangkan untuk kebutuhan operasional bisnis Toon Burger, dengan fokus pada pengalaman pelanggan dan kemudahan proses admin. Fitur dapat terus dikembangkan sesuai kebutuhan seperti pembayaran digital, notifikasi WhatsApp, dashboard analitik, dan integrasi logistik.

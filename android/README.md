# Proyek Android WebView - Toon Burger APK

Proyek Android Studio ini dirancang untuk membungkus website **Toon Burger** menjadi aplikasi Android (.APK) native dengan fitur lengkap:
- Fullscreen WebView tanpa address bar browser
- Dukungan upload file & kamera (ganti foto avatar, bukti transfer, dsb)
- Swipe-to-refresh (tarik ke bawah untuk refresh)
- Loading progress bar bernuansa Toon Burger
- Dukungan link eksternal otomatis (WhatsApp, Telepon, Google Maps)
- Dukungan koneksi HTTP lokal (Cleartext traffic) untuk pengujian LAN/Wi-Fi

---

## Cara Build APK Menggunakan Android Studio

1. **Buka Android Studio**:
   - Pilih **File** > **Open...**
   - Arahkan ke folder `c:\laragon\www\kelompok5_toonburger\android`
2. **Sesuaikan URL Server**:
   - Buka file `app/src/main/res/values/strings.xml`
   - Pastikan nilai `default_web_url` mengarah ke IP Wi-Fi Anda atau domain server produksi:
     ```xml
     <string name="default_web_url">http://10.215.6.109:8000</string>
     ```
     *(Jika menggunakan emulator Android Studio bawaan, gunakan `http://10.0.2.2:8000`)*
3. **Build APK**:
   - Klik menu **Build** > **Build Bundle(s) / APK(s)** > **Build APK(s)**
   - Tunggu proses Gradle selesai (1-2 menit).
   - Klik **locate** pada notifikasi di pojok kanan bawah. File APK Anda akan berada di:
     `app/build/outputs/apk/debug/app-debug.apk`
4. **Kirim & Install di HP**:
   - Kirim file `app-debug.apk` ke HP Android Anda (lewat WhatsApp/Google Drive/Kabel Data) lalu klik **Install**.

---

## Alternatif: Build APK Instan Secara Online (Tanpa Install Android Studio)

Jika laptop/PC belum terpasang Android Studio:

### 1. Metode WebIntoApp (Paling Mudah)
1. Buka [https://www.webintoapp.com](https://www.webintoapp.com)
2. Masukkan URL aplikasi Anda (atau IP server).
3. Beri nama aplikasi: **Toon Burger**.
4. Upload icon dari `public/images/icon-512.png`.
5. Klik **Make App** dan download file `.apk` secara instan!

### 2. Metode PWABuilder (Resmi Microsoft)
Karena website Toon Burger kini sudah dilengkapi `manifest.json` dan `sw.js` (PWA):
1. Buka [https://www.pwabuilder.com](https://www.pwabuilder.com)
2. Masukkan URL publik website Toon Burger.
3. Klik **Build My PWA** > pilih **Android** > unduh package APK / AAB.


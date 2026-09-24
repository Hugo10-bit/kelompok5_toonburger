@extends('layouts.app')

@section('title', 'Tentang Kami - Toon Burger Indonesia')

@section('content')
<div class="space-y-16 lg:space-y-20 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO HEADER (ABOUT US)
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden pt-4 sm:pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#263A38] via-[#334E4C] to-[#1E2D2B] rounded-[32px] sm:rounded-[40px] overflow-hidden shadow-2xl p-8 sm:p-14 text-white">
                
                <!-- Ambient Deco -->
                <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-64 h-64 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl space-y-4 text-left">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold text-amber-300 border border-white/15 shadow-xs">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>CERITA & DEDIKASI KAMI</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1] text-white">
                        Kisah & Cinta di Balik 
                        <span class="text-amber-300">Toon Burger</span>
                    </h1>

                    <p class="text-sm sm:text-base text-gray-200 leading-relaxed font-normal">
                        Kami memadukan keceriaan estetika kartun retro dengan kelezatan burger daging sapi panggang berkualitas tinggi. Setiap gigitan adalah petualangan rasa yang penuh senyuman!
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. ORIGIN STORY & MASCOT PHILOSOPHY
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-xs p-6 sm:p-12 lg:p-14 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Mascot & Visual Box -->
                <div class="lg:col-span-5 flex flex-col items-center text-center p-8 rounded-3xl bg-[#FAF1E1]/80 border border-[#EFE5D0] relative">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger Mascot" class="h-48 sm:h-56 w-auto object-contain drop-shadow-md mb-4">
                    <div class="inline-block bg-bites-red text-white text-[11px] font-black uppercase px-3.5 py-1 rounded-full shadow-xs mb-2">
                        Est. 2024 • Banjarbaru
                    </div>
                    <h3 class="text-lg font-black text-gray-900">The Original Cartoon Burgers</h3>
                    <p class="text-xs text-gray-600 mt-1 max-w-xs">
                        "Cita rasa autentik, porsi berani, dan kebahagiaan di setiap gigitan."
                    </p>
                </div>

                <!-- Story Text -->
                <div class="lg:col-span-7 space-y-5">
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                        Dari Dapur Impian Hingga Menjadi Burger Terfavorit
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Toon Burger lahir dari mimpi sederhana: menciptakan burger yang tidak hanya mengenyangkan perut, tetapi juga menghadirkan kebahagiaan sejati seperti saat menonton kartun favorit di masa kecil.
                    </p>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Banyak burger modern kehilangan jati dirinya—daging yang kering, roti yang terlalu manis, atau saus buatan pabrik yang serba instan. Di Toon Burger, kami memilih jalur yang berbeda: kami menggunakan <strong>100% daging sapi Australia pilihan</strong> tanpa campuran tepung, memanggang roti brioche mentega lembut setiap pagi, dan meracik saus legendaris kami dari nol.
                    </p>

                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-950 font-medium leading-relaxed">
                        <strong>Filosofi Kami:</strong> Toon Burger beroperasi dengan konsep <em>Cloud Kitchen &amp; Quick Takeaway Hub</em>. Kami fokus menyajikan pesanan bungkus bawa pulang dan pesan antar secepat kilat dengan kemasan insulated thermal yang menjaga burger tetap panas dan fresh sampai ke tangan Anda.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         3. OUR 4 KITCHEN COMMITMENTS
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                4 Komitmen Mutu Toon Burger
            </h2>
            <p class="text-xs sm:text-sm text-gray-600">
                Prinsip ketat yang kami jalankan setiap hari demi kepuasan Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Daging Murni 100%</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Hanya potongan daging sapi Australia murni. Tanpa pengawet kimiawi dan tanpa pengisi tepung.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-4.97 0-9 3.134-9 7 0 1.5.62 2.89 1.68 4h14.64c1.06-1.11 1.68-2.5 1.68-4 0-3.866-4.03-7-9-7zM4 17h16a2 2 0 012 2v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-1a2 2 0 012-2z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Roti Panggang Segar</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Dipanggang langsung setiap fajar dengan resep artisanal brioche butter yang empuk dan harum mentega.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">100% Halal & Higienis</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Seluruh bahan baku bersertifikasi halal dengan pengawasan standar sanitasi dapur bertaraf internasional.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Fresh Made to Order</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Tidak ada burger yang disimpan di pemanas lampu. Burger Anda baru dimasak begitu tiket pesanan masuk.
                </p>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         4. STATS & ACHIEVEMENTS
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-gray-900 via-[#1E2D2B] to-gray-900 text-white rounded-[32px] sm:rounded-[40px] p-8 sm:p-12 shadow-xl">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center divide-y lg:divide-y-0 lg:divide-x divide-white/10">
                
                <div class="p-4">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400 font-mono">50.000+</div>
                    <div class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Porsi Burger Terjual</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Khusus Takeaway &amp; Online Delivery</div>
                </div>

                <div class="p-4">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400 font-mono">4.9 / 5.0</div>
                    <div class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Tingkat Kepuasan</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Dari 1.200+ ulasan terverifikasi</div>
                </div>

                <div class="p-4">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400 font-mono">100%</div>
                    <div class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Daging Sapi Halal</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Impor Australia Bersertifikat</div>
                </div>

                <div class="p-4">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400 font-mono">15 Mnt</div>
                    <div class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Waktu Saji Rata-rata</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Cepat, panas, dan renyah</div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         5. BOTTOM CTA BANNER
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-xs p-8 sm:p-12 text-center space-y-6">
            <div class="max-w-xl mx-auto space-y-2">
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Jangan Lewatkan Gigitan Pertama Anda Hari Ini!
                </h2>
                <p class="text-xs sm:text-sm text-gray-600">
                    Pesan langsung secara online, bawa pulang ke rumah, atau kunjungi outlet restoran kami bersama keluarga.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('menu') }}" class="bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark text-xs sm:text-sm font-black px-7 py-3.5 rounded-2xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10a8 8 0 0116 0v1H4v-1zm0 4h16m-16 3h16a2 2 0 012 2H2a2 2 0 012-2z"/></svg>
                    <span>Lihat Menu & Pesan Sekarang</span>
                </a>
                <a href="{{ route('contact') }}" class="bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-extrabold px-6 py-3.5 rounded-2xl transition shadow-sm active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Lokasi & Hubungi Kami</span>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection

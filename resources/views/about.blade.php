@extends('layouts.app')

@section('title', 'Tentang Kami - Toon Burger Indonesia')

@section('content')
<div class="space-y-16 lg:space-y-20 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO HEADER (ABOUT US) — Full Size Edge-to-Edge
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden -mt-[80px]">
        <div class="w-full">
            <div class="relative overflow-hidden w-full pt-24 sm:pt-28 lg:pt-32 pb-14 sm:pb-18"
                 style="background-color: #3b6e64; min-height: 520px;">

                <!-- Partikel Bintang Komik Asli -->
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-6 h-auto"
                     style="top: 25%; left: 8%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 h-auto"
                     style="bottom: 25%; left: 45%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 h-auto"
                     style="top: 22%; right: 14%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-4 h-auto"
                     style="bottom: 20%; right: 28%;">

                <!-- Content Grid (Max-W-7xl for neat alignment) -->
                <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex flex-col lg:flex-row items-center justify-between gap-8 pt-4">
                    <div class="max-w-2xl space-y-4 text-left">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.08] text-white"
                            style="font-family: 'Nunito', 'Arial Black', sans-serif;">
                            Kisah &amp; Cinta di Balik <br>
                            <span class="text-yellow-300">Toon Burger</span>
                        </h1>

                        <p class="text-sm sm:text-base text-white/80 leading-relaxed font-normal max-w-xl">
                            Kami memadukan keceriaan estetika kartun retro dengan kelezatan burger daging sapi panggang berkualitas tinggi. Setiap gigitan adalah petualangan rasa yang penuh senyuman!
                        </p>
                    </div>

                    <!-- Right Mascot / Visual -->
                    <div class="relative flex justify-center items-center shrink-0">
                        <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger Mascot"
                             class="h-44 sm:h-56 lg:h-64 w-auto object-contain drop-shadow-2xl hover:scale-105 transition duration-500">
                    </div>
                </div>

                <!-- Checkered Bottom Border -->
                <div class="absolute bottom-0 left-0 w-full" style="height: 24px; background: repeating-conic-gradient(#1a3d36 0% 25%, #f0ede6 0% 50%) 0 0 / 24px 24px;"></div>

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
                        Banyak burger modern kehilangan jati dirinya, seperti daging yang kering, roti yang terlalu manis, atau saus buatan pabrik yang serba instan. Di Toon Burger, kami memilih jalur yang berbeda: kami menggunakan <strong>100% daging sapi lokal pilihan</strong> tanpa campuran tepung, memanggang roti brioche mentega lembut setiap pagi, dan meracik saus legendaris kami dari nol.
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
                    Hanya potongan daging sapi lokal pilihan. Tanpa pengawet kimiawi dan tanpa pengisi tepung.
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
</div>
@endsection

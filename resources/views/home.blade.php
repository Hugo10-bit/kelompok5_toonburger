@extends('layouts.app')

@section('title', 'Toon Burger - Crave the Ultimate Cartoon Burger Experience')

@section('content')
<div class="space-y-16 lg:space-y-24 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO SECTION
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden -mt-[105px] sm:-mt-[112px]">
        <div class="w-full">

            <!-- Hero Card — Dark Teal Comic Style Full Width & Full Size (Extending behind navbar, zero top gap) -->
            <div class="relative overflow-hidden w-full pt-32 sm:pt-36 lg:pt-40"
                 style="background-color: #3b6e64; min-height: 580px;">

                <!-- Partikel Bintang Komik Asli (Sesuai Asset Upload Pengguna: star-sparkle.png) -->
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-6 sm:w-7 h-auto"
                     style="top: 20%; left: 44%;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 22%; left: 42%;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 22%; right: 21%;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 18%; right: 33%;">

                <!-- Content Grid (Max-W-7xl for neat alignment) -->
                <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-10 lg:px-12 pt-4 sm:pt-6 pb-0">

                    <!-- Left: Headline + CTA -->
                    <div class="lg:col-span-5 space-y-5 pb-8 lg:pb-12">

                        <h1 class="text-white uppercase leading-[0.92]"
                            style="font-family: 'Nunito', 'Arial Black', sans-serif; font-weight: 900; font-size: clamp(2.8rem, 5.8vw, 4.8rem); letter-spacing: -0.01em;">
                            Setiap Gigitan<br>Punya Cerita!
                        </h1>

                        <p class="text-sm sm:text-base text-white/80 leading-relaxed max-w-sm">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap items-center gap-3.5 pt-2">
                            <a href="{{ route('menu') }}"
                               class="font-black text-sm sm:text-base px-7 py-3 rounded-xl transition hover:brightness-110 active:scale-95 shadow-md flex items-center justify-center"
                               style="background-color: #f5c518; color: #111111; font-family: 'Nunito', sans-serif;">
                                Pickup Order
                            </a>
                            <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer"
                               class="font-black text-sm sm:text-base px-7 py-3 rounded-xl border-2 border-white/80 text-white bg-transparent hover:bg-white hover:text-gray-900 transition active:scale-95 flex items-center justify-center"
                               style="font-family: 'Nunito', sans-serif;">
                                Delivery Order
                            </a>
                        </div>

                    </div>

                    <!-- Center: Burger in Center Column -->
                    <div class="lg:col-span-4 relative flex justify-center items-end self-end pb-4 lg:pb-6 pt-4 sm:pt-6">
                        <img src="{{ asset('images/hero-burger.png') }}"
                             alt="Toon Burger Very Cheese"
                             class="relative z-10 w-[270px] sm:w-[320px] lg:w-[360px] xl:w-[380px] h-auto object-contain hover:scale-105 transition-transform duration-500 drop-shadow-[0_18px_36px_rgba(0,0,0,0.4)]">
                    </div>

                    <!-- Right: Starburst Badge Image Asset (Posisi Awal di Kanan) -->
                    <div class="lg:col-span-3 relative flex justify-center lg:justify-end items-center pb-8 lg:pb-12">
                        <img src="{{ asset('images/very-cheese-badge.png') }}"
                             alt="Very Cheese Burger"
                             class="w-44 sm:w-52 lg:w-56 xl:w-60 h-auto object-contain hover:scale-105 transition-transform duration-300 drop-shadow-md">
                    </div>

                </div>

                <!-- Checkered Bottom Border — kotak hitam-putih asli -->
                <div class="w-full" style="height: 24px; background: repeating-conic-gradient(#1a3d36 0% 25%, #f0ede6 0% 50%) 0 0 / 24px 24px;"></div>

            </div>

        </div>
    </section>


    <!-- ═══════════════════════════════════════════════
         2. BESTSELLER PREVIEW CARDS
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight uppercase" style="font-family: 'Nunito', 'Arial Black', sans-serif; color: #3b6e64;">
                    BEST SELLER
                </h2>
                <p class="text-xs sm:text-sm text-gray-700 mt-2 max-w-md leading-relaxed">Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.</p>
            </div>

            <a href="{{ route('menu') }}" class="inline-flex items-center border border-[#3b6e64] text-[#3b6e64] hover:bg-[#3b6e64] hover:text-white text-xs font-bold px-5 py-2.5 rounded-lg transition shrink-0 mt-1">
                Lihat Semua
            </a>
        </div>

        <!-- Bestseller Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @forelse($featuredProducts as $product)
                <div class="group cursor-pointer" onclick="@if($product->options->isNotEmpty()) openProductModal({{ $product->id }}) @else quickAddToCart({{ $product->id }}) @endif">
                    <div class="relative bg-[#4A7C72] rounded-2xl sm:rounded-3xl overflow-hidden aspect-[3/4] shadow-xs group-hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
                        <img src="{{ asset($product->image ?: 'images/burger-bg.jpg') }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-white rounded-3xl p-8 text-center border border-[#E6DEC8] text-gray-600 text-xs">
                    Belum ada menu yang ditampilkan.
                </div>
            @endforelse
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         3. PRODUCT VALUE PROPOSITION
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                Kelezatan Otentik di Setiap Gigitan
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                Kami meracik setiap burger dengan standar kualitas premium tanpa kompromi untuk memberi Anda pengalaman kuliner terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Feature 1 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 group-hover:bg-amber-500 text-amber-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">100% Daging Sapi Lokal</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Daging sapi impor murni tanpa campuran tepung, di-smash dengan panas tinggi agar tercipta kerak gurih karamel dan bagian dalam yang super juicy.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 group-hover:bg-orange-500 text-orange-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-4.97 0-9 3.134-9 7 0 1.5.62 2.89 1.68 4h14.64c1.06-1.11 1.68-2.5 1.68-4 0-3.866-4.03-7-9-7zM4 17h16a2 2 0 012 2v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-1a2 2 0 012-2z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Roti Brioche Segar</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Roti brioche mentega lembut yang dipanggang segar setiap pagi langsung di dapur kami. Empuk, harum, dan tahan menyerap saus lezat.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group sm:col-span-2 sm:w-1/2 sm:justify-self-center lg:col-span-1 lg:w-auto">
                <div class="w-14 h-14 rounded-2xl bg-red-50 group-hover:bg-red-500 text-red-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Saus Rahasia Toon</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Saus racikan rahasia khas Toon Burger yang menyeimbangkan rasa gurih, creamy, manis, dan sedikit asam segar yang menyatukan semua rasa.
                </p>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         4. ABOUT US TEASER
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-xs p-6 sm:p-12 lg:p-14 overflow-hidden relative">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">

                <!-- Left Column: Visual Story & Mascot -->
                <div class="lg:col-span-5 flex flex-col items-center text-center p-6 sm:p-8 rounded-3xl bg-[#FAF1E1]/70 border border-[#EFE5D0] relative">
                    <div class="relative mb-5">
                        <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger Story" class="h-44 sm:h-52 w-auto object-contain drop-shadow-md">
                        <span class="absolute -bottom-2 right-2 bg-bites-red text-white text-[10px] font-black uppercase px-3 py-1 rounded-full shadow-xs">
                            Est. 2024
                        </span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 leading-tight">The Original Cartoon Burgers</h3>
                    <p class="text-xs text-gray-600 mt-2 max-w-xs leading-relaxed">
                        "Kami percaya makanan lezat harus dinikmati dengan senyuman dan keceriaan."
                    </p>
                </div>

                <!-- Right Column: Narrative Story -->
                <div class="lg:col-span-7 space-y-5">
                    <h2 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                        Kenal Lebih Dekat Toon Burger
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, <strong>Toon Burger</strong> hadir membawa nuansa karakter kartun retro yang enerjik, ceria, dan bersahabat bagi siapa saja.
                    </p>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Setiap patty daging sapi digiling dari potongan daging segar berkualitas pilihan, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.
                    </p>

                    <div class="pt-2">
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-extrabold px-6 py-3 rounded-2xl transition shadow-md active:scale-95">
                            <span>Tentang Kami</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         5. QUALITY STANDARDS & TAKEAWAY EXCELLENCE
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                Standar Mutu &amp; Layanan Takeaway Kami
            </h2>
            <p class="text-xs sm:text-sm text-gray-600">
                Tiga pilar utama yang menjaga rasa dan kualitas Toon Burger tetap prima di setiap pesanan Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Pillar 1 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 group-hover:bg-amber-500 text-amber-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">100% Local Beef Smash</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Patty daging murni impor tanpa campuran tepung atau filler. Di-smash panas dengan teknik khusus untuk mengunci sari kaldu alami daging agar bagian luar renyah gurih dan bagian dalam tetap lembut juicy.
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 flex items-center gap-2 text-[11px] font-bold text-amber-800">
                    <span>✓ Bersertifikat Halal &amp; Higienis</span>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 group-hover:bg-orange-500 text-orange-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 3c-4.97 0-9 3.134-9 7 0 1.5.62 2.89 1.68 4h14.64c1.06-1.11 1.68-2.5 1.68-4 0-3.866-4.03-7-9-7zM4 17h16a2 2 0 012 2v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-1a2 2 0 012-2z"/></svg>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">Artisanal Brioche Buns</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Roti brioche mentega yang dipanggang segar setiap sore langsung di dapur kami. Tekstur empuk harum yang mampu menyerap saus legendaris Toon Burger tanpa merusak kekokohan roti saat dinikmati.
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 flex items-center gap-2 text-[11px] font-bold text-orange-800">
                    <span>✓ Dibuat Segar Setiap Pagi</span>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 group-hover:bg-emerald-500 text-emerald-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">Dedicated Takeaway Thermal Pack</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Dirancang khusus untuk pesanan takeaway dan online delivery. Kemasan boks kokoh dengan ventilasi kelembapan menjaga burger dan kentang goreng tetap hangat, tidak lembek, dan siap santap di mana saja.
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 flex items-center gap-2 text-[11px] font-bold text-emerald-800">
                    <span>✓ Hangat &amp; Aman Dalam Pengantaran</span>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection

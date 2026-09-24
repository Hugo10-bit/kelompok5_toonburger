@extends('layouts.app')

@section('title', 'Toon Burger - Crave the Ultimate Cartoon Burger Experience')

@section('content')
<div class="space-y-16 lg:space-y-24 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO SECTION (BRAND & HIGHLIGHTS)
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden pt-4 sm:pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero Card Container with Rich Warm Gradient & Deco -->
            <div class="relative bg-gradient-to-br from-amber-500 via-bites-orange to-red-600 rounded-[32px] sm:rounded-[40px] overflow-hidden shadow-2xl p-6 sm:p-12 lg:p-14 text-white">
                
                <!-- Background Ambient Glow & Patterns -->
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-72 h-72 bg-yellow-300/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Hero Content -->
                    <div class="lg:col-span-7 space-y-5 text-left">
                        
                        <!-- Top Tag Badge -->
                        <div class="inline-flex items-center gap-2 bg-black/25 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold text-yellow-200 border border-white/15 shadow-xs">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>BURGER PREMIUM ASLI • 100% AUSTRALIAN BEEF</span>
                        </div>

                        <!-- Big Headline -->
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1] text-white">
                            Sensasi Gigitan Burger Asli yang 
                            <span class="text-yellow-300 underline decoration-wavy decoration-yellow-400/60 decoration-2">Bikin Nagih!</span>
                        </h1>

                        <!-- Pitch Subtitle -->
                        <p class="text-sm sm:text-base text-white/95 leading-relaxed max-w-xl font-medium">
                            Nikmati kelezatan patty daging sapi panggang juicy dengan keju cheddar meleleh, saus rahasia khas Toon Burger, dan roti brioche harum mentega yang dipanggang segar setiap pagi!
                        </p>

                        <!-- Action CTA Buttons -->
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="{{ route('menu') }}" class="bg-gray-900 hover:bg-black text-white font-extrabold text-xs sm:text-sm px-6 py-3.5 rounded-2xl transition shadow-lg hover:shadow-xl hover:scale-102 active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 10a8 8 0 0116 0v1H4v-1zm0 4h16m-16 3h16a2 2 0 012 2H2a2 2 0 012-2z"/></svg>
                                <span>Jelajahi Menu</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer" class="bg-[#EE2737] hover:bg-[#D61B2B] text-white font-extrabold text-xs sm:text-sm px-5 py-3.5 rounded-2xl transition shadow-lg hover:shadow-xl hover:scale-102 active:scale-95 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                <span>Pesan via GoFood</span>
                                <span class="bg-white/20 text-[10px] px-1.5 py-0.5 rounded-full font-bold">4.9 ★</span>
                            </a>
                            <a href="{{ route('contact') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-bold text-xs sm:text-sm px-4 py-3.5 rounded-2xl transition border border-white/30 hover:scale-102 active:scale-95">
                                Lokasi Outlet &rarr;
                            </a>
                        </div>

                        <!-- Trust Features Row -->
                        <div class="pt-4 border-t border-white/20 grid grid-cols-3 gap-3 sm:gap-6 text-white/90">
                            <div>
                                <div class="text-lg sm:text-2xl font-black text-yellow-300 font-mono">4.9 / 5.0</div>
                                <div class="text-[11px] sm:text-xs text-white/80">1.200+ Ulasan Pelanggan</div>
                            </div>
                            <div>
                                <div class="text-lg sm:text-2xl font-black text-yellow-300">100% Halal</div>
                                <div class="text-[11px] sm:text-xs text-white/80">Bahan Segar Pilihan</div>
                            </div>
                            <div>
                                <div class="text-lg sm:text-2xl font-black text-yellow-300 font-mono">15 Menit</div>
                                <div class="text-[11px] sm:text-xs text-white/80">Fresh Made to Order</div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Hero Visual with Floating Stickers -->
                    <div class="lg:col-span-5 relative flex justify-center items-center">
                        <div class="relative w-full max-w-sm sm:max-w-md">
                            
                            <!-- Main Visual Burger Image -->
                            <img src="{{ asset('images/burger-bg.png') }}" 
                                 alt="Toon Burger Signature" 
                                 class="w-full h-auto object-contain drop-shadow-[0_20px_35px_rgba(0,0,0,0.45)] hover:scale-105 transition duration-500 relative z-10">

                            <!-- Floating Mascot Sticker -->
                            <div class="absolute -top-3 -left-3 sm:-left-6 bg-white/95 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 shadow-xl border border-white/60 flex items-center gap-2.5 z-20 hover:scale-105 transition">
                                <img src="{{ asset('images/toon-head.png') }}" alt="Mascot" class="w-9 h-9 sm:w-11 sm:h-11 object-contain">
                                <div>
                                    <div class="text-[10px] font-black uppercase text-amber-700">Toon Chef</div>
                                    <div class="text-xs font-extrabold text-gray-900">100% Juicy Smashed!</div>
                                </div>
                            </div>

                            <!-- Floating Voucher Badge -->
                            <div class="absolute -bottom-4 -right-2 sm:-right-4 bg-gray-950/90 backdrop-blur-md rounded-2xl p-3 shadow-xl border border-yellow-400/40 text-left z-20 hover:scale-105 transition">
                                <div class="text-[10px] font-bold text-yellow-300 uppercase tracking-wider">Kupon Spesial</div>
                                <div class="text-xs font-black text-white font-mono">TOONBURGER50</div>
                                <div class="text-[10px] text-gray-300">Diskon s.d 50% di keranjang</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. PRODUCT VALUE PROPOSITION
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Feature 1 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 group-hover:bg-amber-500 text-amber-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">100% Australian Beef</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Daging sapi impor murni tanpa campuran tepung, di-smash dengan panas tinggi agar tercipta kerak gurih karamel dan bagian dalam yang super juicy.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 group-hover:bg-orange-500 text-orange-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-4.97 0-9 3.134-9 7 0 1.5.62 2.89 1.68 4h14.64c1.06-1.11 1.68-2.5 1.68-4 0-3.866-4.03-7-9-7zM4 17h16a2 2 0 012 2v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-1a2 2 0 012-2z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Fresh Brioche Buns</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Roti brioche mentega lembut yang dipanggang segar setiap pagi langsung di dapur kami. Empuk, harum, dan tahan menyerap saus lezat.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-red-50 group-hover:bg-red-500 text-red-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Secret Toon Sauce</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Saus racikan rahasia khas Toon Burger yang menyeimbangkan rasa gurih, creamy, manis, dan sedikit asam segar yang menyatukan semua rasa.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 space-y-3 group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 group-hover:bg-emerald-500 text-emerald-700 group-hover:text-white flex items-center justify-center transition duration-300 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                </div>
                <h3 class="font-extrabold text-base text-gray-900">Made to Order</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Pesanan baru dimasak saat tiket masuk ke dapur. Selalu disajikan dalam kondisi panas, renyah, dan keju yang meleleh sempurna.
                </p>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         3. BESTSELLER PREVIEW CARDS
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-2 border-b border-gray-200">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Menu Bestseller & Paling Digemari
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">Cobain rekomendasi menu favorit para penikmat Toon Burger minggu ini.</p>
            </div>

            <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark text-xs font-extrabold px-5 py-2.5 rounded-2xl transition shadow-xs hover:shadow-md active:scale-95 shrink-0 self-start sm:self-auto">
                <span>Lihat Semua Menu (Katalog Lengkap)</span>
                <span>&rarr;</span>
            </a>
        </div>

        <!-- Bestseller Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-3xl border border-[#E6DEC8] hover:border-bites-orange/60 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group hover:-translate-y-1">
                    
                    <!-- Product Image & Badges -->
                    <div class="relative bg-gray-100 aspect-[4/3] overflow-hidden">
                        <img src="{{ asset($product->image ?: 'images/burger-bg.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-108 transition duration-500">
                        
                        <span class="absolute top-3 left-3 bg-bites-red text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            ★ Bestseller
                        </span>

                        @if($product->original_price && $product->original_price > $product->price)
                            @php
                                $disc = round((($product->original_price - $product->price) / $product->original_price) * 100);
                            @endphp
                            <span class="absolute top-3 right-3 bg-yellow-400 text-yellow-950 text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">
                                -{{ $disc }}%
                            </span>
                        @endif

                        <div class="absolute bottom-2 left-3 right-3 flex items-center justify-between text-[11px] font-semibold text-white">
                            <span class="bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded-md font-mono">
                                {{ $product->calories ?: 450 }} kcal
                            </span>
                            <span class="bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded-md font-mono">
                                {{ $product->prep_time_minutes ?: 8 }} menit
                            </span>
                        </div>
                    </div>

                    <!-- Product Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                {{ $product->category->name }}
                            </span>
                            <h3 class="font-extrabold text-sm text-gray-900 group-hover:text-bites-red transition line-clamp-1 mt-0.5">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-gray-600 line-clamp-2 mt-1 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                        <!-- Price & Action -->
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                            <div>
                                <div class="text-base font-black text-gray-900 font-mono">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <div class="text-[11px] text-gray-500 line-through font-mono">
                                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>

                            @if($product->options->isNotEmpty())
                                <button onclick="openProductModal({{ $product->id }})" class="bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-extrabold text-xs px-3.5 py-2 rounded-xl transition shadow-xs flex items-center gap-1 active:scale-95">
                                    <span>Pilih Varian</span>
                                </button>
                            @else
                                <button onclick="quickAddToCart({{ $product->id }})" class="bg-gray-900 hover:bg-bites-red text-white font-extrabold text-xs px-3.5 py-2 rounded-xl transition shadow-xs active:scale-95 flex items-center gap-1">
                                    <span>+ Tambah</span>
                                </button>
                            @endif
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-span-4 bg-white rounded-3xl p-8 text-center border border-[#E6DEC8] text-gray-600 text-xs">
                    Belum ada menu yang ditampilkan.
                </div>
            @endforelse
        </div>

        <!-- Full Menu CTA Banner (Polished: text-amber-950 on bg-amber-400, no gray-on-color) -->
        <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-950 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-400 text-amber-950 flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 10a8 8 0 0116 0v1H4v-1zm0 4h16m-16 3h16a2 2 0 012 2H2a2 2 0 012-2z"/></svg>
                </div>
                <div>
                    <h4 class="text-base sm:text-lg font-black text-white leading-tight">Penasaran dengan 20+ Varian Menu Lainnya?</h4>
                    <p class="text-xs text-gray-300 mt-0.5">Mulai dari burger ayam krispi, loaded cheese fries, saus truffle, hingga milkshake segar.</p>
                </div>
            </div>
            <a href="{{ route('menu') }}" class="bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark text-xs sm:text-sm font-black px-6 py-3 rounded-2xl transition shadow-md active:scale-95 whitespace-nowrap">
                Buka Halaman Menu &rarr;
            </a>
        </div>

        <!-- GoFood Official Super Partner Promo Banner -->
        <div class="mt-4 bg-gradient-to-r from-[#EE2737] to-[#B31217] text-white rounded-3xl p-6 sm:p-7 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#EE2737] flex items-center justify-center shrink-0 shadow-md font-black text-sm">
                    4.9 ★
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 bg-black/20 text-yellow-300 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider mb-1">
                        <span>Official Super Partner di GoFood</span>
                    </div>
                    <h4 class="text-base sm:text-lg font-black text-white leading-tight">Mau Pesanan Diantar Langsung Driver Gojek?</h4>
                    <p class="text-xs text-red-100 mt-0.5">Pesan praktis lewat GoFood untuk menikmati promo diskon menu &amp; voucher gratis ongkir hari ini!</p>
                </div>
            </div>
            <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer" class="bg-white hover:bg-gray-100 text-[#EE2737] text-xs sm:text-sm font-black px-6 py-3 rounded-2xl transition shadow-md active:scale-95 whitespace-nowrap flex items-center gap-2">
                <span>Buka di Aplikasi GoFood</span>
                <span>&rarr;</span>
            </a>
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
                        Kisah di Balik Cita Rasa Toon Burger
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, <strong>Toon Burger</strong> lahir membawa nuansa karakter kartun retro yang enerjik, ceria, dan bersahabat bagi siapa saja.
                    </p>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Kami tidak percaya pada jalan pintas. Setiap patty daging sapi digiling dari potongan daging berkualitas, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.
                    </p>

                    <div class="pt-2">
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-extrabold px-6 py-3 rounded-2xl transition shadow-md active:scale-95">
                            <span>Baca Kisah Lengkap Kami &rarr;</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         5. TESTIMONIALS SECTION ("KATA PELANGGAN")
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                Apa Kata Mereka Tentang Toon Burger?
            </h2>
            <p class="text-xs sm:text-sm text-gray-600">
                Ulasan nyata dari para penikmat burger setia kami.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Testimonial 1 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex text-amber-500 text-sm tracking-wider">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        "Truffle Mushroom Burger-nya juara banget! Dagingnya bener-bener juicy, saus truffle-nya wangi dan gak bikin enek. Brioche bun-nya juga empuk parah!"
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-amber-500 text-white font-extrabold text-xs flex items-center justify-center">
                        HP
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-gray-900">Hugo Putra</div>
                        <div class="text-[10px] text-gray-500">Food Enthusiast • Banjarbaru</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex text-amber-500 text-sm tracking-wider">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        "Pelayanan takeaway-nya super cepat dan kemasan burgernya kokoh banget! Pesan bungkus bawa pulang atau delivery selalu hangat dan rotinya tetap lembut empuk."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-red-500 text-white font-extrabold text-xs flex items-center justify-center">
                        BS
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-gray-900">Budi Santoso</div>
                        <div class="text-[10px] text-gray-500">Pelanggan Takeaway &amp; Delivery</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex text-amber-500 text-sm tracking-wider">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        "Langganan takeaway pas jam makan siang kantor. Sampai di kantor burger dan kentangnya masih hangat garing, packaging-nya juga super rapi!"
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center">
                        SW
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-gray-900">Sarah Wijaya</div>
                        <div class="text-[10px] text-gray-500">Pekerja Kantoran</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         6. CONTACT TEASER SECTION (LIVE LOCATION)
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-xs p-6 sm:p-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500"></span>
                    </span>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Outlet Aktif • Loktabat Utara</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-900 mt-0.5">Toon Burger, Banjarbaru Utara Jln Berlian</h3>
                    <p class="text-xs text-gray-600 mt-1 max-w-lg">Jl. Berlian, Loktabat Utara, Banjarbaru Utara (HR7F+P8M). Buka Selasa – Minggu 17:00 – 22:00 WITA (Sabtu s/d 22:30, Senin Libur). Khusus Takeaway &amp; Online Delivery.</p>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-extrabold px-6 py-3.5 rounded-2xl transition shadow-md active:scale-95 whitespace-nowrap flex items-center gap-2">
                <span>Buka Peta & Live Location</span>
                <span>&rarr;</span>
            </a>
        </div>
    </section>

</div>
@endsection

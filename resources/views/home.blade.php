@extends('layouts.app')

@section('title', 'Toon Burger - Setiap Gigitan Punya Cerita!')

@section('content')
<div class="space-y-0 pb-0">

    <!-- ═══════════════════════════════════════════════
         1. HERO SECTION (Sesuai Foto 5)
         ═══════════════════════════════════════════════ -->
    @include('partials.hero-banner', [
        'headline' => 'SETIAP GIGITAN<br>PUNYA CERITA!',
        'headlineDesktopClass' => 'lg:text-[56px] xl:text-[64px]',
        'ctaHref' => route('menu'),
        'deliveryHref' => route('gofood'),
        'revealClass' => 'toon-reveal-left',
    ])

    <!-- Section: Kenapa Toon Burger (Matching Figma exactly with enlarged spacious cards) -->
    <section class="relative w-full pt-10 pb-12 sm:pt-24 sm:pb-28 lg:pt-28 lg:pb-32 px-4 sm:px-6 lg:px-8 overflow-hidden select-none"
             style="background-color: #FAF5E9; background-image: url('{{ asset('images/why-us-bg-body.png') }}'); background-repeat: no-repeat; background-position: center bottom; background-size: cover;">

        @if(isset($storeSetting) && $storeSetting->isClosed())
            <div class="max-w-5xl mx-auto relative z-20 mb-6 sm:mb-10">
                @include('partials.store-closed-banner')
            </div>
        @endif

        <div class="max-w-3xl mx-auto relative z-20 text-center space-y-2 mb-7 sm:mb-14 toon-reveal-up">
            <h2 class="text-xl sm:text-3xl lg:text-[38px] text-[#243F3B] uppercase tracking-wide"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                KENAPA TOON BURGER?
            </h2>

            <p class="text-[11.5px] sm:text-sm text-gray-500 max-w-xl mx-auto leading-relaxed">
                Nikmati sensasi kelezatan burger terbaik dengan daging pilihan dan bahan segar yang siap memuaskan rasa lapar Anda kapan saja.
            </p>
        </div>

        <div class="max-w-[1440px] mx-auto grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 relative z-20">

            <!-- Card 1: 100% Daging -->
            <div class="bg-white rounded-[18px] sm:rounded-[30px] border-2 border-black shadow-[3px_4px_0px_rgba(0,0,0,0.45)] sm:shadow-[6px_7px_0px_rgba(0,0,0,0.5)] p-3.5 sm:p-6 min-h-0 sm:min-h-[215px] text-left flex flex-col justify-start relative overflow-hidden transition-[transform,box-shadow] duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] hover:-translate-y-1.5 hover:shadow-[8px_9px_0px_rgba(39,68,62,0.85)] toon-reveal-pop reveal-delay-75">
                <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl border-2 border-[#F5C2C2] bg-[#FDF2F2] flex items-center justify-center text-[#E03A3A] mb-2 sm:mb-3 shrink-0 shadow-[2px_2px_0px_#F5C2C2]">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-xs sm:text-[17px] text-gray-900 leading-snug">
                    Terbuat dari 100% Daging
                </h3>
                <p class="text-[11px] sm:text-[13px] text-gray-500 leading-snug sm:leading-relaxed pt-1.5 sm:pt-2 relative z-10">
                    Nikmati patty berkualitas yang dibuat dari 100% daging pilihan.
                </p>
                <svg class="hidden sm:block absolute -bottom-3 -right-3 w-20 h-20 text-gray-900 opacity-[0.05] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                </svg>
            </div>

            <!-- Card 2: Bahan Segar Setiap Hari -->
            <div class="bg-white rounded-[18px] sm:rounded-[30px] border-2 border-black shadow-[3px_4px_0px_rgba(0,0,0,0.45)] sm:shadow-[6px_7px_0px_rgba(0,0,0,0.5)] p-3.5 sm:p-6 min-h-0 sm:min-h-[215px] text-left flex flex-col justify-start relative overflow-hidden transition-[transform,box-shadow] duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] hover:-translate-y-1.5 hover:shadow-[8px_9px_0px_rgba(39,68,62,0.85)] toon-reveal-pop reveal-delay-150">
                <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl border-2 border-[#BDE0D8] bg-[#F0F7F5] flex items-center justify-center text-[#2E7A6B] mb-2 sm:mb-3 shrink-0 shadow-[2px_2px_0px_#BDE0D8]">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-xs sm:text-[17px] text-gray-900 leading-snug">
                    Bahan Segar Setiap Hari
                </h3>
                <p class="text-[11px] sm:text-[13px] text-gray-500 leading-snug sm:leading-relaxed pt-1.5 sm:pt-2 relative z-10">
                    Selalu fresh setiap hari, karena rasa terbaik dimulai dari bahan berkualitas.
                </p>
                <svg class="hidden sm:block absolute -bottom-3 -right-3 w-20 h-20 text-gray-900 opacity-[0.05] pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                    <circle cx="12" cy="11" r="3"/>
                </svg>
            </div>

            <!-- Card 3: Pesanan Cepat -->
            <div class="bg-white rounded-[18px] sm:rounded-[30px] border-2 border-black shadow-[3px_4px_0px_rgba(0,0,0,0.45)] sm:shadow-[6px_7px_0px_rgba(0,0,0,0.5)] p-3.5 sm:p-6 min-h-0 sm:min-h-[215px] text-left flex flex-col justify-start relative overflow-hidden transition-[transform,box-shadow] duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] hover:-translate-y-1.5 hover:shadow-[8px_9px_0px_rgba(39,68,62,0.85)] toon-reveal-pop reveal-delay-225">
                <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl border-2 border-[#FDE68A] bg-[#FFFBEB] flex items-center justify-center text-[#D97706] mb-2 sm:mb-3 shrink-0 shadow-[2px_2px_0px_#FDE68A]">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-xs sm:text-[17px] text-gray-900 leading-snug">
                    Pesanan Cepat
                </h3>
                <p class="text-[11px] sm:text-[13px] text-gray-500 leading-snug sm:leading-relaxed pt-1.5 sm:pt-2 relative z-10">
                    Disiapkan dengan cepat tanpa mengorbankan kualitas dan cita rasa.
                </p>
                <svg class="hidden sm:block absolute -bottom-3 -right-3 w-20 h-20 text-gray-900 opacity-[0.05] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                </svg>
            </div>

            <!-- Card 4: Porsi Bikin Kenyang -->
            <div class="bg-white rounded-[18px] sm:rounded-[30px] border-2 border-black shadow-[3px_4px_0px_rgba(0,0,0,0.45)] sm:shadow-[6px_7px_0px_rgba(0,0,0,0.5)] p-3.5 sm:p-6 min-h-0 sm:min-h-[215px] text-left flex flex-col justify-start relative overflow-hidden transition-[transform,box-shadow] duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] hover:-translate-y-1.5 hover:shadow-[8px_9px_0px_rgba(39,68,62,0.85)] toon-reveal-pop reveal-delay-300">
                <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl border-2 border-[#BFDBFE] bg-[#EFF6FF] flex items-center justify-center text-[#2563EB] mb-2 sm:mb-3 shrink-0 shadow-[2px_2px_0px_#BFDBFE]">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-xs sm:text-[17px] text-gray-900 leading-snug">
                    Porsi Bikin Kenyang
                </h3>
                <p class="text-[11px] sm:text-[13px] text-gray-500 leading-snug sm:leading-relaxed pt-1.5 sm:pt-2 relative z-10">
                    Porsi pas dan mengenyangkan, cocok untuk menemani rasa lapar kapan saja.
                </p>
                <svg class="hidden sm:block absolute -bottom-3 -right-3 w-20 h-20 text-gray-900 opacity-[0.05] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                </svg>
            </div>

        </div>

    </section>

    <!-- Yellow Ribbon with TOONBURGER ★ (Animated marquee on mobile, static on tablet/laptop) -->
    <div class="w-full bg-[#F5B027] py-3.5 overflow-hidden select-none toon-reveal">
        <div class="toonburger-ribbon-track whitespace-nowrap text-base sm:text-lg font-black text-[#1E2E2B] uppercase tracking-wider flex items-center"
             style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
            <div class="flex items-center shrink-0">
                @for($i = 0; $i < 12; $i++)
                    <span class="mx-3.5 flex items-center gap-3 shrink-0">TOONBURGER <span class="text-[#D93829] text-xl leading-none">★</span></span>
                @endfor
            </div>
            <div class="flex items-center shrink-0 md:hidden" aria-hidden="true">
                @for($i = 0; $i < 12; $i++)
                    <span class="mx-3.5 flex items-center gap-3 shrink-0">TOONBURGER <span class="text-[#D93829] text-xl leading-none">★</span></span>
                @endfor
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         4. BEST SELLER SECTION (Sesuai Foto 4)
         ═══════════════════════════════════════════════ -->
    <section class="retro-grid-bg pt-8 pb-10 sm:pt-16 sm:pb-16 px-3.5 sm:px-6 lg:px-8 select-none">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 sm:gap-4 toon-reveal-up">
                <div>
                    <h2 class="font-brand text-2xl sm:text-4xl lg:text-5xl text-[#27443e] uppercase tracking-wide"
                        style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                        BEST SELLER
                    </h2>
                    <p class="text-[11.5px] sm:text-sm text-gray-600 mt-1 max-w-lg">
                        Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                    </p>
                </div>

                <a href="{{ route('menu') }}"
                   class="min-h-[36px] sm:min-h-[44px] self-start sm:self-auto border-2 border-black bg-white rounded-xl px-3.5 py-1.5 sm:px-4 sm:py-2 font-medium text-xs sm:text-sm text-gray-900 shadow-[2px_2px_0px_#000] hover:bg-gray-50 transition cursor-pointer inline-flex items-center gap-1.5 shrink-0">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- 4 Product Cards Grid -->
            @php
                $bestSellers = [
                    ['id' => 1, 'image' => 'images/products/very-cheese-burger.png', 'badge' => 'CHEESE BURGER', 'name' => 'Very Cheese Burger', 'description' => 'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...', 'price' => 35000, 'revealClass' => 'toon-reveal-pop reveal-delay-75'],
                    ['id' => 6, 'image' => 'images/products/cheese-chicken-burger.png', 'badge' => 'CHICKEN BURGER', 'name' => 'Cheese Chicken Burger', 'description' => 'Dada ayam krispi juicy berpadu lelehan keju cheddar, selada segar, dan tomat...', 'price' => 35000, 'revealClass' => 'toon-reveal-pop reveal-delay-150'],
                    ['id' => 3, 'image' => 'images/products/bbq-beef-burger.png', 'badge' => 'BEEF BURGER', 'name' => 'BBQ Beef Burger', 'description' => 'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel...', 'price' => 37000, 'revealClass' => 'toon-reveal-pop reveal-delay-225'],
                    ['id' => 4, 'image' => 'images/products/double-cheese-burger.png', 'badge' => 'CHEESE BURGER', 'name' => 'Double Cheese Burger', 'description' => 'Dua patty daging sapi panggang juicy dengan limpahan keju cheddar ganda...', 'price' => 33000, 'revealClass' => 'toon-reveal-pop reveal-delay-300'],
                ];
            @endphp
            <div class="mt-5 sm:mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($bestSellers as $bs)
                    @include('partials.product-card', [
                        'productId' => $bs['id'],
                        'image' => $bs['image'],
                        'badge' => $bs['badge'],
                        'name' => $bs['name'],
                        'description' => $bs['description'],
                        'price' => $bs['price'],
                        'revealClass' => $bs['revealClass'],
                    ])
                @endforeach
            </div>

            <!-- ═══════════════════════════════════════════════
                 5. NGGAK SEMPAT KE TOKO? GOFOOD AJA! BANNER
                 ═══════════════════════════════════════════════ -->
            <div class="mt-8 sm:mt-16 bg-white rounded-[20px] sm:rounded-[28px] border-2 border-black shadow-[3px_4px_0px_rgba(168,50,50,0.45)] sm:shadow-[6px_6px_0px_rgba(168,50,50,0.5)] px-4 py-5 sm:px-8 sm:py-11 min-h-0 sm:min-h-[164px] flex flex-col sm:flex-row items-center justify-between gap-3.5 sm:gap-5 toon-reveal-up">
                <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-[#cc292b] text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" viewBox="0 0 24 24" fill="#FFFFFF" aria-hidden="true">
                            <path d="M5.2 2.5a.6.6 0 0 1 1.2 0V8.5H5.2V2.5zm2.4 0a.6.6 0 0 1 1.2 0V8.5H7.6V2.5zm2.4 0a.6.6 0 0 1 1.2 0V8.5H10V2.5zM5.2 8h6v1.2c0 1.8-1.6 3-2.1 3.4V21a.9.9 0 0 1-1.8 0v-8.4c-.5-.4-2.1-1.6-2.1-3.4V8z"/>
                            <path d="M15 2c2.8 0 4.5 2.2 4.5 6.5v5h-2V21a1 1 0 0 1-1 1h-.5a1 1 0 0 1-1-1V2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-hegarty font-normal text-sm sm:text-base md:text-lg text-gray-900 uppercase tracking-wide"
                            style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                            NGGAK SEMPAT KE TOKO? GOFOOD AJA!
                        </h3>
                        <p class="text-[11.5px] sm:text-sm text-gray-500 mt-0.5">
                            Burger favoritmu diantar langsung ke rumah, langsung dari aplikasi Gojek
                        </p>
                    </div>
                </div>

                <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer"
                   class="min-h-[40px] sm:min-h-[44px] w-full sm:w-auto justify-center bg-[#a62b2b] hover:bg-[#8e2424] text-white font-medium text-xs sm:text-sm px-5 sm:px-6 py-2 sm:py-2.5 rounded-xl transition shadow-xs flex items-center gap-2 shrink-0 cursor-pointer active:scale-95">
                    <span>Buka Gojek</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         6. MENGENAL TOON BURGER SECTION (Sesuai Foto 3)
         ═══════════════════════════════════════════════ -->
    <section class="w-full py-8 sm:py-16 px-3.5 sm:px-6 lg:px-8 select-none"
             style="background-color: #385850;">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[22px] sm:rounded-[32px] border-2 border-black shadow-[4px_5px_0px_#1e2f2b] sm:shadow-[8px_8px_0px_#1e2f2b] p-4 sm:p-10 lg:p-12 toon-reveal-up">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 sm:gap-8 lg:gap-12 items-center">

                    <!-- Left: Text -->
                    <div class="md:col-span-7 space-y-2.5 sm:space-y-4 toon-reveal-left">
                        <h2 class="font-brand text-xl sm:text-4xl lg:text-5xl text-[#27443e] uppercase leading-[1.08]"
                            style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                            MENGENAL TOON<br class="hidden sm:inline"> BURGER
                        </h2>

                        <p class="text-[11.5px] sm:text-sm text-gray-600 leading-relaxed pt-1 sm:pt-2">
                            Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, Toon Burger hadir membawa nuansa karakter kartun retro yang enerjik, ceria, dan bersahabat bagi siapa saja.
                        </p>

                        <p class="text-[11.5px] sm:text-sm text-gray-600 leading-relaxed">
                            Setiap patty daging sapi digiling dari potongan daging segar berkualitas pilihan, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.
                        </p>

                        <div class="pt-1.5 sm:pt-4">
                            <a href="{{ route('about') }}"
                               class="min-h-[38px] sm:min-h-[44px] bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs sm:text-sm font-medium px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl inline-flex items-center gap-2 shadow-[2px_2px_0px_#000] transition cursor-pointer">
                                <span>Selengkapnya Tentang Kami</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Outdoor Sign Photo with cartoon cat -->
                    <div class="md:col-span-5 flex justify-center md:justify-end toon-reveal-right reveal-delay-150">
                        <div class="w-full max-w-md rounded-xl sm:rounded-2xl overflow-hidden border-2 border-black shadow-[3px_3px_0px_#000] sm:shadow-[4px_4px_0px_#000] mx-auto md:ml-auto">
                            <img src="{{ asset('images/toonburger-outdoor-sign-hq.png') }}"
                                 alt="Toon Burger Sign"
                                 loading="lazy"
                                 decoding="async"
                                 width="600"
                                 height="420"
                                 class="w-full h-40 sm:h-64 lg:h-72 object-cover">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         7. ADA YANG MAU DITANYAIN? BANNER (Sesuai Foto 1)
         ═══════════════════════════════════════════════ -->
    <section class="retro-grid-bg py-7 sm:py-12 px-3.5 sm:px-6 lg:px-8 select-none">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[20px] sm:rounded-[28px] border-2 border-black shadow-[3px_4px_0px_rgba(61,93,86,0.45)] sm:shadow-[6px_6px_0px_rgba(61,93,86,0.5)] px-4 py-5 sm:px-8 sm:py-11 min-h-0 sm:min-h-[164px] flex flex-col sm:flex-row items-center justify-between gap-3.5 sm:gap-5 toon-reveal-up">

                <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <!-- Speech bubble question mark icon matching Photo 1 -->
                    <div class="w-11 h-11 sm:w-14 sm:h-14 shrink-0 relative flex items-center justify-center">
                        <svg class="w-11 h-11 sm:w-14 sm:h-14 text-[#3b5a53]" viewBox="0 0 64 64" fill="currentColor" aria-hidden="true">
                            <path d="M32 6C17.64 6 6 17.64 6 32c0 5.4 1.64 10.42 4.45 14.59L8 58l12.18-2.67C23.94 56.91 27.84 58 32 58c14.36 0 26-11.64 26-26S46.36 6 32 6z"/>
                            <path d="M26.5 25.5c0-3.2 2.5-5.5 5.8-5.5 3.4 0 5.7 2.1 5.7 4.9 0 2.3-1.4 3.6-3.4 4.8-1.6 1-2.6 1.8-2.6 3.5v1.3" fill="none" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                            <circle cx="32" cy="41.5" r="2.6" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-hegarty font-normal text-sm sm:text-base md:text-lg text-[#27443E] uppercase tracking-wide"
                            style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                            ADA YANG MAU DITANYAIN?
                        </h3>
                        <p class="text-[11.5px] sm:text-sm text-gray-500 mt-0.5">
                            Ada pertanyaan soal menu, lokasi, atau jam buka? Kami siap membantu.
                        </p>
                    </div>
                </div>

                <a href="{{ route('contact') }}"
                   class="min-h-[40px] sm:min-h-[44px] w-full sm:w-auto justify-center bg-[#3b5a53] hover:bg-[#2d4741] text-white font-medium text-xs sm:text-sm px-5 sm:px-6 py-2 sm:py-2.5 rounded-xl transition shadow-xs flex items-center gap-2 shrink-0 cursor-pointer active:scale-95">
                    <span>Kontak Kami</span>
                </a>

            </div>
        </div>
    </section>

</div>
@endsection

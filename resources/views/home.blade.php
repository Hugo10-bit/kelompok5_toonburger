@extends('layouts.app')

@section('title', 'Toon Burger - Setiap Gigitan Punya Cerita!')

@section('content')
<div class="space-y-0 pb-0">

    <!-- ═══════════════════════════════════════════════
         1. HERO SECTION (Sesuai Foto 5)
         ═══════════════════════════════════════════════ -->
    <section id="hero-section" class="relative overflow-hidden -mt-[105px] sm:-mt-[112px]">
        <div class="w-full">
            <!-- Hero Background: Dark Slate Green (#385850) -->
            <div class="relative overflow-hidden w-full pt-32 sm:pt-36 lg:pt-40"
                 style="background-color: #385850; min-height: 520px;">

                <!-- Concentric / wavy retro background curves -->
                <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 500">
                    <path d="M-100,50 C200,20 400,120 700,70 C900,30 1100,100 1200,80" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,120 C200,90 400,190 700,140 C900,100 1100,170 1200,150" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,190 C200,160 400,260 700,210 C900,170 1100,240 1200,220" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,260 C200,230 400,330 700,280 C900,240 1100,310 1200,290" fill="none" stroke="#fff" stroke-width="1.5"/>
                </svg>

                <!-- Comic Sparkles Floating in Background -->
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="top: 24%; left: 3%; animation-delay: 0s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 26%; right: 34%; animation-delay: 0.7s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="bottom: 18%; right: 23%; animation-delay: 1.4s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 16%; left: 40%; animation-delay: 2.1s;">

                <!-- Content Grid -->
                <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-10 lg:px-12 pt-4 sm:pt-6 pb-8">

                    <!-- Left: Headline + Subtitle + Buttons -->
                    <div class="lg:col-span-5 space-y-4 pb-6 lg:pb-10 toon-reveal">
                        <h1 class="font-brand text-white uppercase leading-[0.95] drop-shadow-sm text-4xl sm:text-5xl lg:text-[56px] xl:text-[64px]"
                            style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                            SETIAP GIGITAN<br>PUNYA CERITA!
                        </h1>

                        <p class="text-xs sm:text-sm md:text-base text-white/90 leading-relaxed max-w-sm sm:max-w-md">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.
                        </p>

                        <!-- CTA Buttons: Pickup Order & Delivery Order -->
                        <div class="flex flex-wrap items-center gap-3.5 pt-2">
                            <a href="{{ route('menu') }}"
                               class="font-bold text-xs sm:text-sm px-6 py-2.5 rounded-xl border border-black/80 bg-[#f5a623] hover:bg-[#e0961f] text-black shadow-[2px_2px_0px_#000] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer">
                                Pickup Order
                            </a>
                            <a href="{{ route('menu') }}"
                               class="font-medium text-xs sm:text-sm px-6 py-2.5 rounded-xl border border-white/80 bg-[#385850] hover:bg-[#2d4741] text-white transition cursor-pointer">
                                Delivery Order
                            </a>
                        </div>
                    </div>

                    <!-- Center: Hero Double/Triple Cheeseburger with comic dashes -->
                    <div class="lg:col-span-4 relative flex justify-center items-end self-end pb-4 lg:pb-6 pt-2 sm:pt-4">
                        <div class="relative z-10">
                            <!-- Small comic white accent lines above burger -->
                            <div class="absolute -top-3 left-1/4 flex gap-1.5 opacity-80 pointer-events-none">
                                <span class="w-1.5 h-3 bg-white rounded-full -rotate-12"></span>
                                <span class="w-1.5 h-3.5 bg-white rounded-full"></span>
                                <span class="w-1.5 h-3 bg-white rounded-full rotate-12"></span>
                            </div>

                            <img id="hero-burger-img"
                                 src="{{ asset('images/hero-burger.png') }}"
                                 alt="Very Cheese Burger"
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="sync"
                                 width="380"
                                 height="380"
                                 style="will-change: transform;"
                                 class="w-[280px] sm:w-[320px] lg:w-[350px] xl:w-[380px] h-auto object-contain cursor-pointer transition-transform duration-100 hover:scale-105 active:scale-95 drop-shadow-[0_18px_32px_rgba(0,0,0,0.4)] select-none">
                        </div>
                    </div>

                    <!-- Right: Starburst Comic Speech Bubble ("VERY CHEESE BURGER") -->
                    <div class="lg:col-span-3 relative flex justify-center lg:justify-end items-center pb-6 lg:pb-10">
                        <div class="relative cursor-pointer select-none transition-transform hover:scale-105">
                            <img id="hero-badge-img"
                                 src="{{ asset('images/very-cheese-badge.png') }}"
                                 alt="VERY CHEESE BURGER"
                                 class="w-44 sm:w-52 lg:w-56 xl:w-60 h-auto object-contain drop-shadow-md">
                        </div>
                    </div>

                </div>

                <!-- Retro Checkered Bottom Border (2 rows of black & white squares) -->
                <div class="w-full" style="height: 24px; background: repeating-conic-gradient(#1a332d 0% 25%, #ffffff 0% 50%) 0 0 / 22px 22px;"></div>

            </div>
        </div>
    </section>

    <!-- Section: Kenapa Toon Burger (Matching Figma exactly with authentic background asset and adjusted cards) -->
    <section class="relative w-full pt-10 pb-12 sm:pt-12 sm:pb-14 px-4 sm:px-6 lg:px-8 overflow-hidden select-none"
             style="background-color: #FAF5E9; background-image: url('{{ asset('images/why-us-bg-body.png') }}'); background-repeat: no-repeat; background-position: center bottom; background-size: cover;">

        <div class="max-w-[920px] mx-auto relative z-20 text-center space-y-2 mb-8 sm:mb-10">
            <div class="inline-flex items-center px-4 py-1 rounded-full bg-[#4C6B65] text-white text-[11px] font-medium border border-black/80 shadow-[1px_2px_0px_#1E2E2B]">
                Keunggulan Kami
            </div>

            <h2 class="text-2xl sm:text-[28px] lg:text-[34px] text-[#243F3B] uppercase tracking-wide pt-0.5"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                KENAPA TOON BURGER?
            </h2>

            <p class="text-xs sm:text-[13px] text-gray-500 max-w-[500px] mx-auto leading-relaxed">
                Nikmati sensasi kelezatan burger terbaik dengan daging pilihan dan bahan segar yang siap memuaskan rasa lapar Anda kapan saja.
            </p>
        </div>

        <div class="max-w-[920px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 relative z-20">

            <!-- Card 1: 100% Daging -->
            <div class="bg-white rounded-[22px] sm:rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-5 sm:p-5.5 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl border border-[#F5C2C2] bg-[#FDF2F2] flex items-center justify-center text-[#E03A3A] mb-3 shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug">
                    Terbuat dari 100% Daging
                </h3>
                <p class="text-xs sm:text-[12px] text-gray-500 leading-relaxed pt-1.5 relative z-10">
                    Nikmati patty berkualitas yang dibuat dari 100% daging pilihan.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-20 h-20 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                </svg>
            </div>

            <!-- Card 2: Bahan Segar Setiap Hari -->
            <div class="bg-white rounded-[22px] sm:rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-5 sm:p-5.5 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl border border-[#BDE0D8] bg-[#F0F7F5] flex items-center justify-center text-[#2E7A6B] mb-3 shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug">
                    Bahan Segar Setiap Hari
                </h3>
                <p class="text-xs sm:text-[12px] text-gray-500 leading-relaxed pt-1.5 relative z-10">
                    Selalu fresh setiap hari, karena rasa terbaik dimulai dari bahan berkualitas
                </p>
                <svg class="absolute -bottom-2 -right-2 w-20 h-20 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                    <circle cx="12" cy="11" r="3"/>
                </svg>
            </div>

            <!-- Card 3: Pesanan Cepat -->
            <div class="bg-white rounded-[22px] sm:rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-5 sm:p-5.5 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl border border-[#FDE68A] bg-[#FFFBEB] flex items-center justify-center text-[#D97706] mb-3 shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug">
                    Pesanan Cepat
                </h3>
                <p class="text-xs sm:text-[12px] text-gray-500 leading-relaxed pt-1.5 relative z-10">
                    Disiapkan dengan cepat tanpa mengorbankan kualitas dan cita rasa.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-20 h-20 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                </svg>
            </div>

            <!-- Card 4: Porsi Bikin Kenyang -->
            <div class="bg-white rounded-[22px] sm:rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-5 sm:p-5.5 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl border border-[#BFDBFE] bg-[#EFF6FF] flex items-center justify-center text-[#2563EB] mb-3 shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug">
                    Porsi Bikin Kenyang
                </h3>
                <p class="text-xs sm:text-[12px] text-gray-500 leading-relaxed pt-1.5 relative z-10">
                    Porsi pas dan mengenyangkan, cocok untuk menemani rasa lapar kapan saja.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-20 h-20 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                </svg>
        </div>

    </section>

    <!-- Bottom Yellow Ribbon with TOONBURGER ★ matching Figma exactly -->
    <div class="w-full bg-[#F5B027] py-3.5 overflow-hidden select-none">
        <div class="whitespace-nowrap text-base sm:text-lg font-black text-[#1E2E2B] uppercase tracking-wider flex items-center justify-center overflow-x-hidden"
             style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
            @for($i = 0; $i < 12; $i++)
                <span class="mx-3.5 flex items-center gap-3">TOONBURGER <span class="text-[#D93829] text-xl leading-none">★</span></span>
            @endfor
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         4. BEST SELLER SECTION (Sesuai Foto 4)
         ═══════════════════════════════════════════════ -->
    <section class="retro-grid-bg pt-12 pb-14 sm:pt-16 sm:pb-16 px-4 sm:px-6 lg:px-8 select-none">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Section Header -->
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="font-brand text-3xl sm:text-4xl lg:text-5xl text-[#27443e] uppercase tracking-wide"
                        style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                        BEST SELLER
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-lg">
                        Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                    </p>
                </div>

                <a href="{{ route('menu') }}"
                   class="border-2 border-black bg-white rounded-xl px-4 py-2 font-bold text-xs sm:text-sm text-gray-900 shadow-[2px_2px_0px_#000] hover:bg-gray-50 transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- 4 Product Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1. Very Cheese Burger -->
                <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-4 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200">
                    <div>
                        <!-- Top Image Box: Yellow Background (Full Bleed Seamless) -->
                        <div class="w-full aspect-[1.45] rounded-2xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products/very-cheese-burger.png') }}"
                                 alt="Very Cheese Burger"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <div class="pt-3 pb-1">
                            <span class="text-[11px] font-bold text-[#D97706] uppercase tracking-wide">
                                CHEESE BURGER
                            </span>
                            <h3 class="font-bold text-base text-gray-900 mt-0.5 leading-snug">
                                Very Cheese Burger
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-1">
                                Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                        <span class="font-black text-base text-gray-900">
                            Rp 35.000
                        </span>
                        <button type="button"
                                onclick="quickAddToCart(1)"
                                class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-2xs cursor-pointer">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- 2. Cheese Chicken Burger -->
                <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-4 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200">
                    <div>
                        <!-- Top Image Box: Beige/Tan Background (Full Bleed Seamless) -->
                        <div class="w-full aspect-[1.45] rounded-2xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products/cheese-chicken-burger.png') }}"
                                 alt="Cheese Chicken Burger"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <div class="pt-3 pb-1">
                            <span class="text-[11px] font-bold text-[#D97706] uppercase tracking-wide">
                                CHICKEN BURGER
                            </span>
                            <h3 class="font-bold text-base text-gray-900 mt-0.5 leading-snug">
                                Cheese Chicken Burger
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-1">
                                Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                        <span class="font-black text-base text-gray-900">
                            Rp 23.000
                        </span>
                        <button type="button"
                                onclick="quickAddToCart(2)"
                                class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-2xs cursor-pointer">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- 3. BBQ Beef Burger -->
                <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-4 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200">
                    <div>
                        <!-- Top Image Box: Vibrant Red Background (Full Bleed Seamless) -->
                        <div class="w-full aspect-[1.45] rounded-2xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products/bbq-beef-burger.png') }}"
                                 alt="BBQ Beef Burger"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <div class="pt-3 pb-1">
                            <span class="text-[11px] font-bold text-[#D97706] uppercase tracking-wide">
                                BEEF BURGER
                            </span>
                            <h3 class="font-bold text-base text-gray-900 mt-0.5 leading-snug">
                                BBQ Beef Burger
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-1">
                                Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                        <span class="font-black text-base text-gray-900">
                            Rp 37.000
                        </span>
                        <button type="button"
                                onclick="quickAddToCart(3)"
                                class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-2xs cursor-pointer">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- 4. Double Cheese Burger -->
                <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-4 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200">
                    <div>
                        <!-- Top Image Box: Soft Green Background (Full Bleed Seamless) -->
                        <div class="w-full aspect-[1.45] rounded-2xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products/double-cheese-burger.png') }}"
                                 alt="Double Cheese Burger"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <div class="pt-3 pb-1">
                            <span class="text-[11px] font-bold text-[#D97706] uppercase tracking-wide">
                                CHEESE BURGER
                            </span>
                            <h3 class="font-bold text-base text-gray-900 mt-0.5 leading-snug">
                                Double Cheese Burger
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-1">
                                Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...
                            </p>
                        </div>
                    </div>

                    <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                        <span class="font-black text-base text-gray-900">
                            Rp 33.000
                        </span>
                        <button type="button"
                                onclick="quickAddToCart(4)"
                                class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-2xs cursor-pointer">
                            Pesan
                        </button>
                    </div>
                </div>

            </div>

            <!-- ═══════════════════════════════════════════════
                 5. NGGAK SEMPAT KE TOKO? GOFOOD AJA! BANNER
                 ═══════════════════════════════════════════════ -->
            <div class="bg-white rounded-[28px] border-2 border-black shadow-[6px_6px_0px_#a83232] p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-[#cc292b] text-white flex items-center justify-center text-2xl font-bold shrink-0 shadow-xs">
                        🍴
                    </div>
                    <div>
                        <h3 class="font-black text-sm sm:text-base md:text-lg text-gray-900 uppercase tracking-tight">
                            NGGAK SEMPAT  KE TOKO? GOFOOD AJA!
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                            Burger favoritmu diantar langsung ke rumah, langsung dari aplikasi Gojek
                        </p>
                    </div>
                </div>

                <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer"
                   class="bg-[#a62b2b] hover:bg-[#8e2424] text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-xl transition shadow-xs flex items-center gap-2 shrink-0 cursor-pointer active:scale-95">
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
    <section class="w-full py-14 sm:py-16 px-4 sm:px-6 lg:px-8 select-none" style="background-color: #385850;">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[32px] border-2 border-black shadow-[8px_8px_0px_#1e2f2b] p-6 sm:p-10 lg:p-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">

                    <!-- Left: Text -->
                    <div class="md:col-span-7 space-y-4">
                        <h2 class="font-brand text-3xl sm:text-4xl lg:text-5xl text-[#27443e] uppercase leading-[1.05]"
                            style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                            MENGENAL TOON<br>BURGER
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mt-4">
                            Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, Toon Burger hadir membawa nuansa karakter kartun retro yang
                        </p>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mt-2">
                            enerjik, ceria, dan bersahabat bagi siapa saja.<br>
                            Setiap patty daging sapi digiling dari potongan daging segar berkualitas pilihan, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.
                        </p>

                        <div class="pt-4">
                            <a href="{{ route('about') }}"
                               class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs sm:text-sm font-bold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-[2px_2px_0px_#000] transition cursor-pointer">
                                <span>Selengkapnya Tentang Kami</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Outdoor Sign Photo with cartoon cat -->
                    <div class="md:col-span-5 flex justify-center md:justify-end">
                        <div class="w-full max-w-md rounded-2xl overflow-hidden border-2 border-black shadow-[4px_4px_0px_#000] mx-auto md:ml-auto">
                            <img src="{{ asset('images/toonburger-outdoor-sign-hq.png') }}"
                                 alt="Toon Burger Sign"
                                 class="w-full h-56 sm:h-64 lg:h-72 object-cover">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         7. ADA YANG MAU DITANYAIN? BANNER (Sesuai Foto 1)
         ═══════════════════════════════════════════════ -->
    <section class="retro-grid-bg py-10 sm:py-12 px-4 sm:px-6 lg:px-8 select-none">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[28px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-5 sm:p-7 flex flex-col sm:flex-row items-center justify-between gap-5">

                <div class="flex items-center gap-4">
                    <!-- Speech bubble question mark icon matching Photo 1 -->
                    <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 relative flex items-center justify-center">
                        <svg class="w-14 h-14 sm:w-16 sm:h-16 text-[#3b5a53]" viewBox="0 0 64 64" fill="currentColor">
                            <path d="M32 6C17.64 6 6 17.64 6 32c0 5.4 1.64 10.42 4.45 14.59L8 58l12.18-2.67C23.94 56.91 27.84 58 32 58c14.36 0 26-11.64 26-26S46.36 6 32 6z"/>
                            <text x="32" y="39" fill="white" font-size="28" font-family="'BBH Hegarty', sans-serif" font-weight="bold" text-anchor="middle">?</text>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-lg sm:text-xl lg:text-2xl text-gray-900 uppercase tracking-tight">
                            ADA YANG MAU DITANYAIN?
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                            Ada pertanyaan soal menu, lokasi, atau jam buka? Kami siap membantu."
                        </p>
                    </div>
                </div>

                <a href="{{ route('contact') }}"
                   class="bg-[#3b5a53] hover:bg-[#2d4741] text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl shrink-0 transition cursor-pointer shadow-xs">
                    Kontak Kami
                </a>

            </div>
        </div>
    </section>

</div>
@endsection

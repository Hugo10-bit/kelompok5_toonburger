@extends('layouts.app')

@section('title', 'Toon Burger - Setiap Gigitan Punya Cerita!')

@section('content')
<div class="space-y-0 pb-0">

    <section id="hero-section" class="relative overflow-hidden -mt-[88px] sm:-mt-[96px]">
        <div class="w-full">
            <div class="relative overflow-hidden w-full pt-24 sm:pt-28 lg:pt-32 flex flex-col justify-between"
                 style="background-color: #3E615D;">

                <!-- Background Topographic Contour Waves matching Figma mockup -->
                <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20 select-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 500" fill="none">
                    <!-- Left Topographic Waves -->
                    <path d="M-60 0 C 40 160, 100 320, 160 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M-30 0 C 70 160, 130 320, 190 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M0 0 C 100 160, 160 320, 220 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M30 0 C 130 160, 190 320, 250 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M60 0 C 160 160, 220 320, 280 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M90 0 C 190 160, 250 320, 310 500" stroke="#ffffff" stroke-width="1.2"/>

                    <!-- Right Topographic Waves -->
                    <path d="M1500 0 C 1410 160, 1330 320, 1240 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1470 0 C 1380 160, 1300 320, 1210 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1440 0 C 1350 160, 1270 320, 1180 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1410 0 C 1320 160, 1240 320, 1150 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1380 0 C 1290 160, 1210 320, 1120 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1350 0 C 1260 160, 1180 320, 1090 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1320 0 C 1230 160, 1150 320, 1060 500" stroke="#ffffff" stroke-width="1.2"/>
                    <path d="M1290 0 C 1200 160, 1120 320, 1030 500" stroke="#ffffff" stroke-width="1.2"/>
                </svg>

                <!-- 4 Comic Sparkle Stars matching exact positions in Figma mockup -->
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="top: 24%; left: 3.5%; animation-delay: 0s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 26%; left: 60%; animation-delay: 0.7s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 72%; left: 40.5%; animation-delay: 1.4s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 68%; left: 82%; animation-delay: 2.1s;">

                <div class="relative z-10 max-w-[1180px] w-full mx-auto grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-10 lg:px-12 pt-4 sm:pt-6 pb-6 lg:pb-8">

                    <!-- Left Column: Heading, Subtitle, CTA Buttons -->
                    <div class="lg:col-span-6 space-y-3.5 sm:space-y-4 pb-2 lg:pb-0">
                        <h1 class="text-white uppercase leading-[0.96] text-4xl sm:text-5xl lg:text-[56px] xl:text-[62px] tracking-wide"
                            style="font-family: 'Luckiest Guy', cursive; -webkit-text-stroke: 1.5px #1E2E2B; text-shadow: 3px 4px 0px #1E2E2B;">
                            SETIAP GIGITAN<br>PUNYA CERITA!
                        </h1>

                        <p class="text-xs sm:text-[13.5px] text-white/90 leading-relaxed font-normal max-w-sm sm:max-w-md pt-1">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan<br class="hidden sm:inline"> dalam setiap hidangan.
                        </p>

                        <div class="flex items-center gap-3.5 pt-3 sm:pt-4">
                            <a href="{{ route('menu') }}"
                               class="font-bold text-xs sm:text-sm px-5 py-2.5 sm:px-6 sm:py-2.5 rounded-lg border border-black/80 bg-[#F5B027] hover:bg-[#E09E1E] text-gray-950 shadow-[2px_2px_0px_#1E2E2B] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer inline-flex items-center justify-center">
                                Pickup Order
                            </a>
                            <a href="{{ route('menu') }}"
                               class="font-medium text-xs sm:text-sm px-5 py-2.5 sm:px-6 sm:py-2.5 rounded-lg border border-white/90 bg-transparent hover:bg-white/10 text-white transition cursor-pointer inline-flex items-center justify-center">
                                Delivery Order
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Steam, Burger, Comic Speech Bubble (Positioned without overlapping) -->
                    <div class="lg:col-span-6 relative flex justify-center lg:justify-end items-center pt-8 lg:pt-0 lg:pr-14 xl:pr-18">
                        <div class="relative inline-flex items-center justify-center">
                            <!-- Comic Steam lines above top-left of burger -->
                            <div class="absolute -top-3.5 left-3 sm:-top-5 sm:left-4 z-10 pointer-events-none select-none">
                                <svg class="w-10 h-10 sm:w-11 sm:h-11 text-white opacity-95" viewBox="0 0 50 50" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                                    <path d="M12 36 C9 32, 8 28, 7 24" />
                                    <path d="M19 26 C17 21, 16 17, 15 13" />
                                    <path d="M30 18 C30 13, 29 9, 28 5" />
                                    <path d="M41 16 C43 12, 43 8, 42 4" />
                                </svg>
                            </div>

                            <!-- Burger Image (Full clear view, no badge overlapping it) -->
                            <div class="relative z-20">
                                <img id="hero-burger-img"
                                     src="{{ asset('images/hero-burger.png') }}"
                                     alt="Very Cheese Burger"
                                     class="w-[225px] sm:w-[260px] lg:w-[285px] xl:w-[305px] h-auto object-contain select-none drop-shadow-[0_16px_28px_rgba(0,0,0,0.35)]">
                            </div>

                            <!-- Comic Speech Bubble Badge placed to the top-right without covering burger -->
                            <div class="absolute -top-12 -right-24 sm:-top-14 sm:-right-32 lg:-top-16 lg:-right-36 xl:-top-18 xl:-right-44 z-10 pointer-events-none select-none">
                                <img id="hero-badge-img"
                                     src="{{ asset('images/very-cheese-badge.png') }}"
                                     alt="VERY CHEESE BURGER"
                                     class="w-36 sm:w-44 lg:w-48 xl:w-52 h-auto object-contain drop-shadow-[0_10px_20px_rgba(0,0,0,0.22)]">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3 Rows Checkered Border (36px = 3 x 12px) matching Figma -->
                <div class="w-full mt-4 sm:mt-6" style="height: 36px; background: repeating-conic-gradient(#3E615D 0% 25%, #ffffff 0% 50%) 0 0 / 24px 24px;"></div>

                <!-- Bottom Teal Strip below checkered border matching Figma layout -->
                <div class="w-full h-7 sm:h-8"></div>

            </div>
        </div>
    </section>

    <!-- Section: Kenapa Toon Burger (Matching Figma exactly with authentic background asset and adjusted cards) -->
    <section class="relative w-full pt-10 pb-12 sm:pt-12 sm:pb-14 px-4 sm:px-6 lg:px-8 overflow-hidden select-none"
             style="background-color: #FAF5E9; background-image: url('{{ asset('images/why-us-bg-body.png') }}'); background-repeat: no-repeat; background-position: center bottom; background-size: cover;">

        <div class="max-w-[780px] mx-auto relative z-20 text-center space-y-2 mb-8 sm:mb-9">
            <div class="inline-flex items-center px-4 py-1 rounded-full bg-[#4C6B65] text-white text-[11px] font-medium border border-black/80 shadow-[1px_2px_0px_#1E2E2B]">
                Keunggulan Kami
            </div>

            <h2 class="text-2xl sm:text-[28px] lg:text-[32px] text-[#243F3B] uppercase tracking-wide pt-0.5"
                style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                KENAPA TOON BURGER?
            </h2>

            <p class="text-[11px] sm:text-xs text-gray-500 max-w-[480px] mx-auto leading-relaxed">
                Nikmati sensasi kelezatan burger terbaik dengan daging pilihan dan bahan segar yang siap memuaskan rasa lapar Anda kapan saja.
            </p>
        </div>

        <div class="max-w-[780px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-4.5 relative z-20">

            <!-- Card 1: 100% Daging -->
            <div class="bg-white rounded-[20px] sm:rounded-[22px] border-[1.5px] border-black shadow-[4px_5px_0px_#6E7571] p-4 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-8 h-8 rounded-lg border border-[#F5C2C2] bg-[#FDF2F2] flex items-center justify-center text-[#E03A3A] mb-2.5 shrink-0">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[13px] text-gray-900 leading-tight">
                    Terbuat dari 100% Daging
                </h3>
                <p class="text-[10.5px] text-gray-500 leading-relaxed pt-1 relative z-10">
                    Nikmati patty berkualitas yang dibuat dari 100% daging pilihan.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-16 h-16 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                </svg>
            </div>

            <!-- Card 2: Bahan Segar Setiap Hari -->
            <div class="bg-white rounded-[20px] sm:rounded-[22px] border-[1.5px] border-black shadow-[4px_5px_0px_#6E7571] p-4 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-8 h-8 rounded-lg border border-[#BDE0D8] bg-[#F0F7F5] flex items-center justify-center text-[#2E7A6B] mb-2.5 shrink-0">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[13px] text-gray-900 leading-tight">
                    Bahan Segar Setiap Hari
                </h3>
                <p class="text-[10.5px] text-gray-500 leading-relaxed pt-1 relative z-10">
                    Selalu fresh setiap hari, karena rasa terbaik dimulai dari bahan berkualitas
                </p>
                <svg class="absolute -bottom-2 -right-2 w-16 h-16 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 2a9 9 0 0 1 9 9c0 5-9 11-9 11S3 16 3 11a9 9 0 0 1 9-9z"/>
                    <circle cx="12" cy="11" r="3"/>
                </svg>
            </div>

            <!-- Card 3: Pesanan Cepat -->
            <div class="bg-white rounded-[20px] sm:rounded-[22px] border-[1.5px] border-black shadow-[4px_5px_0px_#6E7571] p-4 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-8 h-8 rounded-lg border border-[#FDE68A] bg-[#FFFBEB] flex items-center justify-center text-[#D97706] mb-2.5 shrink-0">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[13px] text-gray-900 leading-tight">
                    Pesanan Cepat
                </h3>
                <p class="text-[10.5px] text-gray-500 leading-relaxed pt-1 relative z-10">
                    Disiapkan dengan cepat tanpa mengorbankan kualitas dan cita rasa.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-16 h-16 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                </svg>
            </div>

            <!-- Card 4: Porsi Bikin Kenyang -->
            <div class="bg-white rounded-[20px] sm:rounded-[22px] border-[1.5px] border-black shadow-[4px_5px_0px_#6E7571] p-4 text-left flex flex-col justify-start relative overflow-hidden transition-transform duration-200 hover:-translate-y-1">
                <div class="w-8 h-8 rounded-lg border border-[#BFDBFE] bg-[#EFF6FF] flex items-center justify-center text-[#2563EB] mb-2.5 shrink-0">
                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[13px] text-gray-900 leading-tight">
                    Porsi Bikin Kenyang
                </h3>
                <p class="text-[10.5px] text-gray-500 leading-relaxed pt-1 relative z-10">
                    Porsi pas dan mengenyangkan, cocok untuk menemani rasa lapar kapan saja.
                </p>
                <svg class="absolute -bottom-2 -right-2 w-16 h-16 text-gray-900 opacity-[0.06] pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                </svg>
            </div>

        </div>

    </section>

    <!-- Bottom Yellow Ribbon with TOONBURGER ★ matching Figma exactly -->
    <div class="w-full bg-[#F5B027] py-3.5 overflow-hidden select-none">
        <div class="whitespace-nowrap text-base sm:text-lg font-black text-[#1E2E2B] uppercase tracking-wider flex items-center justify-center overflow-x-hidden"
             style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
            @for($i = 0; $i < 12; $i++)
                <span class="mx-3.5 flex items-center gap-3">TOONBURGER <span class="text-[#D93829] text-xl leading-none">★</span></span>
            @endfor
        </div>
    </div>

    <section class="retro-grid-bg pt-12 pb-14 sm:pt-16 sm:pb-16 px-4 sm:px-6 lg:px-8 select-none">
        <div class="max-w-6xl mx-auto space-y-8">

            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl sm:text-4xl lg:text-[42px] text-[#243F3B] uppercase tracking-wide"
                        style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                        BEST SELLER
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1.5 max-w-md leading-relaxed">
                        Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                    </p>
                </div>

                <a href="{{ route('menu') }}"
                   class="border border-black/80 bg-transparent hover:bg-white/70 rounded-xl px-5 py-2.5 font-medium text-xs sm:text-sm text-gray-900 transition cursor-pointer flex items-center gap-2 shrink-0">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-4 flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1 group">
                        <div onclick="openProductModal({{ $product->id }})" class="cursor-pointer">
                            <div class="w-full rounded-2xl overflow-hidden bg-gray-50 flex items-center justify-center p-2">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-auto object-contain block group-hover:scale-105 transition-transform duration-300">
                            </div>

                            <div class="pt-3.5 pb-1">
                                <span class="text-[10px] font-bold text-[#E6A817] uppercase tracking-wider block">
                                    {{ $product->category_label ?? ($product->category->name ?? 'CHEESE BURGER') }}
                                </span>
                                <h3 class="font-extrabold text-[15px] text-gray-900 mt-0.5 leading-snug group-hover:text-[#415C58] transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[11px] text-gray-400 line-clamp-2 leading-relaxed mt-1">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                            <span class="font-extrabold text-base text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button type="button"
                                    onclick="openProductModal({{ $product->id }})"
                                    class="bg-[#415C58] hover:bg-[#344B48] text-white text-xs font-medium px-5 py-2 rounded-lg transition active:scale-95 cursor-pointer">
                                Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                <div class="bg-white rounded-[26px] border-[1.5px] border-black shadow-[5px_6px_0px_#C85A5A] px-6 sm:px-10 py-6 sm:py-7 flex flex-col sm:flex-row items-center justify-between gap-5">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#C93328] text-white flex items-center justify-center shrink-0">
                            <svg class="w-9 h-9 sm:w-10 sm:h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 2v9c0 1.1.9 2 2 2v9h2v-9c1.1 0 2-.9 2-2V2h-1.5v7h-1V2h-1v7h-1V2H7zm9.5 0C14.57 2 13 3.79 13 6v5h2.5v11h2V2h-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg md:text-xl text-[#222222] uppercase tracking-wide"
                                style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                                NGGAK SEMPAT KE TOKO? GOFOOD AJA!
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-400 mt-1">
                                Burger favoritmu diantar langsung ke rumah, langsung dari aplikasi Gojek
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer"
                       class="bg-[#A9322C] hover:bg-[#8F2823] text-white font-medium text-xs sm:text-sm px-5 py-3 rounded-lg transition flex items-center gap-2 shrink-0 cursor-pointer">
                        <span>Buka Gojek</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="w-full py-14 sm:py-16 px-4 sm:px-6 lg:px-8 select-none" style="background-color: #405E58;">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-[28px] p-7 sm:p-10 lg:p-12 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">

                    <div class="md:col-span-7 space-y-4">
                        <h2 class="text-3xl sm:text-4xl lg:text-[40px] text-[#27443E] uppercase leading-[1.1]"
                            style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                            MENGENAL TOON<br>BURGER
                        </h2>

                        <p class="text-xs sm:text-[13.5px] text-gray-500 leading-relaxed pt-1">
                            Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, Toon Burger hadir membawa nuansa karakter kartun retro yang
                        </p>

                        <p class="text-xs sm:text-[13.5px] text-gray-500 leading-relaxed">
                            enerjik, ceria, dan bersahabat bagi siapa saja.<br>
                            Setiap patty daging sapi digiling dari potongan daging segar berkualitas pilihan, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.
                        </p>

                        <div class="pt-3">
                            <a href="{{ route('about') }}"
                               class="bg-[#415C58] hover:bg-[#344B48] text-white text-xs sm:text-sm font-medium px-5 py-3 rounded-lg inline-flex items-center gap-2 transition cursor-pointer">
                                <span>Selengkapnya Tentang Kami</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex justify-center md:justify-end">
                        <div class="w-full max-w-[340px] rounded-[22px] overflow-hidden">
                            <img src="{{ asset('images/toonburger-outdoor-sign-hq.png') }}"
                                 alt="Toon Burger Sign"
                                 class="w-full h-64 sm:h-72 object-cover block">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="retro-grid-bg py-10 sm:py-12 px-4 sm:px-6 lg:px-8 select-none">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-[26px] border-[1.5px] border-black shadow-[5px_6px_0px_#8F9693] px-6 sm:px-10 py-7 sm:py-8 flex flex-col sm:flex-row items-center justify-between gap-5">

                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 relative flex items-center justify-center">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-[#415C58]" viewBox="0 0 64 64" fill="currentColor">
                            <path d="M32 6C17.64 6 6 16.75 6 30c0 11.4 8.62 20.94 20.2 23.4L26 60l11.2-6.4C49.6 51.4 58 41.7 58 30 58 16.75 46.36 6 32 6z"/>
                            <text x="32" y="39" fill="white" font-size="30" font-family="'Poppins', sans-serif" font-weight="600" text-anchor="middle">?</text>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl text-[#27443E] uppercase tracking-wide"
                            style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                            ADA YANG MAU DITANYAIN?
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">
                            Ada pertanyaan soal menu, lokasi, atau jam buka? Kami siap membantu."
                        </p>
                    </div>
                </div>

                <a href="{{ route('contact') }}"
                   class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium text-xs sm:text-sm px-6 py-3 rounded-lg shrink-0 transition cursor-pointer">
                    Kontak Kami
                </a>

            </div>
        </div>
    </section>

</div>
@endsection

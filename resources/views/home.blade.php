@extends('layouts.app')

@section('title', 'Toon Burger - Setiap Gigitan Punya Cerita!')

@section('content')
<div class="space-y-0 pb-0">

    <section id="hero-section" class="relative overflow-hidden -mt-[88px] sm:-mt-[96px]">
        <div class="w-full">
            <div class="relative overflow-hidden w-full pt-28 sm:pt-32 lg:pt-36 flex flex-col justify-between"
                 style="background-color: #405E58; min-height: 540px;">

                <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 600" fill="none">
                    <path d="M-40 0 C 40 200, 120 400, 180 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M-10 0 C 70 200, 150 400, 210 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M20 0 C 100 200, 180 400, 240 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M50 0 C 130 200, 210 400, 270 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M1480 0 C 1400 200, 1320 400, 1260 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M1450 0 C 1370 200, 1290 400, 1230 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M1420 0 C 1340 200, 1260 400, 1200 600" stroke="#ffffff" stroke-width="1"/>
                    <path d="M1390 0 C 1310 200, 1230 400, 1170 600" stroke="#ffffff" stroke-width="1"/>
                </svg>

                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-6 sm:w-7 h-auto"
                     style="top: 23%; left: 3.5%; animation-delay: 0s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="top: 26%; right: 33%; animation-delay: 0.7s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 21%; right: 23%; animation-delay: 1.4s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt=""
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 18%; left: 40%; animation-delay: 2.1s;">

                <div class="relative z-10 max-w-[1340px] w-full mx-auto grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-10 lg:px-14 pt-6 sm:pt-8 pb-8">

                    <div class="lg:col-span-6 space-y-4 pb-6 lg:pb-8">
                        <h1 class="text-white uppercase leading-[0.98] text-4xl sm:text-5xl lg:text-[58px] xl:text-[64px] tracking-wide"
                            style="font-family: 'Luckiest Guy', cursive; -webkit-text-stroke: 1.5px #1E2E2B; text-shadow: 3px 4px 0px #1E2E2B;">
                            SETIAP GIGITAN<br>PUNYA CERITA!
                        </h1>

                        <p class="text-xs sm:text-sm md:text-[15px] text-white/90 leading-relaxed max-w-md font-normal">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.
                        </p>

                        <div class="flex flex-wrap items-center gap-3.5 pt-2">
                            <a href="{{ route('menu') }}"
                               class="font-bold text-xs sm:text-sm px-6 py-3 rounded-xl border border-black bg-[#F5B027] hover:bg-[#E09E1E] text-gray-900 shadow-[2px_3px_0px_#1E2E2B] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer">
                                Pickup Order
                            </a>
                            <a href="{{ route('menu') }}"
                               class="font-normal text-xs sm:text-sm px-6 py-3 rounded-xl border border-white/90 bg-transparent hover:bg-white/10 text-white transition cursor-pointer">
                                Delivery Order
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-6 relative flex justify-center lg:justify-end items-center pt-4 pb-4 lg:pr-4">
                        <div class="relative flex items-center justify-center">
                            <div class="relative z-10 lg:mr-28">
                                <svg class="absolute -top-4 -left-4 w-12 h-12 text-white pointer-events-none" viewBox="0 0 60 60" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                                    <line x1="12" y1="38" x2="6" y2="35" />
                                    <line x1="20" y1="24" x2="15" y2="18" />
                                    <line x1="34" y1="15" x2="32" y2="8" />
                                    <line x1="48" y1="12" x2="49" y2="5" />
                                </svg>

                                <img id="hero-burger-img"
                                     src="{{ asset('images/hero-burger.png') }}"
                                     alt="Very Cheese Burger"
                                     class="w-[240px] sm:w-[270px] lg:w-[295px] h-auto object-contain select-none drop-shadow-[0_16px_28px_rgba(0,0,0,0.35)]">
                            </div>

                            <div class="relative lg:absolute lg:-right-6 lg:-top-10 z-20 -ml-8 lg:ml-0 select-none">
                                <img id="hero-badge-img"
                                     src="{{ asset('images/very-cheese-badge.png') }}"
                                     alt="VERY CHEESE BURGER"
                                     class="w-40 sm:w-48 lg:w-56 h-auto object-contain">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="w-full" style="height: 54px; background: repeating-conic-gradient(#385850 0% 25%, #ffffff 0% 50%) 0 0 / 36px 36px;"></div>

            </div>
        </div>
    </section>

    <section class="retro-grid-bg relative pt-14 pb-16 sm:pt-16 sm:pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden select-none">

        <div class="absolute top-0 right-0 w-44 sm:w-64 lg:w-80 pointer-events-none z-10">
            <svg viewBox="0 0 320 210" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <circle cx="46" cy="14" r="14" fill="#F0AD16"/>
                <path d="M68,0 L320,0 L320,105 C312,105 308,65 300,65 C292,65 288,125 276,125 C264,125 262,70 250,70 C238,70 236,195 218,195 C200,195 198,65 184,65 C170,65 168,120 154,120 C140,120 136,45 120,45 C104,45 102,155 82,155 C62,155 68,40 68,0 Z" fill="#E39B0B"/>
                <path d="M72,0 L320,0 L320,98 C312,98 308,58 300,58 C292,58 288,118 276,118 C264,118 262,63 250,63 C238,63 236,188 218,188 C200,188 198,58 184,58 C170,58 168,113 154,113 C140,113 136,38 120,38 C104,38 102,148 82,148 C64,148 72,35 72,0 Z" fill="#F9BE25"/>
            </svg>
        </div>

        <svg class="absolute top-16 left-0 w-56 sm:w-72 h-auto pointer-events-none text-[#5A7670]" viewBox="0 0 260 400" fill="none">
            <path d="M-20,20 C40,140 160,180 220,400" stroke="currentColor" stroke-width="4" opacity="0.75"/>
            <path d="M-30,70 C30,180 120,220 170,400" stroke="currentColor" stroke-width="1.2" opacity="0.5"/>
            <path d="M-40,120 C20,220 90,260 130,400" stroke="currentColor" stroke-width="1.2" opacity="0.4"/>
            <path d="M-50,170 C10,260 60,300 90,400" stroke="currentColor" stroke-width="1.2" opacity="0.3"/>
        </svg>

        <div class="max-w-6xl mx-auto relative z-20 text-center space-y-3 mb-12">
            <div class="inline-flex items-center px-5 py-1 rounded-full bg-[#4A6B65] text-white text-xs font-medium border border-black/80 shadow-[1px_2px_0px_#1E2E2B]">
                Keunggulan Kami
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-[42px] text-[#243F3B] uppercase tracking-wide pt-1"
                style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
                KENAPA TOON BURGER?
            </h2>

            <p class="text-xs sm:text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                Nikmati sensasi kelezatan burger terbaik dengan daging pilihan dan bahan segar yang siap memuaskan rasa lapar Anda kapan saja.
            </p>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-20">

            <div class="bg-white rounded-[22px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-6 text-left flex flex-col justify-start space-y-3 relative overflow-hidden">
                <div class="w-10 h-10 rounded-lg border border-[#E59898] bg-[#FDF2F2] flex items-center justify-center text-[#C93B2B]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug pt-1">
                    Terbuat dari 100% Daging
                </h3>
                <p class="text-[11.5px] text-gray-500 leading-relaxed relative z-10">
                    Nikmati patty berkualitas yang dibuat dari 100% daging pilihan.
                </p>
                <svg class="absolute -bottom-3 -right-3 w-24 h-24 text-gray-200/70 pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
                </svg>
            </div>

            <div class="bg-white rounded-[22px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-6 text-left flex flex-col justify-start space-y-3 relative overflow-hidden">
                <div class="w-10 h-10 rounded-lg border border-[#9BB0AC] bg-[#F0F4F3] flex items-center justify-center text-[#3B5C56]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3c-4 0-7 3-7 7 0 3.5 2.5 7.5 7 11 4.5-3.5 7-7.5 7-11 0-4-3-7-7-7z"/>
                        <path d="M12 7v13M9 10l3 3 3-3M9 14l3 3 3-3"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug pt-1">
                    Bahan Segar Setiap Hari
                </h3>
                <p class="text-[11.5px] text-gray-500 leading-relaxed relative z-10">
                    Selalu fresh setiap hari, karena rasa terbaik dimulai dari bahan berkualitas
                </p>
                <svg class="absolute -bottom-3 -right-2 w-24 h-24 text-gray-200/70 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 3c-4 0-7 3-7 7 0 3.5 2.5 7.5 7 11 4.5-3.5 7-7.5 7-11 0-4-3-7-7-7z"/>
                    <path d="M12 7v13M9 10l3 3 3-3"/>
                </svg>
            </div>

            <div class="bg-white rounded-[22px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-6 text-left flex flex-col justify-start space-y-3 relative overflow-hidden">
                <div class="w-10 h-10 rounded-lg border border-[#F3D179] bg-[#FEF9E7] flex items-center justify-center text-[#E6A817]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug pt-1">
                    Pesanan Cepat
                </h3>
                <p class="text-[11.5px] text-gray-500 leading-relaxed relative z-10">
                    Disiapkan dengan cepat tanpa mengorbankan kualitas dan cita rasa.
                </p>
                <svg class="absolute -bottom-3 -right-3 w-24 h-24 text-gray-200/70 pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2L4 14h7l-2 8 9-12h-7l2-8z"/>
                </svg>
            </div>

            <div class="bg-white rounded-[22px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-6 text-left flex flex-col justify-start space-y-3 relative overflow-hidden">
                <div class="w-10 h-10 rounded-lg border border-[#9BC0D9] bg-[#F0F6FA] flex items-center justify-center text-[#3B76A0]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                    </svg>
                </div>
                <h3 class="font-extrabold text-sm sm:text-[15px] text-gray-900 leading-snug pt-1">
                    Porsi Bikin Kenyang
                </h3>
                <p class="text-[11.5px] text-gray-500 leading-relaxed relative z-10">
                    Porsi pas dan mengenyangkan, cocok untuk menemani rasa lapar kapan saja.
                </p>
                <svg class="absolute -bottom-3 -right-2 w-24 h-24 text-gray-200/70 pointer-events-none" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                </svg>
            </div>

        </div>

    </section>

    <div class="w-full bg-[#F5B027] py-3.5 overflow-hidden select-none">
        <div class="animate-marquee whitespace-nowrap text-base sm:text-lg font-black text-[#1E2E2B] uppercase tracking-wider flex items-center"
             style="font-family: 'Titan One', 'Luckiest Guy', cursive;">
            @for($i = 0; $i < 12; $i++)
                <span class="mx-3 flex items-center gap-3">TOONBURGER <span class="text-[#D93829] text-xl leading-none">★</span></span>
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
                    <div class="bg-white rounded-[24px] border-[1.5px] border-black shadow-[5px_6px_0px_#6E7571] p-4 flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1">
                        <div>
                            <div class="w-full rounded-2xl overflow-hidden">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-auto object-contain block">
                            </div>

                            <div class="pt-3.5 pb-1">
                                <span class="text-[10px] font-bold text-[#E6A817] uppercase tracking-wider block">
                                    {{ $product->category_label ?? ($product->category->name ?? 'CHEESE BURGER') }}
                                </span>
                                <h3 class="font-extrabold text-[15px] text-gray-900 mt-0.5 leading-snug">
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
                                    onclick="quickAddToCart({{ $product->id }})"
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

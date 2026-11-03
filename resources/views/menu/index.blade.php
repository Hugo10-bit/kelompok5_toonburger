@extends('layouts.app')

@section('title', 'Semua Menu - Toon Burger')

@section('content')
<div class="space-y-0 pb-0">

    <!-- ═══════════════════════════════════════════════
         1. HERO BANNER (MENU PAGE - Sesuai Foto)
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
                            MAU MAKAN<br>APA HARI INI?
                        </h1>

                        <p class="text-xs sm:text-sm md:text-base text-white/90 leading-relaxed max-w-sm sm:max-w-md">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.
                        </p>

                        <!-- CTA Buttons: Pickup Order & Delivery Order -->
                        <div class="flex flex-wrap items-center gap-3.5 pt-2">
                            <a href="#semua-menu"
                               class="font-bold text-xs sm:text-sm px-6 py-2.5 rounded-xl border border-black/80 bg-[#f5a623] hover:bg-[#e0961f] text-black shadow-[2px_2px_0px_#000] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer">
                                Pickup Order
                            </a>
                            <a href="#semua-menu"
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

    <!-- ═══════════════════════════════════════════════
         2. CATALOG / MENU SECTION
         ═══════════════════════════════════════════════ -->
    <div id="semua-menu" class="retro-grid-bg pt-8 sm:pt-10 pb-10 sm:pb-14 select-none scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ═══════════════════════════════════════════════
                 HEADER: SEMUA MENU
                 ═══════════════════════════════════════════════ -->
            <div class="space-y-1.5 text-left pt-2 sm:pt-4 toon-reveal">
                <h2 class="font-brand text-3xl sm:text-4xl lg:text-[44px] text-[#224038] tracking-wide uppercase leading-tight"
                    style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                    SEMUA MENU
                </h2>
                <p class="text-xs sm:text-sm text-[#47665e] max-w-md leading-relaxed font-medium">
                    Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                </p>
            </div>

        <!-- ═══════════════════════════════════════════════
             2. CATEGORY FILTER PILLS (Matching Figma Mockup)
             ═══════════════════════════════════════════════ -->
        <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-2 pt-0.5 toon-reveal" style="transition-delay: 80ms;">
            <!-- "Semua" Pill -->
            @php
                $isAllActive = ($selectedCategory === 'all' || empty($selectedCategory));
            @endphp
            <a href="{{ route('menu', array_filter(['q' => $search, 'table' => $tableNum])) }}"
               class="{{ $isAllActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-4 sm:px-5 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold inline-flex items-center justify-center transition shrink-0 cursor-pointer">
                <span>Semua</span>
            </a>

            <!-- Individual Category Pills -->
            @foreach($categories as $category)
                @php
                    $isActive = ($selectedCategory === $category->slug);
                @endphp
                <a href="{{ route('menu', array_filter(['category' => $category->slug, 'q' => $search, 'table' => $tableNum])) }}"
                   class="{{ $isActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-4 sm:px-5 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold inline-flex items-center justify-center transition shrink-0 cursor-pointer">
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-12 text-center max-w-lg mx-auto space-y-4 toon-reveal">
                <div class="text-4xl">🍔</div>
                <h3 class="font-bold text-lg text-gray-900">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">Menu yang Anda cari tidak tersedia. Silakan cek menu favorit lainnya.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-[#27443E] hover:bg-[#1E3631] text-white text-xs font-bold px-5 py-2.5 rounded-lg transition shadow-xs">
                    Lihat Semua Menu
                </a>
            </div>
        @else
            <!-- ═══════════════════════════════════════════════
                 3. PRODUCT CARDS GRID (Matching Figma Mockup)
                 ═══════════════════════════════════════════════ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @php
                        $badge = $cardMetadata[$product->id]['badge'] ?? ($product->category->name ?? 'BURGER');
                        $bgColor = $cardMetadata[$product->id]['bg'] ?? '#FFC83B';
                    @endphp
                    <div class="bg-white rounded-[24px] sm:rounded-[26px] border-[1.8px] border-black shadow-[5px_6px_0px_#6E7571] p-4 sm:p-4.5 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200 toon-reveal"
                         style="transition-delay: {{ ($loop->index % 4) * 80 }}ms;">
                        <div onclick="openProductModal({{ $product->id }})" class="cursor-pointer">
                            <!-- Top Image Box: Vibrant Colored Background Matching Reference -->
                            <div class="w-full aspect-[1.32] rounded-[20px] overflow-hidden flex items-center justify-center p-3 relative"
                                 style="background-color: {{ $bgColor }};">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-contain drop-shadow-[0_8px_16px_rgba(0,0,0,0.18)] group-hover:scale-105 transition-transform duration-300 select-none">
                            </div>

                            <!-- Content: Category, Title, Description -->
                            <div class="pt-3 pb-1">
                                <span class="text-[10px] sm:text-[11px] font-bold text-[#D97706] uppercase tracking-wider block">
                                    {{ $badge }}
                                </span>
                                <h3 class="font-bold text-sm sm:text-base text-gray-900 mt-1 leading-snug group-hover:text-[#27443E] transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[10.5px] sm:text-[11.5px] text-gray-400 line-clamp-2 leading-relaxed mt-1">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Bottom Row: Price & Pesan Button -->
                        <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-2">
                            <span class="font-extrabold text-sm sm:text-base text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button type="button"
                                    onclick="openProductModal({{ $product->id }})"
                                    class="bg-[#27443E] hover:bg-[#1E3631] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-xs cursor-pointer">
                                Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ═══════════════════════════════════════════════
                 4. PAGINATION BAR
                 ═══════════════════════════════════════════════ -->
            <div class="pt-4 sm:pt-6 toon-reveal" style="transition-delay: 100ms;">
                {{ $products->links('vendor.pagination.toonburger') }}
            </div>
        @endif

    </div>
</div>
</div>
@endsection

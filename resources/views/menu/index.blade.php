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
            <div class="relative overflow-hidden w-full pt-28 sm:pt-36 lg:pt-40 min-h-[430px] sm:min-h-[520px] flex flex-col justify-between"
                 style="background-color: #385850;">

                <!-- Concentric / wavy retro background curves -->
                <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 500">
                    <path d="M-100,50 C200,20 400,120 700,70 C900,30 1100,100 1200,80" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,120 C200,90 400,190 700,140 C900,100 1100,170 1200,150" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,190 C200,160 400,260 700,210 C900,170 1100,240 1200,220" fill="none" stroke="#fff" stroke-width="1.5"/>
                    <path d="M-100,260 C200,230 400,330 700,280 C900,240 1100,310 1200,290" fill="none" stroke="#fff" stroke-width="1.5"/>
                </svg>

                <!-- Comic Sparkles Floating in Background (Coordinates matching reference) -->
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="top: 24%; left: 3%; animation-delay: 0s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="top: 42%; left: 52%; animation-delay: 0.7s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-5 h-auto"
                     style="bottom: 16%; right: 23%; animation-delay: 1.4s;">
                <img src="{{ asset('images/star-sparkle.png') }}"
                     alt="Sparkle"
                     class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto"
                     style="bottom: 12%; left: 40%; animation-delay: 2.1s;">

                <!-- Content Grid -->
                <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 items-center px-6 sm:px-10 lg:px-12 pt-4 sm:pt-6 pb-8">

                    <!-- Left: Headline + Subtitle + Buttons -->
                    <div class="lg:col-span-6 space-y-3 sm:space-y-4 pb-4 sm:pb-6 lg:pb-10 toon-reveal">
                        <h1 class="font-brand text-white uppercase leading-[0.95] drop-shadow-sm text-3xl sm:text-5xl lg:text-[52px] xl:text-[60px]"
                            style="font-family: 'Luckiest Guy', cursive, sans-serif;">
                            MAU MAKAN<br>APA HARI INI?
                        </h1>

                        <p class="text-xs sm:text-sm md:text-base text-white/90 leading-relaxed max-w-sm sm:max-w-md">
                            Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.
                        </p>

                        <!-- CTA Buttons: Pickup Order & Delivery Order -->
                        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3.5 pt-1 sm:pt-2">
                            <a href="#semua-menu"
                               class="min-h-[40px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-black/80 bg-[#f5a623] hover:bg-[#e0961f] text-black shadow-[2px_2px_0px_#000] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer">
                                Pickup Order
                            </a>
                            <a href="#semua-menu"
                               class="min-h-[40px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-white/80 bg-[#385850] hover:bg-[#2d4741] text-white transition cursor-pointer">
                                Delivery Order
                            </a>
                        </div>
                    </div>

                    <!-- Right: Burger + Speech Bubble Cluster (Burger kecil, posisi agak ke kanan, kalimat agak ke kanan atas sesuai foto) -->
                    <div class="lg:col-span-6 relative flex justify-center lg:justify-start items-center pb-5 sm:pb-6 lg:pb-8 pt-6 sm:pt-8 lg:pt-10 lg:pl-12 xl:pl-16 toon-reveal-right reveal-delay-150">
                        <div class="relative select-none">

                            <!-- Hero Double/Triple Cheeseburger (Kecil proporsional sesuai foto referensi) -->
                            <div class="relative z-10 flex justify-center items-end">
                                <!-- Small comic white accent lines above burger -->
                                <div class="absolute -top-3 left-[18%] flex gap-1 opacity-80 pointer-events-none z-20">
                                    <span class="w-1 h-2.5 bg-white rounded-full -rotate-12"></span>
                                    <span class="w-1 h-3 bg-white rounded-full"></span>
                                    <span class="w-1 h-2.5 bg-white rounded-full rotate-12"></span>
                                </div>

                                <img id="hero-burger-img"
                                     src="{{ asset('images/hero-burger.png') }}"
                                     alt="Very Cheese Burger"
                                     fetchpriority="high"
                                     loading="eager"
                                     decoding="sync"
                                     width="200"
                                     height="175"
                                     style="will-change: transform;"
                                     class="w-[132px] sm:w-[175px] md:w-[190px] lg:w-[200px] xl:w-[215px] h-auto object-contain cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105 active:scale-95 drop-shadow-[0_12px_24px_rgba(0,0,0,0.35)] select-none">
                            </div>

                            <!-- Starburst Comic Speech Bubble ("VERY CHEESE BURGER") - Terpisah di Kanan Atas (Tidak Menempel/Nyambung Burger) -->
                            <div class="absolute -top-10 sm:-top-16 md:-top-20 lg:-top-[86px] xl:-top-[92px] left-[58%] sm:left-[85%] md:left-[92%] lg:left-[98%] xl:left-[100%] z-20 pointer-events-auto cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                                <img id="hero-badge-img"
                                     src="{{ asset('images/very-cheese-badge.png') }}"
                                     alt="VERY CHEESE BURGER"
                                     fetchpriority="high"
                                     loading="eager"
                                     class="w-[112px] sm:w-[180px] md:w-[205px] lg:w-[225px] xl:w-[240px] max-w-full sm:max-w-none h-auto object-contain drop-shadow-md select-none">
                            </div>

                        </div>
                    </div>

                </div>

                <div class="w-full mt-auto">
                    <!-- Checkered Accent Line (3 baris kotak hitam-putih di dalam background hijau) -->
                    <div class="w-full relative z-20" style="height: 36px; background: repeating-conic-gradient(#385850 0% 25%, #ffffff 0% 50%) 0 0 / 24px 24px;"></div>

                    <!-- Dark Green Bottom Spacer (Bagian hijau di bawah garis kotak-kotak sebelum perbatasan cream) -->
                    <div class="w-full h-8 sm:h-9 lg:h-10"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. CATALOG / MENU SECTION
         ═══════════════════════════════════════════════ -->
    <div id="semua-menu" class="retro-grid-bg pt-6 sm:pt-10 pb-8 sm:pb-14 select-none scroll-mt-24">
        <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 space-y-5 sm:space-y-8">

            <!-- ═══════════════════════════════════════════════
                 HEADER: SEMUA MENU
                 ═══════════════════════════════════════════════ -->
            <div class="space-y-1 text-left pt-1 sm:pt-4 toon-reveal">
                <h2 class="font-brand text-2xl sm:text-4xl lg:text-[44px] text-[#224038] tracking-wide uppercase leading-tight"
                    style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                    SEMUA MENU
                </h2>
                <p class="text-[11.5px] sm:text-sm text-[#47665e] max-w-md leading-relaxed font-medium">
                    Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                </p>
            </div>

        <!-- ═══════════════════════════════════════════════
             2. CATEGORY FILTER PILLS (Matching Figma Mockup)
             ═══════════════════════════════════════════════ -->
        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-2 pt-0.5 toon-reveal scroll-smooth snap-x snap-mandatory touch-pan-x" style="transition-delay: 80ms; -webkit-overflow-scrolling: touch;">
            <!-- "Semua" Pill -->
            @php
                $isAllActive = ($selectedCategory === 'all' || empty($selectedCategory));
            @endphp
            <a href="{{ route('menu', array_filter(['q' => $search, 'table' => $tableNum])) }}"
               data-preserve-scroll
               class="{{ $isAllActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-3 sm:px-5 py-1.5 sm:py-2 rounded-full text-[11px] sm:text-sm font-medium inline-flex items-center justify-center transition shrink-0 cursor-pointer snap-start min-h-[34px] sm:min-h-[40px] active:scale-95">
                <span>Semua</span>
            </a>

            <!-- Individual Category Pills -->
            @foreach($categories as $category)
                @php
                    $isActive = ($selectedCategory === $category->slug);
                @endphp
                <a href="{{ route('menu', array_filter(['category' => $category->slug, 'q' => $search, 'table' => $tableNum])) }}"
                   data-preserve-scroll
                   class="{{ $isActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-3 sm:px-5 py-1.5 sm:py-2 rounded-full text-[11px] sm:text-sm font-medium inline-flex items-center justify-center transition shrink-0 cursor-pointer snap-start min-h-[34px] sm:min-h-[40px] active:scale-95">
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-[20px] sm:rounded-[24px] border-2 border-black shadow-[4px_4px_0px_#3d5d56] sm:shadow-[6px_6px_0px_#3d5d56] p-8 sm:p-12 text-center max-w-lg mx-auto space-y-3 sm:space-y-4 toon-reveal">
                <div class="text-3xl sm:text-4xl">🍔</div>
                <h3 class="font-bold text-base sm:text-lg text-gray-900">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">Menu yang Anda cari tidak tersedia. Silakan cek menu favorit lainnya.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-[#27443E] hover:bg-[#1E3631] text-white text-xs font-medium px-5 py-2.5 rounded-lg transition shadow-xs">
                    Lihat Semua Menu
                </a>
            </div>
        @else
            <!-- ═══════════════════════════════════════════════
                 3. PRODUCT CARDS GRID (Matching Figma Mockup)
                 ═══════════════════════════════════════════════ -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($products as $product)
                    @php
                        $categoryName = $product->category->name ?? ($cardMetadata[$product->id]['badge'] ?? 'BURGER');
                        $badge = strtoupper($categoryName);
                        $palettes = ['#FFC83B', '#FCE5D3', '#E51D1D', '#A4D477', '#BFE1FD', '#F67A24', '#D5C8F6', '#F5B8DC', '#FED7AA', '#F5C518', '#A7D79E', '#FCE5D3'];
                        $bgColor = $cardMetadata[$product->id]['bg'] ?? ($palettes[($loop->index) % count($palettes)] ?? '#FFC83B');
                    @endphp
                    @include('partials.product-card', [
                        'productId' => $product->id,
                        'image' => $product->image,
                        'badge' => $badge,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'bgColor' => $bgColor,
                        'revealClass' => 'toon-reveal',
                        'cardStyle' => 'transition-delay: ' . (($loop->index % 4) * 90) . 'ms;',
                    ])
                @endforeach
            </div>
        @endif

    </div>
</div>
</div>
@endsection

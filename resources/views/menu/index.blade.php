@extends('layouts.app')

@section('title', 'Semua Menu - Toon Burger')

@section('content')
<div class="space-y-0 pb-0">

    @include('partials.hero-banner', [
        'headline' => 'MAU MAKAN<br>APA HARI INI?',
        'headlineDesktopClass' => 'lg:text-[52px] xl:text-[60px]',
        'ctaHref' => '#semua-menu',
        'deliveryHref' => route('gofood'),
        'revealClass' => 'toon-reveal',
    ])

    <div id="semua-menu" class="retro-grid-bg pt-6 sm:pt-10 pb-8 sm:pb-14 select-none scroll-mt-24">
        <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 space-y-5 sm:space-y-8">

            @include('partials.store-closed-banner')

            <div class="space-y-1 text-left pt-1 sm:pt-4 toon-reveal">
                <h2 class="font-brand text-2xl sm:text-4xl lg:text-[44px] text-[#224038] tracking-wide uppercase leading-tight"
                    style="font-family: 'BBH Hegarty', cursive, sans-serif;">
                    SEMUA MENU
                </h2>
                <p class="text-[11.5px] sm:text-sm text-[#47665e] max-w-md leading-relaxed font-medium">
                    Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
                </p>
            </div>

        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-2 pt-0.5 toon-reveal scroll-smooth snap-x snap-mandatory touch-pan-x" style="transition-delay: 80ms; -webkit-overflow-scrolling: touch;">
            @php
                $isAllActive = ($selectedCategory === 'all' || empty($selectedCategory));
            @endphp
            <a href="{{ route('menu', array_filter(['q' => $search, 'table' => $tableNum])) }}"
               data-preserve-scroll
               class="{{ $isAllActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-3 sm:px-5 py-1.5 sm:py-2 rounded-full text-[11px] sm:text-sm font-medium inline-flex items-center justify-center transition shrink-0 cursor-pointer snap-start min-h-[34px] sm:min-h-[40px] active:scale-95">
                <span>Semua</span>
            </a>

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

        <div id="menu-results-container">
        @if($products->isEmpty() || request()->has('empty'))
            <div class="py-12 sm:py-20 text-center max-w-md mx-auto flex flex-col items-center justify-center toon-reveal">
                <img src="{{ asset('images/empty-menu.png') }}"
                     alt="Menu Tidak Ditemukan"
                     width="210"
                     height="190"
                     loading="lazy"
                     class="w-44 sm:w-52 h-auto mx-auto mb-5 object-contain">
                <h3 class="font-bold text-xl sm:text-2xl text-[#333333] dark:text-white tracking-tight">Menu Tidak Ditemukan.</h3>
                <p class="text-xs sm:text-sm text-[#7A7A7A] dark:text-gray-300 max-w-sm mx-auto mt-2 leading-relaxed">Tidak ada menu yang cocok dengan kata kunci tersebut. Periksa kembali ejaan atau cari menu lainnya.</p>
                <a href="{{ route('menu') }}" class="mt-5 inline-flex items-center justify-center bg-[#3F5E5A] hover:bg-[#324C48] text-white text-xs sm:text-[13px] font-semibold px-6 py-2.5 rounded-lg transition shadow-xs">
                    Lihat Semua Menu
                </a>
            </div>
        @else
            <div id="menu-products-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($products as $product)
                    @php
                        $categoryName = $product->category->name ?? ($cardMetadata[$product->id]['badge'] ?? 'BURGER');
                        $badge = strtoupper($categoryName);
                        $palettes = ['#FFC83B', '#FCE5D3', '#E51D1D', '#A4D477', '#BFE1FD', '#F67A24', '#D5C8F6', '#F5B8DC', '#FED7AA', '#F5C518', '#A7D79E', '#FCE5D3'];
                        $bgColor = $cardMetadata[$product->id]['bg'] ?? ($palettes[($loop->index) % count($palettes)] ?? '#FFC83B');
                    @endphp
                    @include('partials.product-card', [
                        'productId' => $product->id,
                        'image' => $product->image_url,
                        'imageUrl' => $product->image_url,
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
</div>
@endsection

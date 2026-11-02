@extends('layouts.app')

@section('title', 'Semua Menu - Toon Burger')

@section('content')
<div class="retro-grid-bg pt-4 sm:pt-6 pb-10 sm:pb-14 select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- ═══════════════════════════════════════════════
             1. HEADER: SEMUA MENU
             ═══════════════════════════════════════════════ -->
        <div class="space-y-1.5 text-left pt-2 sm:pt-4 toon-reveal">
            <h1 class="text-3xl sm:text-4xl lg:text-[44px] text-[#224038] tracking-wide uppercase leading-tight"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                SEMUA MENU
            </h1>
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
               class="{{ $isAllActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-4 sm:px-5 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold inline-flex items-center gap-2 transition shrink-0 cursor-pointer">
                <span>Semua</span>
                <span class="{{ $isAllActive ? 'text-white/80' : 'text-gray-500' }}">{{ $totalAllProducts ?? $products->total() }}</span>
            </a>

            <!-- Individual Category Pills -->
            @foreach($categories as $category)
                @php
                    $isActive = ($selectedCategory === $category->slug);
                    $catCount = $category->products_count;
                @endphp
                <a href="{{ route('menu', array_filter(['category' => $category->slug, 'q' => $search, 'table' => $tableNum])) }}"
                   class="{{ $isActive ? 'bg-[#27443E] text-white border-[1.5px] border-black shadow-[2px_3px_0px_#1B302B]' : 'bg-white text-gray-800 border-[1.5px] border-black/80 hover:bg-gray-50 shadow-[1px_2px_0px_rgba(0,0,0,0.15)]' }} px-4 sm:px-5 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold inline-flex items-center gap-2 transition shrink-0 cursor-pointer">
                    <span>{{ $category->name }}</span>
                    <span class="{{ $isActive ? 'text-white/80' : 'text-gray-500' }}">{{ $catCount }}</span>
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
@endsection

@extends('layouts.app')

@section('title', 'Semua Menu - Toon Burger')

@section('content')
<div class="retro-grid-bg min-h-screen pt-4 sm:pt-6 pb-12 select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- ═══════════════════════════════════════════════
             1. HEADER: SEMUA MENU (Sesuai Foto media_1792999772746.png)
             ═══════════════════════════════════════════════ -->
        <div class="space-y-1.5 text-left pt-2 sm:pt-4">
            <h1 class="font-brand text-3xl sm:text-4xl lg:text-[44px] text-[#224038] tracking-wide uppercase leading-tight"
                style="font-family: 'Luckiest Guy', cursive;">
                SEMUA MENU
            </h1>
            <p class="text-xs sm:text-sm text-[#47665e] max-w-md leading-relaxed font-medium">
                Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.
            </p>
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-12 text-center max-w-lg mx-auto space-y-4">
                <div class="text-4xl">🍔</div>
                <h3 class="font-bold text-lg text-gray-900">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">Menu yang Anda cari tidak tersedia. Silakan cek menu favorit lainnya.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-5 py-2.5 rounded-lg transition shadow-2xs">
                    Lihat Semua Menu
                </a>
            </div>
        @else
            <!-- ═══════════════════════════════════════════════
                 2. 12 PRODUCT CARDS GRID (4x3 Sesuai Foto)
                 ═══════════════════════════════════════════════ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @php
                        $badge = $cardMetadata[$product->id]['badge'] ?? ($product->category->name ?? 'CHEESE BURGER');
                        $bgColor = $cardMetadata[$product->id]['bg'] ?? '#F5C518';
                    @endphp
                    <div class="bg-white rounded-[24px] border-2 border-black shadow-[6px_6px_0px_#3d5d56] p-4 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-200">
                        <div>
                            <!-- Top Image Box: Seamless Full-Bleed Product Image Matching Reference -->
                            <div class="w-full aspect-[1.45] rounded-2xl overflow-hidden bg-gray-100">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>

                            <!-- Content: Category, Title, Description -->
                            <div class="pt-3 pb-1">
                                <span class="text-[11px] font-bold text-[#D97706] uppercase tracking-wide">
                                    {{ $badge }}
                                </span>
                                <h3 class="font-bold text-base text-gray-900 mt-0.5 leading-snug">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-1">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Bottom Row: Price & Pesan Button -->
                        <div class="pt-3 flex items-center justify-between border-t border-gray-100 mt-3">
                            <span class="font-black text-base text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button type="button"
                                    onclick="quickAddToCart({{ $product->id }})"
                                    class="bg-[#3b5a53] hover:bg-[#2d4741] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition active:scale-95 shadow-2xs cursor-pointer">
                                Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ═══════════════════════════════════════════════
                 3. PAGINATION BAR (Sesuai Foto)
                 ═══════════════════════════════════════════════ -->
            <div class="flex items-center justify-center gap-2 pt-6 sm:pt-8 select-none">
                <span class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-[#3b5a53] text-white font-bold flex items-center justify-center text-sm shadow-xs border border-[#3b5a53]">
                    1
                </span>
                <a href="{{ route('menu', ['page' => 2]) }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-white text-gray-700 font-semibold flex items-center justify-center text-sm border border-gray-200 hover:border-gray-400 transition cursor-pointer">
                    2
                </a>
                <a href="{{ route('menu', ['page' => 3]) }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-white text-gray-700 font-semibold flex items-center justify-center text-sm border border-gray-200 hover:border-gray-400 transition cursor-pointer">
                    3
                </a>
                <a href="{{ route('menu', ['page' => 4]) }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-white text-gray-700 font-semibold flex items-center justify-center text-sm border border-gray-200 hover:border-gray-400 transition cursor-pointer">
                    4
                </a>
                <span class="w-10 h-10 sm:w-11 sm:h-11 text-gray-400 font-bold flex items-center justify-center text-sm">
                    ...
                </span>
                <a href="{{ route('menu', ['page' => 6]) }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-white text-gray-700 font-semibold flex items-center justify-center text-sm border border-gray-200 hover:border-gray-400 transition cursor-pointer">
                    6
                </a>
                <a href="{{ route('menu', ['page' => 2]) }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-white text-gray-700 font-bold flex items-center justify-center text-sm border border-gray-200 hover:border-gray-400 transition cursor-pointer">
                    &rarr;
                </a>
            </div>
        @endif

    </div>

    <!-- ═══════════════════════════════════════════════
         4. BOTTOM PERSPECTIVE FLOOR GRID (Sesuai Foto)
         ═══════════════════════════════════════════════ -->
    <div class="relative w-full h-44 sm:h-64 overflow-hidden pointer-events-none mt-6 sm:mt-10" style="perspective: 350px;">
        <div class="absolute inset-0 w-full h-[240%]"
             style="transform: rotateX(60deg); transform-origin: top center; background-size: 44px 44px; background-image: linear-gradient(to right, rgba(59, 92, 86, 0.12) 1px, transparent 1px), linear-gradient(to bottom, rgba(59, 92, 86, 0.12) 1px, transparent 1px); mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 80%); -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 80%);">
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Katalog Menu & Pesan Online - Toon Burger')

@section('content')
<div class="space-y-8 lg:space-y-12 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO HEADER (KATALOG MENU) — Full Size Edge-to-Edge
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden -mt-[105px] sm:-mt-[112px]">
        <div class="w-full">
            <div class="relative overflow-hidden w-full pt-32 sm:pt-36 lg:pt-40 pb-14 sm:pb-18"
                 style="background-color: #3b6e64; min-height: 480px;">

                <!-- Partikel Bintang Komik Asli -->
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-6 h-auto"
                     style="top: 25%; left: 8%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 h-auto"
                     style="bottom: 25%; left: 45%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-5 h-auto"
                     style="top: 22%; right: 14%;">
                <img src="{{ asset('images/star-sparkle.png') }}" alt="Sparkle"
                     class="absolute pointer-events-none select-none z-10 w-4 h-auto"
                     style="bottom: 20%; right: 28%;">

                <!-- Content Grid (Max-W-7xl for neat alignment) -->
                <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex flex-col md:flex-row md:items-center justify-between gap-8 pt-4">

                    <div class="space-y-4 max-w-xl text-left">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.08] text-white"
                            style="font-family: 'Nunito', 'Arial Black', sans-serif;">
                            Pilihan Menu <br class="hidden sm:inline">
                            <span class="text-yellow-300">Lezat &amp; Segar</span>
                        </h1>

                        <p class="text-sm sm:text-base text-white/85 leading-relaxed font-normal">
                            Pilih burger favorit Anda, sesuaikan porsi &amp; topping, lalu masukkan ke keranjang untuk proses pemesanan cepat!
                        </p>
                    </div>



                </div>

                <!-- Checkered Bottom Border -->
                <div class="absolute bottom-0 left-0 w-full" style="height: 24px; background: repeating-conic-gradient(#1a3d36 0% 25%, #f0ede6 0% 50%) 0 0 / 24px 24px;"></div>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════
         3. CATEGORIES FILTER PILLS
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sticky top-18 z-30 bg-[#FAF1E1]/95 backdrop-blur-md py-3 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="flex items-center gap-2.5 overflow-x-auto hide-scrollbar pb-1">
                <a href="{{ route('menu', ['category' => 'all', 'q' => request('q')]) }}"
                   class="px-5 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-2 whitespace-nowrap transition shadow-xs {{ $selectedCategory === 'all' ? 'bg-bites-yellow text-bites-dark shadow-md scale-102 ring-2 ring-amber-400' : 'bg-white text-gray-700 hover:bg-gray-100 border border-[#E6DEC8]' }}">
                    <svg class="w-4 h-4 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10a8 8 0 0116 0v1H4v-1zm0 4h16m-16 3h16a2 2 0 012 2H2a2 2 0 012-2z"/></svg>
                    <span>Semua Menu</span>
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('menu', ['category' => $cat->slug, 'q' => request('q')]) }}"
                       class="px-5 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-1.5 whitespace-nowrap transition shadow-xs {{ $selectedCategory === $cat->slug ? 'bg-bites-yellow text-bites-dark shadow-md scale-102 ring-2 ring-amber-400' : 'bg-white text-gray-700 hover:bg-gray-100 border border-[#E6DEC8]' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         4. PRODUCTS GRID
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex items-center justify-between text-xs text-gray-600 font-semibold px-1">
            <div>
                Menampilkan <span class="font-extrabold text-gray-900 font-mono">{{ $products->count() }}</span> pilihan menu
                @if(request('q'))
                    untuk pencarian "<span class="text-bites-red font-bold">{{ request('q') }}</span>"
                @endif
            </div>

            @if(request('q') || $selectedCategory !== 'all')
                <a href="{{ route('menu') }}" class="text-bites-red hover:underline font-bold">
                    &times; Reset Filter
                </a>
            @endif
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-[#E6DEC8] shadow-xs max-w-lg mx-auto space-y-3">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-gray-900">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('menu') }}" class="inline-block mt-2 bg-bites-yellow text-bites-dark font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-xs hover:bg-bites-yellow-dark transition">
                    Lihat Semua Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-3xl border border-[#E6DEC8] hover:border-bites-orange/60 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group hover:-translate-y-1">

                        <!-- Product Image & Badges -->
                        <div class="relative bg-gray-100 aspect-[4/3] overflow-hidden">
                            <img src="{{ asset($product->image ?: 'images/burger-bg.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-108 transition duration-500">

                            @if($product->is_featured)
                                <span class="absolute top-3 left-3 bg-bites-red text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    ★ Rekomendasi
                                </span>
                            @endif

                            @if($product->original_price && $product->original_price > $product->price)
                                @php
                                    $disc = round((($product->original_price - $product->price) / $product->original_price) * 100);
                                @endphp
                                <span class="absolute top-3 right-3 bg-yellow-400 text-yellow-950 text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm font-mono">
                                    -{{ $disc }}%
                                </span>
                            @endif

                            <div class="absolute bottom-2 left-3 text-[11px] font-semibold text-white">
                                <span class="bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded-md font-mono">
                                    {{ $product->calories ?: 450 }} kcal
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
                @endforeach
            </div>
        @endif

    </section>


</div>
@endsection

@extends('layouts.app')

@section('title', 'Katalog Menu & Pesan Online - Toon Burger')

@section('content')
<div class="space-y-8 lg:space-y-12 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. TAKEAWAY ONLY NOTIFICATION
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="bg-amber-50 border border-amber-300 rounded-3xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-extrabold text-amber-950">Layanan Khusus Take Away &amp; Online Delivery</h4>
                    <p class="text-[11px] sm:text-xs text-amber-800">Toon Burger Banjarbaru hanya menyediakan pesanan bungkus bawa pulang (Takeaway) dan pesan antar online. Tidak menyediakan makan di tempat (Dine-In).</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0 self-start sm:self-auto">
                <span class="bg-amber-200/80 text-amber-950 text-[11px] font-bold px-3 py-1 rounded-full">Khusus Takeaway &amp; Delivery</span>
                <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer" class="bg-[#EE2737] hover:bg-[#D61B2B] text-white text-xs font-black px-3.5 py-1.5 rounded-full transition shadow-xs flex items-center gap-1.5 active:scale-95">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    <span>Order via GoFood</span>
                    <span class="bg-white/25 text-[10px] px-1.5 py-0.2 rounded-full">4.9 ★</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. CATALOG HEADER BANNER
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div class="bg-gradient-to-r from-amber-500 via-bites-orange to-red-600 rounded-[32px] sm:rounded-[40px] p-6 sm:p-10 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">

            <div class="relative z-10 space-y-2 max-w-xl">
                <div class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md px-3.5 py-1 rounded-full text-[11px] font-bold text-yellow-200 border border-white/20">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>KATALOG RESMI TOON BURGER</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    Pilihan Menu Lezat & Segar
                </h1>
                <p class="text-xs sm:text-sm text-white/90 leading-relaxed font-normal">
                    Pilih burger favorit Anda, sesuaikan porsi & topping, lalu masukkan ke keranjang untuk proses pemesanan cepat!
                </p>
            </div>

            <!-- Search Form in Header -->
            <div class="relative z-10 w-full md:w-80">
                <form action="{{ route('menu') }}" method="GET">
                    @if($selectedCategory !== 'all')
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari burger, kentang, saus..."
                               class="w-full bg-white text-xs text-gray-900 placeholder-gray-400 border-0 rounded-2xl pl-10 pr-4 py-3 shadow-lg focus:ring-2 focus:ring-yellow-300 outline-none transition font-medium">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Background Ambient Glow -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
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

                            <div class="absolute bottom-2 left-3 right-3 flex items-center justify-between text-[11px] font-semibold text-white">
                                <span class="bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded-md font-mono">
                                    {{ $product->calories ?: 450 }} kcal
                                </span>
                                <span class="bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded-md font-mono">
                                    {{ $product->prep_time_minutes ?: 8 }} menit
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

    <!-- ═══════════════════════════════════════════════
         5. VOUCHER & TABLE SERVICE REMINDER BANNER
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-[#E6DEC8] p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xs">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm sm:text-base font-black text-gray-900">Gunakan Kupon Promo "TOONBURGER50" di Keranjang</h4>
                    <p class="text-xs text-gray-600 mt-0.5">Dapatkan diskon potongan belanja saat memesan melalui website ini.</p>
                </div>
            </div>
            <button onclick="toggleCartDrawer()" class="bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark text-xs font-black px-6 py-3 rounded-xl transition shadow-xs active:scale-95 shrink-0">
                Buka Keranjang Pesanan &rarr;
            </button>
        </div>
    </section>

</div>
@endsection

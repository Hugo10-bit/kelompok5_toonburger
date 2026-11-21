@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.admin')

@section('title', 'Data Produk - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-3xl border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-4 sm:p-9 lg:p-10 flex-1 flex flex-col">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 sm:mb-7">
        <div>
            <h1 class="text-xl sm:text-[36px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="prod_title">Halaman Data Produk</h1>
            <p class="text-xs sm:text-[16px] text-gray-400 dark:text-[#D4D4D4] mt-1.5" data-i18n="prod_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 relative flex-wrap sm:flex-nowrap">
            <div class="relative">
                <button type="button" onclick="toggleProdFilterMenu()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-3.5 sm:px-4 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12m-9 6h6"></path>
                    </svg>
                    <span data-i18n="btn_filter">Filter</span>
                </button>
                <div id="prod-filter-menu" class="hidden absolute left-0 mt-2 w-52 max-w-[calc(100vw-3rem)] bg-white dark:bg-[#2B2B2B] rounded-2xl shadow-2xl border border-gray-100 dark:border-[#555555] py-2 z-40 animate-modal-pop">
                    <button type="button" onclick="applyCategoryFilter('all')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-[#3A3A3A] font-medium transition cursor-pointer" data-i18n="filter_all_cat">Semua Kategori</button>
                    @foreach($categories as $cat)
                        <button type="button" data-category="{{ strtolower($cat->name) }}" onclick="applyCategoryFilter(this.dataset.category)" class="w-full text-left px-4 py-2.5 text-sm text-gray-600 dark:text-[#D4D4D4] hover:bg-gray-100 dark:hover:bg-[#3A3A3A] transition cursor-pointer">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>

            <button type="button" onclick="toggleProductSort()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-3.5 sm:px-4 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span data-i18n="btn_sort">Sortir</span>
            </button>

            <button type="button" onclick="openAddModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-4 sm:px-5 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm cursor-pointer" data-i18n="btn_add_prod">
                Tambahkan
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-auto-dismiss mb-5 p-4 bg-red-50 dark:bg-[#4A2626] border border-red-200 dark:border-red-900/60 text-[#DE3B28] dark:text-[#FCA5A5] text-xs font-semibold rounded-2xl flex justify-between items-center shadow-xs" role="alert">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </span>
            <button type="button" onclick="this.closest('.alert-auto-dismiss')?.remove()" class="text-base font-medium p-1 cursor-pointer" aria-label="Tutup">&times;</button>
        </div>
    @endif

    @php
        $previewEmpty = request()->has('empty');
        $hasProducts = !$previewEmpty && ($products->isNotEmpty());
        $thumbBgColors = [
            'bg-[#F9D649]',
            'bg-[#F28B30]',
            'bg-[#E53935]',
            'bg-[#AED581]',
            'bg-[#F48FB1]',
            'bg-[#FFD54F]',
            'bg-[#FFE082]',
            'bg-[#FBC02D]',
            'bg-[#FBC02D]',
        ];
    @endphp

    @if(!$hasProducts)
        <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4">
            <img src="{{ asset('images/empty-product.png') }}"
                 alt="Belum ada Produk"
                 width="184"
                 height="168"
                 loading="lazy"
                 class="w-36 sm:w-44 h-auto mx-auto mb-4 object-contain">
            <h3 class="text-xl font-bold text-[#262626] dark:text-white" data-i18n="prod_empty_title">Belum ada Produk</h3>
            <p class="text-xs sm:text-sm text-[#6B7280] dark:text-[#C4C9D0] mt-1.5 max-w-sm leading-relaxed" data-i18n="prod_empty_desc">
                Saat ini belum ada produk yang terdaftar. Tambahkan produk pertama Anda sekarang untuk mulai berjualan.
            </p>
            <div class="flex items-center justify-center gap-3 mt-6">
                <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-[#555555] bg-white dark:bg-[#333333] hover:bg-gray-50 dark:hover:bg-[#3D3D3D] text-xs font-semibold text-gray-700 dark:text-[#E5E5E5] transition shadow-xs cursor-pointer" data-i18n="btn_refresh">
                    Refresh Halaman
                </button>
                <button type="button" onclick="openAddModal()" class="px-5 py-2.5 rounded-xl bg-[#415C58] hover:bg-[#344B48] text-white text-xs font-semibold transition shadow-xs cursor-pointer" data-i18n="btn_add_product">
                    Tambahkan Produk
                </button>
            </div>
        </div>
    @else
    <!-- Mobile Product Cards (Readable image + text on narrow phone viewports) -->
    <div id="product-mobile-list" class="md:hidden space-y-3">
        @forelse($products as $idx => $prod)
            @php
                $catName = $prod->category->name ?? 'Lainnya';
                $bgClass = $thumbBgColors[$idx % count($thumbBgColors)];
                $prodEditPayload = [
                    'id' => $prod->id,
                    'name' => $prod->name,
                    'category_id' => $prod->category_id,
                    'price' => $prod->price,
                    'description' => $prod->description,
                    'is_available' => (bool) $prod->is_available,
                    'is_popular' => (bool) $prod->is_featured,
                ];
            @endphp
            <div class="product-mobile-card rounded-2xl border border-gray-200/90 dark:border-[#4A4A4A] bg-[#FAFAFB] dark:bg-[#383838] p-3.5 shadow-2xs space-y-3"
                 data-name="{{ strtolower($prod->name) }}"
                 data-category="{{ strtolower($catName) }}"
                 data-index="{{ $idx }}">
                <div class="flex items-start gap-3.5">
                    <div class="w-16 h-16 rounded-xl {{ $bgClass }} flex items-center justify-center overflow-hidden shrink-0 p-1.5">
                        @if($prod->image)
                            <img src="{{ $prod->image_url }}"
                                 width="64"
                                 height="64"
                                 loading="lazy"
                                 decoding="async"
                                 class="product-thumb-img w-full h-full object-contain"
                                 alt="{{ $prod->name }}">
                        @else
                            <svg class="w-7 h-7 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18a8 8 0 00-18 0zm0 3h18v2H3v-2zm1 4h16a2 2 0 01-2 2H6a2 2 0 01-2-2z"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 space-y-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-1.5 min-w-0">
                                <h3 class="font-bold text-gray-900 dark:text-white text-sm leading-snug break-words">{{ $prod->name }}</h3>
                                @if($prod->is_featured)
                                    <span class="shrink-0 inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200/80 dark:border-amber-400/30 whitespace-nowrap">
                                        <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.9 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l7.1-1.01L12 2z"/></svg>
                                        <span>Best Seller</span>
                                    </span>
                                @endif
                            </div>
                            <span class="shrink-0 text-[10.5px] font-semibold px-2 py-0.5 rounded-full bg-gray-100 dark:bg-[#4A4A4A] text-gray-700 dark:text-[#E5E5E5]">
                                {{ $catName }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-[#BDBDBD] leading-relaxed line-clamp-2 break-words">
                            {{ $prod->description }}
                        </p>
                        <div class="font-extrabold text-sm text-gray-900 dark:text-white pt-0.5">
                            <span data-i18n="currency">Rp</span> {{ number_format($prod->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-2 pt-2.5 border-t border-gray-100 dark:border-[#4A4A4A]">
                    <form action="{{ route('admin.products.toggle', $prod->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-2 text-xs font-semibold text-gray-700 dark:text-[#E5E5E5] bg-gray-50 dark:bg-[#2C2C2C] border border-gray-200 dark:border-[#4F4F4F] px-3 py-1.5 min-h-[36px] rounded-xl cursor-pointer">
                            <span class="w-2.5 h-2.5 rounded-full {{ $prod->is_available ? 'bg-[#689F38]' : 'bg-[#E53935]' }} dark:ring-1 dark:ring-white"></span>
                            <span data-i18n="{{ $prod->is_available ? 'st_avail' : 'st_empty' }}">{{ $prod->is_available ? 'Tersedia' : 'Habis' }}</span>
                        </button>
                    </form>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="openEditModal({{ json_encode($prodEditPayload) }}, this)" class="text-[#757575] dark:text-[#D4D4D4] hover:text-gray-900 dark:hover:text-white bg-gray-50 dark:bg-[#2C2C2C] border border-gray-200 dark:border-[#4F4F4F] rounded-xl min-w-[38px] min-h-[38px] inline-flex items-center justify-center transition-colors cursor-pointer" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                <path d="M15 5l4 4"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="openDeleteModal('{{ route('admin.products.delete', $prod->id) }}', 'menu {{ addslashes($prod->name) }}')" class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 bg-red-50/60 dark:bg-[#4A2626] border border-red-200/80 dark:border-red-900/50 rounded-xl min-w-[38px] min-h-[38px] inline-flex items-center justify-center transition-colors cursor-pointer" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M3 6h18"></path>
                                <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-10 text-center text-sm text-gray-400 border border-dashed border-gray-200 dark:border-[#4A4A4A] rounded-2xl" data-i18n="prod_empty">
                Belum ada produk.
            </div>
        @endforelse
    </div>

    <div class="hidden md:block border border-gray-200 dark:border-[#555555] rounded-[22px] overflow-hidden bg-white dark:bg-[#2B2B2B] flex-1">
        <div class="overflow-auto max-h-[calc(100vh-240px)] min-h-[300px]">
            <table class="w-full text-center border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-[#EEEEEE] dark:bg-[#9E9E9E] text-gray-700 dark:text-[#222222] text-sm font-medium border-b border-gray-200 dark:border-[#757575]">
                        <th class="py-4 px-6 text-center" data-i18n="col_prod_name">Menu</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_category">Kategori</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_price">Harga</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_status">Status</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="product-table-body" class="divide-y divide-gray-200/80 dark:divide-[#444444] text-sm">
                    @forelse($products as $idx => $prod)
                    @php
                        $catName = $prod->category->name ?? 'Lainnya';
                        $bgClass = $thumbBgColors[$idx % count($thumbBgColors)];
                        $prodEditPayload = [
                            'id' => $prod->id,
                            'name' => $prod->name,
                            'category_id' => $prod->category_id,
                            'price' => $prod->price,
                            'description' => $prod->description,
                            'is_available' => (bool) $prod->is_available,
                            'is_popular' => (bool) $prod->is_featured,
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-[#353535] transition-colors product-row" data-name="{{ strtolower($prod->name) }}" data-category="{{ strtolower($catName) }}" data-index="{{ $idx }}">
                        <td class="py-4 px-6 text-left">
                            <div class="flex items-center gap-4 pl-2 sm:pl-4">
                                <div class="w-12 h-12 rounded-xl {{ $bgClass }} flex items-center justify-center overflow-hidden shrink-0 p-1">
                                    @if($prod->image)
                                        <img src="{{ $prod->image_url }}" width="48" height="48" loading="lazy" decoding="async" class="product-thumb-img w-full h-full object-contain" alt="{{ $prod->name }}">
                                    @else
                                        <svg class="w-6 h-6 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18a8 8 0 00-18 0zm0 3h18v2H3v-2zm1 4h16a2 2 0 01-2 2H6a2 2 0 01-2-2z"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0 max-w-[280px] lg:max-w-[340px]">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="font-bold text-gray-900 dark:text-white text-sm leading-snug truncate" title="{{ $prod->name }}">{{ $prod->name }}</span>
                                        @if($prod->is_featured)
                                            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200/80 dark:border-amber-400/30 whitespace-nowrap">
                                                <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.9 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l7.1-1.01L12 2z"/></svg>
                                                <span>Best Seller</span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-[#BDBDBD] mt-0.5 truncate">{{ $prod->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-gray-700 dark:text-[#D4D4D4] font-normal">
                            {{ $catName }}
                        </td>
                        <td class="py-4 px-5 text-gray-800 dark:text-white font-medium whitespace-nowrap">
                            <span data-i18n="currency">Rp</span> {{ number_format($prod->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-5 whitespace-nowrap">
                            <form action="{{ route('admin.products.toggle', $prod->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-[#E5E5E5] hover:opacity-80 cursor-pointer" title="Klik untuk ubah status">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $prod->is_available ? 'bg-[#689F38]' : 'bg-[#E53935]' }} dark:ring-1 dark:ring-white"></span>
                                    <span data-i18n="{{ $prod->is_available ? 'st_avail' : 'st_empty' }}">{{ $prod->is_available ? 'Tersedia' : 'Habis' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-5">
                                <button type="button" onclick="openEditModal({{ json_encode($prodEditPayload) }}, this)" class="text-[#757575] dark:text-[#D4D4D4] hover:text-gray-900 dark:hover:text-white transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        <path d="M15 5l4 4"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.products.delete', $prod->id) }}', 'menu {{ addslashes($prod->name) }}')" class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Hapus">
                                    <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M3 6h18"></path>
                                        <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400" data-i18n="prod_empty">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div id="productModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-3 sm:p-4">
        <div class="bg-white dark:bg-[#2B2B2B] rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl relative max-h-[90vh] overflow-y-auto border border-gray-100 dark:border-[#4A4A4A]">
            <div class="flex items-center justify-between gap-2 mb-4">
                <h3 id="modalTitle" class="text-base sm:text-lg font-bold text-gray-900 dark:text-white" data-i18n="mod_prod_add">Tambah Produk Baru</h3>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] text-gray-700 dark:text-gray-200 flex items-center justify-center font-semibold text-lg cursor-pointer shrink-0 transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="productForm" action="{{ route('admin.products.store') }}" data-store-url="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="image_data" id="prod_image_data" value="">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_name">Nama Produk</label>
                        <input type="text" name="name" id="prod_name" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Very Cheese Burger">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="col_category">Kategori</label>
                            <select name="category_id" id="prod_cat" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_price">Harga (Rp)</label>
                            <div class="relative">
                                <input type="number" name="price" id="prod_price" required min="1000" max="1000000" step="1" class="w-full border border-gray-200 dark:border-[#555555] rounded-lg pl-3 pr-10 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="33000">
                                <div class="absolute inset-y-1 right-1 flex flex-col w-6 rounded-md overflow-hidden border border-gray-200 dark:border-[#555555] bg-gray-100/90 dark:bg-[#3A3A3A]">
                                    <button type="button" id="prod_price_up" tabindex="-1" aria-label="Tambah harga 500" class="flex-1 flex items-center justify-center text-gray-600 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#4A4A4A] active:bg-gray-300 dark:active:bg-[#555555] transition cursor-pointer border-b border-gray-200 dark:border-[#555555]">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M6 3L10 8H2L6 3Z"/></svg>
                                    </button>
                                    <button type="button" id="prod_price_down" tabindex="-1" aria-label="Kurangi harga 500" class="flex-1 flex items-center justify-center text-gray-600 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#4A4A4A] active:bg-gray-300 dark:active:bg-[#555555] transition cursor-pointer">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M6 9L2 4H10L6 9Z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <span class="text-[10.5px] text-gray-400 dark:text-[#A0A0A0] mt-1 block">Min. Rp 1.000 &mdash; Maks. Rp 1.000.000</span>
                        </div>
                    </div>

                    <div>
                        <label for="prod_image_input" class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_img">Gambar Produk</label>
                        <div id="prod_image_preview_wrap" class="hidden mb-2.5 flex items-center gap-3">
                            <img id="prod_image_preview" src="" alt="Preview produk" class="w-16 h-16 rounded-xl object-contain bg-gray-100 dark:bg-[#383838] border border-gray-200 dark:border-[#525252] p-1 shrink-0">
                            <span class="text-[11px] text-gray-500 dark:text-[#BDBDBD]">Preview foto saat ini / foto yang dipilih</span>
                        </div>
                        <input type="file" id="prod_image_input" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="w-full text-xs text-gray-500 dark:text-[#D4D4D4] file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 dark:file:bg-[#3C3C3C] file:text-gray-700 dark:file:text-white hover:file:bg-gray-200 cursor-pointer">
                        <span class="text-[10.5px] text-gray-400 dark:text-[#A0A0A0] mt-1 block" data-i18n="prod_img_hint">Format: JPG atau PNG (maks. 5 MB)</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_desc">Deskripsi</label>
                        <textarea name="description" id="prod_desc" rows="2" class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Tulis deskripsi lezat menu Toon Burger..."></textarea>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 sm:gap-6 pt-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_available" id="prod_avail" value="1" checked class="rounded border-gray-300 text-[#415C58] focus:ring-[#415C58]">
                            <span class="ml-2 text-xs font-bold text-gray-700 dark:text-[#E0E0E0]" data-i18n="lbl_prod_avail">Tersedia (Stok Ada)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_popular" id="prod_pop" value="1" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <span class="ml-2 text-xs font-bold text-gray-700 dark:text-[#E0E0E0]" data-i18n="lbl_prod_pop">Best Seller</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-[#4A4A4A]">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-600 dark:text-white bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg text-xs font-medium text-white bg-[#415C58] hover:bg-[#344B48] transition-colors cursor-pointer" data-i18n="btn_save_prod">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

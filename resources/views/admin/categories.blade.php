@extends('layouts.admin')

@section('title', 'Data Kategori - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-3xl border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-4 sm:p-9 lg:p-10 flex-1 flex flex-col">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 sm:mb-7">
        <div>
            <h1 class="text-xl sm:text-[36px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="cat_title">Halaman Kategori Produk</h1>
            <p class="text-xs sm:text-[16px] text-gray-400 dark:text-[#D4D4D4] mt-1.5" data-i18n="cat_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
            <button type="button" onclick="toggleCategorySort()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-3.5 sm:px-4 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span data-i18n="btn_sort">Sortir</span>
            </button>

            <button type="button" onclick="openAddCatModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-4 sm:px-5 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm cursor-pointer" data-i18n="btn_add_cat">
                Tambahkan
            </button>
        </div>
    </div>

    @php
        $previewEmpty = request()->has('empty');
        $hasCategories = !$previewEmpty && ($categories->isNotEmpty());
    @endphp

    @if(!$hasCategories)
        <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4">
            <img src="{{ asset('images/empty-product.png') }}"
                 alt="Belum Ada Kategori"
                 width="184"
                 height="168"
                 loading="lazy"
                 class="w-36 sm:w-44 h-auto mx-auto mb-4 object-contain">
            <h3 class="text-xl font-bold text-[#262626] dark:text-white" data-i18n="cat_empty_title">Belum Ada Kategori</h3>
            <p class="text-xs sm:text-sm text-[#6B7280] dark:text-[#C4C9D0] mt-1.5 max-w-sm leading-relaxed" data-i18n="cat_empty_desc">
                Yuk, kelompokkan menu usahamu dengan lebih gampang lewat fitur kategori.
            </p>
            <div class="flex items-center justify-center gap-3 mt-6">
                <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-[#555555] bg-white dark:bg-[#333333] hover:bg-gray-50 dark:hover:bg-[#3D3D3D] text-xs font-semibold text-gray-700 dark:text-[#E5E5E5] transition shadow-xs cursor-pointer" data-i18n="btn_refresh">
                    Refresh Halaman
                </button>
                <button type="button" onclick="openAddCatModal()" class="px-5 py-2.5 rounded-xl bg-[#415C58] hover:bg-[#344B48] text-white text-xs font-semibold transition shadow-xs cursor-pointer" data-i18n="btn_add_cat">
                    Tambahkan Kategori
                </button>
            </div>
        </div>
    @else
    <div class="border border-gray-200 dark:border-[#555555] rounded-[20px] sm:rounded-[22px] overflow-hidden bg-white dark:bg-[#2B2B2B] flex-1">
        <div class="overflow-x-auto md:overflow-auto md:max-h-[calc(100vh-240px)] md:min-h-[300px]">
            <table class="w-full text-center border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-[#EEEEEE] dark:bg-[#9E9E9E] text-gray-700 dark:text-[#222222] text-xs sm:text-sm font-medium border-b border-gray-200 dark:border-[#757575]">
                        <th class="py-3.5 px-3 sm:py-4 sm:px-6 text-center w-16 sm:w-1/4" data-i18n="col_no">No.</th>
                        <th class="py-3.5 px-3 sm:py-4 sm:px-6 text-center" data-i18n="col_category">Kategori</th>
                        <th class="py-3.5 px-3 sm:py-4 sm:px-6 text-center w-24 sm:w-1/4" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="category-table-body" class="divide-y divide-gray-200/80 dark:divide-[#444444] text-xs sm:text-sm">
                    @forelse($categories as $index => $cat)
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-[#353535] transition-colors category-row" data-name="{{ strtolower($cat->name) }}" data-index="{{ $index }}">
                        <td class="py-4 px-3 sm:py-5 sm:px-6 font-bold text-gray-800 dark:text-white category-num">
                            {{ $index + 1 }}.
                        </td>
                        <td class="py-4 px-3 sm:py-5 sm:px-6 text-gray-700 dark:text-[#E5E5E5] font-normal break-words">
                            {{ $cat->name }}
                        </td>
                        <td class="py-4 px-3 sm:py-5 sm:px-6">
                            <div class="flex items-center justify-center gap-2 sm:gap-5">
                                <button type="button" onclick="openEditCatModal({{ json_encode($cat) }})" class="text-[#757575] dark:text-[#D4D4D4] hover:text-gray-900 dark:hover:text-white transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        <path d="M15 5l4 4"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.categories.delete', $cat->id) }}', 'kategori {{ addslashes($cat->name) }}')" class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Hapus">
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
                        <td colspan="3" class="py-8 text-center text-gray-400" data-i18n="cat_empty">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div id="catModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-[#2B2B2B] rounded-2xl max-w-sm w-full p-6 shadow-xl relative border border-gray-100 dark:border-[#4A4A4A]">
            <h3 id="catModalTitle" class="text-lg font-bold text-gray-900 dark:text-white mb-4" data-i18n="mod_cat_add">Tambah Kategori</h3>

            <form id="catForm" action="{{ route('admin.categories.store') }}" data-store-url="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="catFormMethod" value="POST">

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-2" data-i18n="lbl_cat_name">Nama Kategori</label>
                    <input type="text" name="name" id="cat_name" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Cheese Burger">
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-[#4A4A4A]">
                    <button type="button" onclick="closeCatModal()" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-600 dark:text-white bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg text-xs font-medium text-white bg-[#415C58] hover:bg-[#344B48] transition-colors cursor-pointer" data-i18n="btn_save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Data Produk - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-6 sm:p-9 lg:p-10 flex-1 flex flex-col">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
        <div>
            <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="prod_title">Halaman Data Produk</h1>
            <p class="text-sm sm:text-[15px] text-gray-400 dark:text-[#D4D4D4] mt-1.5" data-i18n="prod_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-3 relative">
            <div class="relative">
                <button type="button" onclick="toggleProdFilterMenu()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-4 py-2.5 min-h-[42px] rounded-xl transition-colors text-sm inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12m-9 6h6"></path>
                    </svg>
                    <span data-i18n="btn_filter">Filter</span>
                </button>
                <div id="prod-filter-menu" class="hidden absolute right-0 mt-1.5 w-48 bg-white dark:bg-[#2B2B2B] rounded-xl shadow-lg border border-gray-100 dark:border-[#555555] py-1.5 z-30">
                    <button type="button" onclick="applyCategoryFilter('all')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-[#3A3A3A] font-medium cursor-pointer" data-i18n="filter_all_cat">Semua Kategori</button>
                    @foreach($categories as $cat)
                        <button type="button" onclick="applyCategoryFilter('{{ strtolower($cat->name) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-600 dark:text-[#D4D4D4] hover:bg-gray-50 dark:hover:bg-[#3A3A3A] cursor-pointer">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>

            <button type="button" onclick="toggleProductSort()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-4 py-2.5 min-h-[42px] rounded-xl transition-colors text-sm inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span data-i18n="btn_sort">Sortir</span>
            </button>

            <button type="button" onclick="openAddModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-5 py-2.5 min-h-[42px] rounded-xl transition-colors text-sm cursor-pointer" data-i18n="btn_add_prod">
                Tambahkan
            </button>
        </div>
    </div>

    <div class="border border-gray-200 dark:border-[#555555] rounded-[22px] overflow-hidden bg-white dark:bg-[#2B2B2B] flex-1">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-[#EEEEEE] dark:bg-[#9E9E9E] text-gray-700 dark:text-[#222222] text-sm font-medium border-b border-gray-200 dark:border-[#757575]">
                        <th class="py-4 px-6 text-center" data-i18n="col_prod_name">Menu</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_category">Kategori</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_price">Harga</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_calories">kalori</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_status">Status</th>
                        <th class="py-4 px-5 text-center" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="product-table-body" class="divide-y divide-gray-200/80 dark:divide-[#444444] text-sm">
                    @php
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
                    @forelse($products as $idx => $prod)
                    @php
                        $catName = $prod->category->name ?? 'Lainnya';
                        $bgClass = $thumbBgColors[$idx % count($thumbBgColors)];
                    @endphp
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-[#353535] transition-colors product-row" data-name="{{ strtolower($prod->name) }}" data-category="{{ strtolower($catName) }}" data-index="{{ $idx }}">
                        <td class="py-4 px-6 text-left">
                            <div class="flex items-center gap-4 pl-2 sm:pl-4">
                                <div class="w-12 h-12 rounded-xl {{ $bgClass }} flex items-center justify-center overflow-hidden shrink-0 p-1">
                                    @if($prod->image)
                                        <img src="{{ str_starts_with($prod->image, 'http') ? $prod->image : asset($prod->image) }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-contain" alt="{{ $prod->name }}">
                                    @else
                                        <svg class="w-6 h-6 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18a8 8 0 00-18 0zm0 3h18v2H3v-2zm1 4h16a2 2 0 01-2 2H6a2 2 0 01-2-2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white text-sm leading-snug">{{ $prod->name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-[#BDBDBD] mt-0.5 max-w-[260px] truncate">{{ $prod->description ?: 'Burger dengan patty daging yang juicy,' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-gray-700 dark:text-[#D4D4D4] font-normal">
                            {{ $catName }}
                        </td>
                        <td class="py-4 px-5 text-gray-800 dark:text-white font-medium whitespace-nowrap">
                            <span data-i18n="currency">Rp</span> {{ number_format($prod->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-5 text-gray-700 dark:text-[#D4D4D4] whitespace-nowrap">
                            {{ $prod->calories ?? 300 }} kcal
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
                                <button type="button" onclick="openEditModal({{ json_encode($prod) }})" class="text-[#757575] dark:text-[#D4D4D4] hover:text-gray-900 dark:hover:text-white transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        <path d="M15 5l4 4"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.products.delete', $prod->id) }}')" class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Hapus">
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
                        <td colspan="6" class="py-8 text-center text-gray-400" data-i18n="prod_empty">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="productModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-[#2B2B2B] rounded-2xl max-w-lg w-full p-6 shadow-xl relative max-h-[90vh] overflow-y-auto border border-gray-100 dark:border-[#4A4A4A]">
            <h3 id="modalTitle" class="text-lg font-bold text-gray-900 dark:text-white mb-4" data-i18n="mod_prod_add">Tambah Produk Baru</h3>

            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_name">Nama Produk</label>
                        <input type="text" name="name" id="prod_name" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Very Cheese Burger">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
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
                            <input type="number" name="price" id="prod_price" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="33000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_cal">Kalori (Kcal)</label>
                            <input type="number" name="calories" id="prod_cal" class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_img">Gambar Produk</label>
                            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp,image/gif" class="w-full text-xs text-gray-500 dark:text-[#D4D4D4] file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 dark:file:bg-[#3C3C3C] file:text-gray-700 dark:file:text-white hover:file:bg-gray-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-1" data-i18n="lbl_prod_desc">Deskripsi</label>
                        <textarea name="description" id="prod_desc" rows="2" class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Burger dengan patty daging yang juicy,"></textarea>
                    </div>

                    <div class="flex items-center gap-6 pt-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_available" id="prod_avail" value="1" checked class="rounded border-gray-300 text-[#415C58] focus:ring-[#415C58]">
                            <span class="ml-2 text-xs font-bold text-gray-700 dark:text-[#E0E0E0]" data-i18n="lbl_prod_avail">Tersedia (Stok Ada)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_popular" id="prod_pop" value="1" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <span class="ml-2 text-xs font-bold text-gray-700 dark:text-[#E0E0E0]" data-i18n="lbl_prod_pop">Menu Terpopuler</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-[#4A4A4A]">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-600 dark:text-white bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg text-xs font-bold text-white bg-[#415C58] hover:bg-[#344B48] transition-colors cursor-pointer" data-i18n="btn_save_prod">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('productModal');
            const form = document.getElementById('productForm');
            const title = document.getElementById('modalTitle');
            const methodInput = document.getElementById('formMethod');
            let prodSortAsc = null;

            window.toggleProdFilterMenu = function () {
                const menu = document.getElementById('prod-filter-menu');
                if (menu) menu.classList.toggle('hidden');
            };

            window.applyCategoryFilter = function (cat) {
                const rows = document.querySelectorAll('#product-table-body .product-row');
                rows.forEach(row => {
                    if (cat === 'all' || row.getAttribute('data-category') === cat) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                const menu = document.getElementById('prod-filter-menu');
                if (menu) menu.classList.add('hidden');
            };

            window.toggleProductSort = function () {
                const tbody = document.getElementById('product-table-body');
                if (!tbody) return;
                const rows = Array.from(tbody.querySelectorAll('.product-row'));
                prodSortAsc = prodSortAsc === null ? true : !prodSortAsc;
                rows.sort((a, b) => {
                    const nameA = a.getAttribute('data-name') || '';
                    const nameB = b.getAttribute('data-name') || '';
                    return prodSortAsc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                });
                rows.forEach(r => tbody.appendChild(r));
            };

            window.openAddModal = function () {
                if (!modal || !form || !title || !methodInput) return;
                const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
                title.innerText = isEn ? 'Add New Product' : 'Tambah Produk Baru';
                form.action = "{{ route('admin.products.store') }}";
                methodInput.value = 'POST';
                form.reset();
                const availEl = document.getElementById('prod_avail');
                if (availEl) availEl.checked = true;
                modal.classList.remove('hidden');
            };

            window.openEditModal = function (product) {
                if (!modal || !form || !title || !methodInput) return;
                const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
                title.innerText = (isEn ? 'Edit Product: ' : 'Edit Produk: ') + product.name;
                form.action = `/admin/products/${product.id}`;
                methodInput.value = 'PUT';
                document.getElementById('prod_name').value = product.name;
                document.getElementById('prod_cat').value = product.category_id;
                document.getElementById('prod_price').value = product.price;
                document.getElementById('prod_cal').value = product.calories || '';
                document.getElementById('prod_desc').value = product.description || '';
                document.getElementById('prod_avail').checked = product.is_available == 1;
                document.getElementById('prod_pop').checked = product.is_popular == 1;
                modal.classList.remove('hidden');
            };

            window.closeModal = function () {
                if (modal) modal.classList.add('hidden');
            };

            if (window._tbProdFilterClickHandler) {
                document.removeEventListener('click', window._tbProdFilterClickHandler);
            }
            window._tbProdFilterClickHandler = function (e) {
                const menu = document.getElementById('prod-filter-menu');
                if (menu && menu.parentElement && !menu.parentElement.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            };
            document.addEventListener('click', window._tbProdFilterClickHandler);
        })();
    </script>
</div>
@endsection

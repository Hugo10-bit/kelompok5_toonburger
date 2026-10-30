@extends('layouts.admin')

@section('title', 'Data Produk - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-8 flex-1">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-[28px] font-bold text-[#333333] tracking-tight" data-i18n="prod_title">Halaman Data Produk</h1>
            <p class="text-xs text-gray-400 mt-1" data-i18n="prod_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-2.5 relative">
            <div class="relative">
                <button type="button" onclick="toggleProdFilterMenu()" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-medium px-3.5 py-2 min-h-[36px] rounded-lg transition-colors text-xs inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12m-9 6h6"></path>
                    </svg>
                    <span>Filter</span>
                </button>
                <div id="prod-filter-menu" class="hidden absolute right-0 mt-1.5 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-30">
                    <button type="button" onclick="applyCategoryFilter('all')" class="w-full text-left px-3.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50 font-medium cursor-pointer">Semua Kategori</button>
                    @foreach($categories as $cat)
                        <button type="button" onclick="applyCategoryFilter('{{ strtolower($cat->name) }}')" class="w-full text-left px-3.5 py-1.5 text-xs text-gray-600 hover:bg-gray-50 cursor-pointer">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>

            <button type="button" onclick="toggleProductSort()" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-medium px-3.5 py-2 min-h-[36px] rounded-lg transition-colors text-xs inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span>Sortir</span>
            </button>

            <button type="button" onclick="openAddModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-4 py-2 min-h-[36px] rounded-lg transition-colors text-xs cursor-pointer" data-i18n="btn_add_prod">
                Tambahkan
            </button>
        </div>
    </div>

    <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-[#EEEEEE] text-gray-700 text-xs font-medium border-b border-gray-200">
                        <th class="py-3.5 px-5 text-center" data-i18n="col_prod_name">Menu</th>
                        <th class="py-3.5 px-4 text-center" data-i18n="col_category">Kategori</th>
                        <th class="py-3.5 px-4 text-center" data-i18n="col_price">Harga</th>
                        <th class="py-3.5 px-4 text-center">kalori</th>
                        <th class="py-3.5 px-4 text-center" data-i18n="col_status">Status</th>
                        <th class="py-3.5 px-4 text-center" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="product-table-body" class="divide-y divide-gray-200/80 text-xs">
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
                    <tr class="hover:bg-gray-50/60 transition-colors product-row" data-name="{{ strtolower($prod->name) }}" data-category="{{ strtolower($catName) }}" data-index="{{ $idx }}">
                        <td class="py-3.5 px-5 text-left">
                            <div class="flex items-center gap-3.5 pl-2 sm:pl-4">
                                <div class="w-10 h-10 rounded-lg {{ $bgClass }} flex items-center justify-center overflow-hidden shrink-0 p-1">
                                    @if($prod->image)
                                        <img src="{{ str_starts_with($prod->image, 'http') ? $prod->image : asset($prod->image) }}" class="w-full h-full object-contain" alt="{{ $prod->name }}">
                                    @else
                                        <svg class="w-5 h-5 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18a8 8 0 00-18 0zm0 3h18v2H3v-2zm1 4h16a2 2 0 01-2 2H6a2 2 0 01-2-2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-xs leading-snug">{{ $prod->name }}</div>
                                    <div class="text-[10.5px] text-gray-400 mt-0.5 max-w-[220px] truncate">{{ $prod->description ?: 'Burger dengan patty daging yang juicy,' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-gray-700 font-normal">
                            {{ $catName }}
                        </td>
                        <td class="py-3.5 px-4 text-gray-800 font-medium whitespace-nowrap">
                            Rp {{ number_format($prod->price, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap">
                            {{ $prod->calories ?? 300 }} kcal
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <form action="{{ route('admin.products.toggle', $prod->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-700 hover:opacity-80 cursor-pointer" title="Klik untuk ubah status">
                                    <span class="w-2 h-2 rounded-full {{ $prod->is_available ? 'bg-[#689F38]' : 'bg-[#E53935]' }}"></span>
                                    <span data-i18n="{{ $prod->is_available ? 'st_avail' : 'st_empty' }}">{{ $prod->is_available ? 'Tersedia' : 'Habis' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" onclick="openEditModal({{ json_encode($prod) }})" class="text-gray-500 hover:text-gray-800 transition-colors p-1 cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[#E53935] hover:text-red-700 transition-colors p-1 cursor-pointer" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="productModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl relative max-h-[90vh] overflow-y-auto">
            <h3 id="modalTitle" class="text-lg font-bold text-gray-900 mb-4" data-i18n="mod_prod_add">Tambah Produk Baru</h3>

            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="lbl_prod_name">Nama Produk</label>
                        <input type="text" name="name" id="prod_name" required class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Very Cheese Burger">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="col_category">Kategori</label>
                            <select name="category_id" id="prod_cat" required class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="lbl_prod_price">Harga (Rp)</label>
                            <input type="number" name="price" id="prod_price" required class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="33000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="lbl_prod_cal">Kalori (Kcal)</label>
                            <input type="number" name="calories" id="prod_cal" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="lbl_prod_img">Gambar Produk</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1" data-i18n="lbl_prod_desc">Deskripsi</label>
                        <textarea name="description" id="prod_desc" rows="2" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Burger dengan patty daging yang juicy,"></textarea>
                    </div>

                    <div class="flex items-center gap-6 pt-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_available" id="prod_avail" value="1" checked class="rounded border-gray-300 text-[#415C58] focus:ring-[#415C58]">
                            <span class="ml-2 text-xs font-bold text-gray-700" data-i18n="lbl_prod_avail">Tersedia (Stok Ada)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_popular" id="prod_pop" value="1" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <span class="ml-2 text-xs font-bold text-gray-700" data-i18n="lbl_prod_pop">Menu Terpopuler</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg text-xs font-bold text-white bg-[#415C58] hover:bg-[#344B48] transition-colors cursor-pointer" data-i18n="btn_save_prod">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');
        let prodSortAsc = null;

        function toggleProdFilterMenu() {
            const menu = document.getElementById('prod-filter-menu');
            if (menu) menu.classList.toggle('hidden');
        }

        function applyCategoryFilter(cat) {
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
        }

        function toggleProductSort() {
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
        }

        function openAddModal() {
            const lang = localStorage.getItem('tb_lang') || 'ID';
            title.innerText = lang === 'EN' ? 'Add New Product' : 'Tambah Produk Baru';
            form.action = "{{ route('admin.products.store') }}";
            methodInput.value = 'POST';
            form.reset();
            document.getElementById('prod_avail').checked = true;
            modal.classList.remove('hidden');
        }

        function openEditModal(product) {
            const lang = localStorage.getItem('tb_lang') || 'ID';
            title.innerText = (lang === 'EN' ? 'Edit Product: ' : 'Edit Produk: ') + product.name;
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
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('prod-filter-menu');
            if (menu && !menu.parentElement.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</div>
@endsection

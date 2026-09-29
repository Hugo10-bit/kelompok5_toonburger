@extends('layouts.admin')

@section('title', 'Kelola Data Produk - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <!-- Header Section (Sesuai Mockup Foto Board 2) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Data Produk</h1>
            <p class="text-xs text-gray-400 mt-1">Kelola daftar menu dan produk Toon Burger</p>
        </div>

        <!-- Action Controls: Search, Category Filter, and + Tambah Produk -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-48 sm:w-56">
                <input type="text" id="product-table-search" onkeyup="searchProductTable()" placeholder="Cari nama menu..." class="w-full pl-8 pr-3 py-2 text-xs bg-[#F4F5F7] border border-gray-200/70 rounded-full focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800 placeholder-gray-400">
                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Category Select Filter -->
            <div class="relative">
                <select id="category-filter-select" onchange="filterCategory(this.value)" class="text-xs bg-[#F4F5F7] border border-gray-200/70 rounded-full px-4 py-2 font-medium text-gray-700 focus:outline-none focus:border-[#385A56] cursor-pointer transition">
                    <option value="all">Semua Kategori ({{ $products->count() }})</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- + Tambah Produk Button (Dark Slate Teal Pill Sesuai Mockup) -->
            <button type="button" onclick="openAddProductModal()" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Produk</span>
            </button>
        </div>
    </div>

    <!-- Products Table (Sesuai Mockup Foto Board 2) -->
    <div class="border border-gray-200/80 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="product-table">
                <thead class="bg-[#F0F4F3] text-gray-600 font-bold border-b border-gray-200/70 text-[11px] tracking-wide">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Menu / Produk</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Harga</th>
                        <th class="py-3.5 px-4">Stok</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="product-table-body">
                    @forelse($products as $idx => $prod)
                        <tr class="product-row hover:bg-gray-50/70 transition" data-category-id="{{ $prod->category_id }}" data-name="{{ strtolower($prod->name) }}">
                            <!-- No -->
                            <td class="py-3.5 px-4 text-center font-semibold text-gray-400 text-xs">
                                {{ $idx + 1 }}
                            </td>

                            <!-- Foto & Menu Name -->
                            <td class="py-3.5 px-4 flex items-center gap-3">
                                <img src="{{ asset($prod->image ?: 'images/burger-bg.jpg') }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-xl object-cover border border-gray-200 flex-shrink-0 shadow-2xs">
                                <div>
                                    <div class="font-extrabold text-gray-900 text-xs leading-tight">
                                        {{ $prod->name }}
                                    </div>
                                    <p class="text-gray-400 text-[11px] line-clamp-1 max-w-xs mt-0.5">
                                        {{ $prod->description ?: ($prod->category ? $prod->category->name : 'Toon Burger Specialty') }}
                                    </p>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4 font-medium text-gray-700">
                                {{ $prod->category ? $prod->category->name : 'Uncategorized' }}
                            </td>

                            <!-- Harga -->
                            <td class="py-3.5 px-4 font-bold text-gray-900 text-xs">
                                Rp {{ number_format($prod->price, 0, ',', '.') }}
                            </td>

                            <!-- Stok -->
                            <td class="py-3.5 px-4 text-gray-600 font-medium">
                                {{ $prod->calories ? ($prod->calories > 100 ? 50 : $prod->calories) : 50 }} Porsi
                            </td>

                            <!-- Status -->
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.products.toggle', $prod->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1 rounded-full text-[11px] font-bold transition inline-flex items-center gap-1.5 {{ $prod->is_available ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-rose-100 text-rose-800 hover:bg-rose-200' }}" title="Klik untuk ubah ketersediaan">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $prod->is_available ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span>{{ $prod->is_available ? 'Tersedia' : 'Habis' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi (Dua Icon Buttons: Edit & Delete Sesuai Mockup Foto) -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit Button (Pencil Icon) -->
                                    <button type="button" onclick="openEditProductModal({{ json_encode($prod) }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition active:scale-95" title="Edit Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <!-- Delete Button (Red Trash Icon) -->
                                    <button type="button" onclick="openDeleteModal('{{ route('admin.products.delete', $prod->id) }}', 'menu {{ $prod->name }}')" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-[#DE3B28] flex items-center justify-center transition active:scale-95" title="Hapus Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="7" class="py-12 text-center text-gray-400">
                                <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="font-bold text-sm text-gray-700 mb-1">Belum Ada Menu</div>
                                <p class="text-xs">Klik tombol <strong>+ Tambah Produk</strong> untuk memasukkan menu baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ═══ MODAL TAMBAH PRODUK (PERSIS MOCKUP FOTO BOARD 3) ═══ -->
<div id="add-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-8 shadow-2xl space-y-5 border border-gray-100 animate-modal-pop">
        <div class="pb-2">
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Tambah Produk Baru</h3>
            <p class="text-xs text-gray-400 mt-1">Lengkapi informasi menu Toon Burger yang akan ditambahkan.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <!-- Nama Menu -->
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Nama Produk</label>
                <input type="text" name="name" required placeholder="Nama Produk Baru" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <!-- Kategori & Harga Jual -->
            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Harga (Rp)</label>
                    <input type="number" name="price" required placeholder="0" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-bold focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>
            </div>

            <!-- Stok & Foto Menu -->
            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Stok (Porsi)</label>
                    <input type="number" name="calories" placeholder="50" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Upload Foto</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-2.5 focus:outline-none text-[11px] text-gray-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                </div>
            </div>

            <!-- Deskripsi Menu -->
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Deskripsi menu Toon Burger..." class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800 resize-none"></textarea>
            </div>

            <!-- Submit Button & Batal (Sesuai Mockup Board 3) -->
            <div class="pt-2 space-y-3 text-center">
                <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-3 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                    Tambah Produk
                </button>
                <button type="button" onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600 font-semibold text-xs transition inline-block">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ MODAL EDIT PRODUK (PERSIS MOCKUP FOTO BOARD 4) ═══ -->
<div id="edit-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-8 shadow-2xl space-y-5 border border-gray-100 animate-modal-pop">
        <div class="pb-2">
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Edit Menu</h3>
            <p class="text-xs text-gray-400 mt-1">Perbarui rincian, harga, atau foto menu Toon Burger.</p>
        </div>

        <form id="edit-product-form" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <!-- Nama Menu -->
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Nama Produk</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <!-- Kategori & Harga Jual -->
            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id" id="edit_category_id" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Harga (Rp)</label>
                    <input type="number" name="price" id="edit_price" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-bold focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>
            </div>

            <!-- Stok & Foto Menu -->
            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Stok (Porsi)</label>
                    <input type="number" name="calories" id="edit_calories" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Ganti Foto Menu</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-2.5 focus:outline-none text-[11px] text-gray-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                </div>
            </div>

            <!-- Deskripsi Menu -->
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" id="edit_description" rows="3" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800 resize-none"></textarea>
            </div>

            <!-- Submit Button & Batal (Sesuai Mockup Board 4) -->
            <div class="pt-2 space-y-3 text-center">
                <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-3 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditProductModal()" class="text-gray-400 hover:text-gray-600 font-semibold text-xs transition inline-block">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddProductModal() {
        document.getElementById('add-product-modal').classList.remove('hidden');
    }

    function closeAddProductModal() {
        document.getElementById('add-product-modal').classList.add('hidden');
    }

    function openEditProductModal(product) {
        document.getElementById('edit-product-form').action = `/admin/products/${product.id}/update`;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_price').value = parseInt(product.price);
        document.getElementById('edit_calories').value = product.calories || 50;
        document.getElementById('edit_description').value = product.description || '';

        document.getElementById('edit-product-modal').classList.remove('hidden');
    }

    function closeEditProductModal() {
        document.getElementById('edit-product-modal').classList.add('hidden');
    }

    function filterCategory(categoryId) {
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            if (categoryId === 'all' || row.getAttribute('data-category-id') === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function searchProductTable() {
        const query = document.getElementById('product-table-search').value.toLowerCase();
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            if (!query || name.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection

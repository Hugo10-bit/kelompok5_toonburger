@extends('layouts.admin')

@section('title', 'Halaman Data Produk - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Halaman Data Produk</h1>
            <p class="text-xs text-gray-500 mt-1">Tambah menu baru, kelola harga, kategori, dan pantau status ketersediaan stok.</p>
        </div>
        <button onclick="document.getElementById('add-product-modal').classList.remove('hidden')" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2 self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Tambah Menu Baru</span>
        </button>
    </div>

    <!-- Category Filter Bar & Quick Stats -->
    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-[#E6DEC8] text-xs">
        <div class="flex flex-wrap items-center gap-2" id="category-filter-chips">
            <button onclick="filterCategory('all')" class="category-chip px-3.5 py-1.5 rounded-full font-bold transition bg-toon-granite text-white shadow-xs" data-category="all">
                Semua Menu ({{ $products->count() }})
            </button>
            @foreach($categories as $cat)
                <button onclick="filterCategory('{{ $cat->id }}')" class="category-chip px-3.5 py-1.5 rounded-full font-bold transition bg-toon-cream hover:bg-toon-wheat text-toon-granite border border-toon-granite/15" data-category="{{ $cat->id }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
        <div class="w-full sm:w-64 relative">
            <input type="text" id="product-table-search" onkeyup="searchProductTable()" placeholder="Cari nama menu..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-toon-granite focus:bg-white">
            <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    <!-- Products Table (SESUAI MOCKUP FOTO) -->
    <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="product-table">
                <thead class="bg-toon-cream/50 text-gray-500 font-bold border-b border-[#E6DEC8] uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Foto & Menu</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Harga Jual</th>
                        <th class="p-4">Kalori / Waktu</th>
                        <th class="p-4">Status Stok</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="product-table-body">
                    @forelse($products as $idx => $prod)
                        <tr class="product-row hover:bg-toon-cream/20 transition" data-category-id="{{ $prod->category_id }}" data-name="{{ strtolower($prod->name) }}">
                            <td class="p-4 text-center font-bold text-gray-400">
                                {{ $idx + 1 }}
                            </td>

                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ asset($prod->image ?: 'images/burger-bg.jpg') }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-2xl object-cover border border-[#E6DEC8] flex-shrink-0 shadow-2xs">
                                <div>
                                    <div class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                                        <span>{{ $prod->name }}</span>
                                        @if($prod->is_featured)
                                            <span class="bg-toon-wheat text-toon-granite text-[9px] font-extrabold px-2 py-0.5 rounded-full border border-[#E0C89F]">Favorit</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-400 text-[11px] line-clamp-1 max-w-xs">{{ $prod->description ?: '-' }}</p>
                                </div>
                            </td>

                            <td class="p-4 font-semibold text-gray-700">
                                <span class="bg-toon-cream px-2.5 py-1 rounded-full text-toon-granite font-bold text-[11px] border border-toon-granite/15">
                                    {{ $prod->category ? $prod->category->name : 'Uncategorized' }}
                                </span>
                            </td>

                            <td class="p-4">
                                <div class="font-bold text-gray-900 text-sm font-mono-code">Rp {{ number_format($prod->price, 0, ',', '.') }}</div>
                                @if($prod->original_price)
                                    <div class="text-[11px] text-gray-400 line-through font-mono-code">Rp {{ number_format($prod->original_price, 0, ',', '.') }}</div>
                                @endif
                            </td>

                            <td class="p-4 text-gray-500 font-medium text-[11px]">
                                <div>{{ $prod->calories ? $prod->calories . ' kcal' : '-' }}</div>
                                <div class="text-gray-400">{{ $prod->prep_time_minutes ? $prod->prep_time_minutes . ' menit' : '-' }}</div>
                            </td>

                            <td class="p-4">
                                <form action="{{ route('admin.products.toggle', $prod->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-extrabold transition flex items-center gap-1.5 {{ $prod->is_available ? 'bg-toon-granite text-white hover:bg-toon-granite-dark' : 'bg-red-100 text-toon-rust hover:bg-red-200' }}" title="Klik untuk ubah status ketersediaan">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $prod->is_available ? 'bg-emerald-300' : 'bg-toon-rust' }}"></span>
                                        <span>{{ $prod->is_available ? 'Tersedia' : 'Habis' }}</span>
                                    </button>
                                </form>
                            </td>

                            <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                <button type="button" onclick="openEditProductModal({{ json_encode($prod) }})" class="bg-toon-cream hover:bg-toon-wheat text-toon-granite font-bold px-3 py-1.5 rounded-full transition text-xs inline-flex items-center gap-1 border border-toon-granite/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ $prod->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-toon-rust font-bold px-3 py-1.5 rounded-full transition text-xs inline-flex items-center gap-1 border border-red-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="7" class="p-12 text-center text-gray-400">
                                <div class="w-12 h-12 rounded-full bg-toon-cream text-toon-granite flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="font-bold text-sm text-gray-700 mb-1">Belum Ada Menu</div>
                                <p class="text-xs">Klik tombol <strong>+ Tambah Menu Baru</strong> untuk memasukkan menu Toon Burger pertama.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ═══ 1. MODAL TAMBAH MENU BARU (SESUAI MOCKUP FOTO) ═══ -->
<div id="add-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto border border-[#E6DEC8]">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-extrabold text-lg text-gray-900">Tambah Menu Baru</h3>
                <p class="text-xs text-gray-400">Lengkapi data produk untuk menambahkan menu Toon Burger baru.</p>
            </div>
            <button onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1">Nama Menu:</label>
                <input type="text" name="name" required placeholder="Contoh: Toon Double Beef Burger" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Kategori:</label>
                    <select name="category_id" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-semibold focus:outline-none focus:border-toon-granite focus:bg-white transition">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Harga Jual (Rp):</label>
                    <input type="number" name="price" required placeholder="45000" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-mono-code font-bold focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Harga Coret / Promo (Opsional):</label>
                    <input type="number" name="original_price" placeholder="55000" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-mono-code focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Foto Menu:</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2 focus:outline-none text-[11px]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Estimasi Kalori (kcal):</label>
                    <input type="number" name="calories" placeholder="580" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Waktu Masak (Menit):</label>
                    <input type="number" name="prep_time_minutes" placeholder="10" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Deskripsi Menu:</label>
                <textarea name="description" rows="2" placeholder="Komposisi patty daging sapi pilihan, saus keju spesial, dan bun wijen lembut khas Toon Burger..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_featured" id="add_is_featured" value="1" class="rounded text-toon-granite focus:ring-toon-granite w-4 h-4">
                <label for="add_is_featured" class="font-bold text-gray-800 cursor-pointer">Tandai sebagai Menu Rekomendasi / Favorit</label>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-full font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 px-6 rounded-full shadow-sm transition text-xs">
                    Simpan Menu Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ 2. MODAL EDIT MENU ═══ -->
<div id="edit-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto border border-[#E6DEC8]">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-extrabold text-lg text-gray-900">Edit Menu Makanan</h3>
                <p class="text-xs text-gray-400">Perbarui rincian, harga, atau foto menu Toon Burger.</p>
            </div>
            <button onclick="document.getElementById('edit-product-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form id="edit-product-form" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1">Nama Menu:</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Kategori:</label>
                    <select name="category_id" id="edit_category_id" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-semibold focus:outline-none focus:border-toon-granite focus:bg-white transition">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Harga Jual (Rp):</label>
                    <input type="number" name="price" id="edit_price" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-mono-code font-bold focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Harga Coret / Promo (Opsional):</label>
                    <input type="number" name="original_price" id="edit_original_price" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-mono-code focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Ganti Foto Menu (Opsional):</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2 focus:outline-none text-[11px]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Estimasi Kalori (kcal):</label>
                    <input type="number" name="calories" id="edit_calories" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Waktu Masak (Menit):</label>
                    <input type="number" name="prep_time_minutes" id="edit_prep_time" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Deskripsi Menu:</label>
                <textarea name="description" id="edit_description" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_featured" id="edit_is_featured" value="1" class="rounded text-toon-granite focus:ring-toon-granite w-4 h-4">
                <label for="edit_is_featured" class="font-bold text-gray-800 cursor-pointer">Tandai sebagai Menu Rekomendasi / Favorit</label>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('edit-product-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-full font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 px-6 rounded-full shadow-sm transition text-xs">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditProductModal(product) {
        document.getElementById('edit-product-form').action = `/admin/products/${product.id}/update`;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_price').value = parseInt(product.price);
        document.getElementById('edit_original_price').value = product.original_price ? parseInt(product.original_price) : '';
        document.getElementById('edit_calories').value = product.calories || '';
        document.getElementById('edit_prep_time').value = product.prep_time_minutes || '';
        document.getElementById('edit_description').value = product.description || '';
        document.getElementById('edit_is_featured').checked = !!product.is_featured;

        document.getElementById('edit-product-modal').classList.remove('hidden');
    }

    function filterCategory(categoryId) {
        const rows = document.querySelectorAll('.product-row');
        const chips = document.querySelectorAll('.category-chip');

        chips.forEach(chip => {
            if (chip.getAttribute('data-category') === categoryId) {
                chip.className = 'category-chip px-3.5 py-1.5 rounded-full font-bold transition bg-toon-granite text-white shadow-xs';
            } else {
                chip.className = 'category-chip px-3.5 py-1.5 rounded-full font-bold transition bg-toon-cream hover:bg-toon-wheat text-toon-granite border border-toon-granite/15';
            }
        });

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

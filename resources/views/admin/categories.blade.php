@extends('layouts.admin')

@section('title', 'Halaman Kategori Produk - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Halaman Kategori Produk</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola pembagian kategori menu makanan dan minuman restoran Toon Burger.</p>
        </div>
        <button onclick="document.getElementById('add-category-modal').classList.remove('hidden')" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2 self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Tambah Kategori</span>
        </button>
    </div>

    <!-- Category Table (SESUAI MOCKUP FOTO) -->
    <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-toon-cream/50 text-gray-500 font-bold border-b border-[#E6DEC8] uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Nama Kategori</th>
                        <th class="p-4">Slug URL</th>
                        <th class="p-4">Jumlah Menu</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $idx => $cat)
                        <tr class="hover:bg-toon-cream/20 transition">
                            <td class="p-4 text-center font-bold text-gray-400">
                                {{ $idx + 1 }}
                            </td>

                            <td class="p-4">
                                <div class="font-extrabold text-gray-900 text-sm flex items-center gap-2">
                                    <span>{{ $cat->name }}</span>
                                </div>
                            </td>

                            <td class="p-4 font-mono-code text-gray-500 text-[11px]">
                                {{ $cat->slug }}
                            </td>

                            <td class="p-4">
                                <span class="bg-toon-cream px-3 py-1 rounded-full text-toon-granite font-bold text-[11px] border border-toon-granite/15">
                                    {{ $cat->products_count ?? $cat->products()->count() }} Menu Terkait
                                </span>
                            </td>

                            <td class="p-4">
                                @if($cat->is_active)
                                    <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-toon-granite text-white inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-gray-100 text-gray-600 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        <span>Nonaktif</span>
                                    </span>
                                @endif
                            </td>

                            <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                <button type="button" onclick="openEditCategoryModal({{ json_encode($cat) }})" class="bg-toon-cream hover:bg-toon-wheat text-toon-granite font-bold px-3 py-1.5 rounded-full transition text-xs inline-flex items-center gap-1 border border-toon-granite/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?')" class="inline">
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
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400">
                                <div class="font-bold text-sm text-gray-700 mb-1">Belum Ada Kategori</div>
                                <p class="text-xs">Klik tombol <strong>+ Tambah Kategori</strong> untuk membuat kategori produk baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ═══ 1. MODAL TAMBAH KATEGORI ═══ -->
<div id="add-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-[#E6DEC8]">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-extrabold text-lg text-gray-900">Tambah Kategori Baru</h3>
                <p class="text-xs text-gray-400">Masukkan nama kategori untuk pengelompokan menu.</p>
            </div>
            <button onclick="document.getElementById('add-category-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1">Nama Kategori:</label>
                <input type="text" name="name" required placeholder="Contoh: Smash Burgers / Toon Combos" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Urutan Tampil (Opsional):</label>
                <input type="number" name="sort_order" placeholder="1" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('add-category-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-full font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 px-6 rounded-full shadow-sm transition text-xs">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ 2. MODAL EDIT KATEGORI ═══ -->
<div id="edit-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-[#E6DEC8]">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-extrabold text-lg text-gray-900">Edit Kategori</h3>
                <p class="text-xs text-gray-400">Perbarui rincian kategori produk.</p>
            </div>
            <button onclick="document.getElementById('edit-category-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-xl font-bold p-1">&times;</button>
        </div>

        <form id="edit-category-form" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1">Nama Kategori:</label>
                <input type="text" name="name" id="edit_category_name" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Urutan Tampil:</label>
                <input type="number" name="sort_order" id="edit_category_sort" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_active" id="edit_category_is_active" value="1" class="rounded text-toon-granite focus:ring-toon-granite w-4 h-4">
                <label for="edit_category_is_active" class="font-bold text-gray-800 cursor-pointer">Status Aktif</label>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('edit-category-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-full font-bold text-gray-600 hover:bg-gray-100 transition">
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
    function openEditCategoryModal(category) {
        document.getElementById('edit-category-form').action = `/admin/categories/${category.id}/update`;
        document.getElementById('edit_category_name').value = category.name;
        document.getElementById('edit_category_sort').value = category.sort_order || '';
        document.getElementById('edit_category_is_active').checked = !!category.is_active;

        document.getElementById('edit-category-modal').classList.remove('hidden');
    }
</script>
@endsection

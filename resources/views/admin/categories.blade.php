@extends('layouts.admin')

@section('title', 'Kelola Kategori Produk - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Kategori Produk</h1>
            <p class="text-xs text-gray-400 mt-1">Kelola kategori untuk pengelompokan menu Toon Burger</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative w-48 sm:w-56">
                <input type="text" id="category-table-search" onkeyup="searchCategoryTable()" placeholder="Cari kategori..." class="w-full pl-8 pr-3 py-2 text-xs bg-[#F4F5F7] border border-gray-200/70 rounded-full focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800 placeholder-gray-400">
                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <button type="button" onclick="openAddCategoryModal()" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    <!-- Category table -->
    <div class="border border-gray-200/80 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="category-table">
                <thead class="bg-[#F0F4F3] text-gray-600 font-bold border-b border-gray-200/70 text-[11px] tracking-wide">
                    <tr>
                        <th class="py-3.5 px-4 w-16 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Kategori</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="category-table-body">
                    @forelse($categories as $idx => $cat)
                        <tr class="category-row hover:bg-gray-50/70 transition" data-name="{{ strtolower($cat->name) }}">
                            <td class="py-3.5 px-4 text-center font-semibold text-gray-400 text-xs">
                                {{ $idx + 1 }}
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-extrabold text-gray-900 text-xs uppercase tracking-wide">
                                    {{ $cat->name }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit Button (Pencil Icon) -->
                                    <button type="button" onclick="openEditCategoryModal({{ json_encode($cat) }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition active:scale-95" title="Edit Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <!-- Delete Button (Red Trash Icon) -->
                                    <button type="button" onclick="openDeleteModal('{{ route('admin.categories.delete', $cat->id) }}', {{ json_encode('kategori ' . $cat->name) }})" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-[#DE3B28] flex items-center justify-center transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-400" title="Hapus Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-400">
                                <div class="font-bold text-sm text-gray-700 mb-1">Belum Ada Kategori</div>
                                <p class="text-xs">Klik tombol <strong>+ Tambah Kategori</strong> untuk membuat kategori menu baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah Kategori -->
<div id="add-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] hidden">
    <div class="bg-white rounded-3xl max-w-sm sm:max-w-md w-full p-8 shadow-2xl space-y-5 border border-gray-100 animate-modal-pop">
        <div class="pb-1">
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Tambah Kategori</h3>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Nama Kategori</label>
                <input type="text" name="name" required placeholder="Masukkan nama kategori" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <div class="pt-2 space-y-3 text-center">
                <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                    Simpan
                </button>
                <button type="button" onclick="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600 font-semibold text-xs transition inline-block">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="edit-category-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] hidden">
    <div class="bg-white rounded-3xl max-w-sm sm:max-w-md w-full p-8 shadow-2xl space-y-5 border border-gray-100 animate-modal-pop">
        <div class="pb-1">
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Edit Kategori</h3>
        </div>

        <form id="edit-category-form" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Nama Kategori</label>
                <input type="text" name="name" id="edit_category_name" required placeholder="Nama Kategori" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <div class="pt-2 space-y-3 text-center">
                <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditCategoryModal()" class="text-gray-400 hover:text-gray-600 font-semibold text-xs transition inline-block">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddCategoryModal() {
        document.getElementById('add-category-modal').classList.remove('hidden');
    }

    function closeAddCategoryModal() {
        document.getElementById('add-category-modal').classList.add('hidden');
    }

    function openEditCategoryModal(category) {
        document.getElementById('edit-category-form').action = `/admin/categories/${category.id}/update`;
        document.getElementById('edit_category_name').value = category.name;
        document.getElementById('edit-category-modal').classList.remove('hidden');
    }

    function closeEditCategoryModal() {
        document.getElementById('edit-category-modal').classList.add('hidden');
    }

    function searchCategoryTable() {
        const query = document.getElementById('category-table-search').value.toLowerCase();
        const rows = document.querySelectorAll('.category-row');
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

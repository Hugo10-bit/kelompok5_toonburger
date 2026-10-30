@extends('layouts.admin')

@section('title', 'Data Kategori - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-8 flex-1">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-[28px] font-bold text-[#333333] tracking-tight" data-i18n="cat_title">Halaman Kategori Produk</h1>
            <p class="text-xs text-gray-400 mt-1" data-i18n="cat_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="toggleCategorySort()" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-medium px-3.5 py-2 min-h-[36px] rounded-lg transition-colors text-xs inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span>Sortir</span>
            </button>

            <button type="button" onclick="openAddCatModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-4 py-2 min-h-[36px] rounded-lg transition-colors text-xs cursor-pointer" data-i18n="btn_add_cat">
                Tambahkan
            </button>
        </div>
    </div>

    <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-[#EEEEEE] text-gray-700 text-xs font-medium border-b border-gray-200">
                        <th class="py-3.5 px-6 text-center w-1/4">No.</th>
                        <th class="py-3.5 px-6 text-center w-2/4" data-i18n="col_category">Kategori</th>
                        <th class="py-3.5 px-6 text-center w-1/4" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="category-table-body" class="divide-y divide-gray-200/80 text-xs">
                    @forelse($categories as $index => $cat)
                    <tr class="hover:bg-gray-50/60 transition-colors category-row" data-name="{{ strtolower($cat->name) }}" data-index="{{ $index }}">
                        <td class="py-4 px-6 font-bold text-gray-800 category-num">
                            {{ $index + 1 }}.
                        </td>
                        <td class="py-4 px-6 text-gray-700 font-normal">
                            {{ $cat->name }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-3.5">
                                <button type="button" onclick="openEditCatModal({{ json_encode($cat) }})" class="text-gray-500 hover:text-gray-800 transition-colors p-1 cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
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
                        <td colspan="3" class="py-8 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="catModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl relative">
            <h3 id="catModalTitle" class="text-lg font-bold text-gray-900 mb-4" data-i18n="mod_cat_add">Tambah Kategori</h3>

            <form id="catForm" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="catFormMethod" value="POST">

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2" data-i18n="lbl_cat_name">Nama Kategori</label>
                    <input type="text" name="name" id="cat_name" required class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Cheese Burger">
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeCatModal()" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg text-xs font-bold text-white bg-[#415C58] hover:bg-[#344B48] transition-colors cursor-pointer" data-i18n="btn_save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const catModal = document.getElementById('catModal');
        const catForm = document.getElementById('catForm');
        const catTitle = document.getElementById('catModalTitle');
        const catMethod = document.getElementById('catFormMethod');
        let catSortAsc = null;

        function toggleCategorySort() {
            const tbody = document.getElementById('category-table-body');
            if (!tbody) return;
            const rows = Array.from(tbody.querySelectorAll('.category-row'));
            catSortAsc = catSortAsc === null ? true : !catSortAsc;
            rows.sort((a, b) => {
                const nameA = a.getAttribute('data-name') || '';
                const nameB = b.getAttribute('data-name') || '';
                return catSortAsc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });
            rows.forEach((r, idx) => {
                const numCell = r.querySelector('.category-num');
                if (numCell) numCell.textContent = (idx + 1) + '.';
                tbody.appendChild(r);
            });
        }

        function openAddCatModal() {
            const lang = localStorage.getItem('tb_lang') || 'ID';
            catTitle.innerText = lang === 'EN' ? 'Add Category' : 'Tambah Kategori';
            catForm.action = "{{ route('admin.categories.store') }}";
            catMethod.value = 'POST';
            catForm.reset();
            catModal.classList.remove('hidden');
        }

        function openEditCatModal(cat) {
            const lang = localStorage.getItem('tb_lang') || 'ID';
            catTitle.innerText = lang === 'EN' ? 'Edit Category' : 'Edit Kategori';
            catForm.action = `/admin/categories/${cat.id}`;
            catMethod.value = 'PUT';
            document.getElementById('cat_name').value = cat.name;
            catModal.classList.remove('hidden');
        }

        function closeCatModal() {
            catModal.classList.add('hidden');
        }
    </script>
</div>
@endsection

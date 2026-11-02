@extends('layouts.admin')

@section('title', 'Data Kategori - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-6 sm:p-9 lg:p-10 flex-1 flex flex-col">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
        <div>
            <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="cat_title">Halaman Kategori Produk</h1>
            <p class="text-sm sm:text-[15px] text-gray-400 dark:text-[#D4D4D4] mt-1.5" data-i18n="cat_sub">Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="toggleCategorySort()" class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white font-medium px-4 py-2.5 min-h-[42px] rounded-xl transition-colors text-sm inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-gray-500 dark:text-[#D4D4D4]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16m0 0l-3-3m3 3l3-3m7-9h4m-4 4h3m-3 4h2"></path>
                </svg>
                <span data-i18n="btn_sort">Sortir</span>
            </button>

            <button type="button" onclick="openAddCatModal()" class="bg-[#415C58] hover:bg-[#344B48] text-white font-medium px-5 py-2.5 min-h-[42px] rounded-xl transition-colors text-sm cursor-pointer" data-i18n="btn_add_cat">
                Tambahkan
            </button>
        </div>
    </div>

    <div class="border border-gray-200 dark:border-[#555555] rounded-[22px] overflow-hidden bg-white dark:bg-[#2B2B2B] flex-1">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-[#EEEEEE] dark:bg-[#9E9E9E] text-gray-700 dark:text-[#222222] text-sm font-medium border-b border-gray-200 dark:border-[#757575]">
                        <th class="py-4 px-6 text-center w-1/4" data-i18n="col_no">No.</th>
                        <th class="py-4 px-6 text-center w-2/4" data-i18n="col_category">Kategori</th>
                        <th class="py-4 px-6 text-center w-1/4" data-i18n="col_action">Aksi</th>
                    </tr>
                </thead>
                <tbody id="category-table-body" class="divide-y divide-gray-200/80 dark:divide-[#444444] text-sm">
                    @forelse($categories as $index => $cat)
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-[#353535] transition-colors category-row" data-name="{{ strtolower($cat->name) }}" data-index="{{ $index }}">
                        <td class="py-5 px-6 font-bold text-gray-800 dark:text-white category-num">
                            {{ $index + 1 }}.
                        </td>
                        <td class="py-5 px-6 text-gray-700 dark:text-[#E5E5E5] font-normal">
                            {{ $cat->name }}
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center justify-center gap-5">
                                <button type="button" onclick="openEditCatModal({{ json_encode($cat) }})" class="text-[#757575] dark:text-[#D4D4D4] hover:text-gray-900 dark:hover:text-white transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        <path d="M15 5l4 4"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.categories.delete', $cat->id) }}')" class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 transition-colors p-1.5 cursor-pointer inline-flex items-center justify-center" title="Hapus">
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

    <div id="catModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-[#2B2B2B] rounded-2xl max-w-sm w-full p-6 shadow-xl relative border border-gray-100 dark:border-[#4A4A4A]">
            <h3 id="catModalTitle" class="text-lg font-bold text-gray-900 dark:text-white mb-4" data-i18n="mod_cat_add">Tambah Kategori</h3>

            <form id="catForm" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="catFormMethod" value="POST">

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-[#E0E0E0] mb-2" data-i18n="lbl_cat_name">Nama Kategori</label>
                    <input type="text" name="name" id="cat_name" required class="w-full border border-gray-200 dark:border-[#555555] rounded-lg px-3 py-2 text-sm focus:ring-[#415C58] focus:border-[#415C58]" placeholder="Cth: Cheese Burger">
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-[#4A4A4A]">
                    <button type="button" onclick="closeCatModal()" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-600 dark:text-white bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] transition-colors cursor-pointer" data-i18n="btn_cancel">Batal</button>
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
            const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
            catTitle.innerText = isEn ? 'Add Category' : 'Tambah Kategori';
            catForm.action = "{{ route('admin.categories.store') }}";
            catMethod.value = 'POST';
            catForm.reset();
            catModal.classList.remove('hidden');
        }

        function openEditCatModal(cat) {
            const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
            catTitle.innerText = isEn ? 'Edit Category' : 'Edit Kategori';
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

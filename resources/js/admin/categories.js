function initAdminCategories() {
    const catModal = document.getElementById('catModal');
    if (!catModal) return;
    const catForm = document.getElementById('catForm');
    const catTitle = document.getElementById('catModalTitle');
    const catMethod = document.getElementById('catFormMethod');
    let catSortAsc = null;

    window.toggleCategorySort = function () {
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
    };

    window.openAddCatModal = function () {
        if (!catModal || !catForm || !catTitle || !catMethod) return;
        const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
        catTitle.innerText = isEn ? 'Add Category' : 'Tambah Kategori';
        catForm.action = catForm.dataset.storeUrl || '/admin/categories';
        catMethod.value = 'POST';
        catForm.reset();
        catModal.classList.remove('hidden');
    };

    window.openEditCatModal = function (cat) {
        if (!catModal || !catForm || !catTitle || !catMethod) return;
        const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
        catTitle.innerText = isEn ? 'Edit Category' : 'Edit Kategori';
        catForm.action = `/admin/categories/${cat.id}`;
        catMethod.value = 'PUT';
        document.getElementById('cat_name').value = cat.name;
        catModal.classList.remove('hidden');
    };

    window.closeCatModal = function () {
        if (catModal) catModal.classList.add('hidden');
    };

    if (catForm) {
        let isSubmitting = false;
        catForm.addEventListener('submit', function (e) {
            if (isSubmitting) return;
            e.preventDefault();
            isSubmitting = true;
            if (catModal) catModal.classList.add('hidden');

            const isEdit = catMethod && catMethod.value === 'PUT';
            const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US');
            const titleText = isEdit
                ? (isEn ? 'Saving Category...' : 'Menyimpan Perubahan Kategori...')
                : (isEn ? 'Adding Category...' : 'Menambahkan Kategori...');
            const descText = isEdit
                ? (isEn ? 'Updating category details in <b></b> seconds...' : 'Sedang menyimpan perubahan kategori dalam <b></b> detik...')
                : (isEn ? 'Adding new category in <b></b> seconds...' : 'Sedang memproses kategori baru dalam <b></b> detik...');

            if (typeof Swal !== 'undefined') {
                let timerInterval;
                Swal.fire({
                    title: titleText,
                    html: descText,
                    timer: 1500,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getPopup().querySelector('b');
                        timerInterval = setInterval(() => {
                            if (b) {
                                const left = Math.ceil(Swal.getTimerLeft() / 1000);
                                b.textContent = left > 0 ? left : 1;
                            }
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then(() => {
                    catForm.submit();
                });
            } else {
                catForm.submit();
            }
        });
    }
}

initAdminCategories();
window.addEventListener('tb:admin:pjax:loaded', initAdminCategories);

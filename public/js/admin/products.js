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
        form.action = form.dataset.storeUrl || '/admin/products';
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
        document.getElementById('prod_desc').value = product.description || '';
        document.getElementById('prod_avail').checked = product.is_available == 1;
        document.getElementById('prod_pop').checked = product.is_popular == 1;
        modal.classList.remove('hidden');
    };

    window.closeModal = function () {
        if (modal) modal.classList.add('hidden');
    };

    if (form) {
        let isSubmitting = false;
        form.addEventListener('submit', function (e) {
            if (isSubmitting) return;

            const priceInput = document.getElementById('prod_price');
            if (priceInput) {
                const price = parseFloat(priceInput.value);
                if (isNaN(price) || price < 1000 || price > 1000000) {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Harga Tidak Wajar',
                            text: 'Harga produk/pesanan tidak boleh berlebihan! Minimal Rp 1.000 dan maksimal Rp 1.000.000.',
                            confirmButtonColor: '#415C58',
                            confirmButtonText: 'Perbaiki Harga'
                        });
                    } else {
                        alert('Harga produk/pesanan tidak boleh berlebihan! Minimal Rp 1.000 dan maksimal Rp 1.000.000.');
                    }
                    priceInput.focus();
                    return false;
                }
            }

            // Jeda proses saat mengedit atau menambahkan produk
            e.preventDefault();
            isSubmitting = true;
            if (modal) modal.classList.add('hidden');

            const isEdit = methodInput && methodInput.value === 'PUT';
            const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US');
            const titleText = isEdit
                ? (isEn ? 'Saving Changes...' : 'Menyimpan Perubahan...')
                : (isEn ? 'Adding Product...' : 'Menambahkan Menu...');
            const descText = isEdit
                ? (isEn ? 'Updating menu details in <b></b> seconds...' : 'Sedang menyimpan perubahan menu dalam <b></b> detik...')
                : (isEn ? 'Adding new menu item in <b></b> seconds...' : 'Sedang memproses menu baru dalam <b></b> detik...');

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
                    form.submit();
                });
            } else {
                form.submit();
            }
        });
    }

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

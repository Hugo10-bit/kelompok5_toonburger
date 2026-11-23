import { compressJpgOrPngToDataUrl, isValidJpgOrPngFile, dataUrlToFile, attachFileToInput } from './image-upload';

function initAdminProducts() {
    const modal = document.getElementById('productModal');
    if (!modal) return;
    const form = document.getElementById('productForm');
    const title = document.getElementById('modalTitle');
    const methodInput = document.getElementById('formMethod');
    const imageInput = document.getElementById('prod_image_input');
    const imageDataInput = document.getElementById('prod_image_data');
    const previewWrap = document.getElementById('prod_image_preview_wrap');
    const previewImg = document.getElementById('prod_image_preview');
    const priceInputEl = document.getElementById('prod_price');
    let prodSortAsc = null;
    let pendingProductImageCompression = Promise.resolve('');

    function formatRupiah(num) {
        if (num === null || num === undefined || num === '') return '';
        const digits = String(num).replace(/\D/g, '');
        if (!digits) return '';
        return parseInt(digits, 10).toLocaleString('id-ID');
    }

    function parseRupiah(str) {
        if (!str) return 0;
        const digits = String(str).replace(/\D/g, '');
        return digits ? parseInt(digits, 10) : 0;
    }

    if (priceInputEl && priceInputEl.dataset.stepBound !== 'true') {
        priceInputEl.dataset.stepBound = 'true';

        priceInputEl.addEventListener('input', function () {
            const raw = parseRupiah(this.value);
            if (raw === 0 && !this.value.includes('0')) {
                this.value = '';
                return;
            }
            const oldLen = this.value.length;
            const cursorPos = this.selectionEnd || 0;
            const formatted = formatRupiah(raw);
            this.value = formatted;
            const newLen = formatted.length;
            const newPos = Math.max(0, cursorPos + (newLen - oldLen));
            try {
                this.setSelectionRange(newPos, newPos);
            } catch (_) {}
        });

        const stepPriceBy = (delta) => {
            const min = 1000;
            const max = 1000000;
            const current = parseRupiah(priceInputEl.value);
            let next;
            if (!current) {
                next = delta > 0 ? min : min;
            } else {
                next = Math.min(max, Math.max(min, current + delta));
            }
            priceInputEl.value = formatRupiah(next);
            priceInputEl.dispatchEvent(new Event('input', { bubbles: true }));
            priceInputEl.dispatchEvent(new Event('change', { bubbles: true }));
        };

        priceInputEl.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                stepPriceBy(500);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                stepPriceBy(-500);
            }
        });

        const priceUpBtn = document.getElementById('prod_price_up');
        const priceDownBtn = document.getElementById('prod_price_down');
        if (priceUpBtn) {
            priceUpBtn.addEventListener('mousedown', function (e) {
                e.preventDefault();
            });
            priceUpBtn.addEventListener('click', function () {
                if (document.activeElement !== priceInputEl) {
                    priceInputEl.focus();
                }
                stepPriceBy(500);
            });
        }
        if (priceDownBtn) {
            priceDownBtn.addEventListener('mousedown', function (e) {
                e.preventDefault();
            });
            priceDownBtn.addEventListener('click', function () {
                if (document.activeElement !== priceInputEl) {
                    priceInputEl.focus();
                }
                stepPriceBy(-500);
            });
        }
    }

    function showProductPreview(src) {
        if (previewImg && previewWrap && src) {
            previewImg.src = src;
            previewWrap.classList.remove('hidden');
        }
    }

    function hideProductPreview() {
        if (previewImg) previewImg.src = '';
        if (previewWrap) previewWrap.classList.add('hidden');
    }

    function showProductImageWarning(titleText, bodyText) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: titleText,
                text: bodyText,
                confirmButtonColor: '#415C58'
            });
        } else {
            alert(bodyText);
        }
    }

    if (imageInput && imageInput.dataset.bound !== 'true') {
        imageInput.dataset.bound = 'true';
        imageInput.addEventListener('change', function () {
            imageInput.disabled = false;
            if (!imageInput.files || !imageInput.files[0]) {
                if (imageDataInput) imageDataInput.value = '';
                pendingProductImageCompression = Promise.resolve('');
                if (methodInput && methodInput.value === 'POST') {
                    hideProductPreview();
                }
                return;
            }

            const file = imageInput.files[0];

            if (!isValidJpgOrPngFile(file)) {
                showProductImageWarning(
                    'Format File Tidak Sesuai',
                    'Gambar produk hanya diperbolehkan berformat JPG atau PNG.'
                );
                imageInput.value = '';
                if (imageDataInput) imageDataInput.value = '';
                pendingProductImageCompression = Promise.resolve('');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showProductImageWarning(
                    'Ukuran File Terlalu Besar',
                    'Ukuran gambar produk maksimal 5 MB.'
                );
                imageInput.value = '';
                if (imageDataInput) imageDataInput.value = '';
                pendingProductImageCompression = Promise.resolve('');
                return;
            }

            if (imageDataInput) imageDataInput.value = '';
            pendingProductImageCompression = compressJpgOrPngToDataUrl(file, { maxDim: 900, quality: 0.82 }).then((dataUrl) => {
                if (!dataUrl) {
                    showProductImageWarning(
                        'Gambar Tidak Dapat Dibaca',
                        'File foto rusak atau bukan gambar JPG/PNG yang valid.'
                    );
                    imageInput.value = '';
                    if (imageDataInput) imageDataInput.value = '';
                    return '';
                }

                if (imageDataInput) imageDataInput.value = dataUrl;
                showProductPreview(dataUrl);
                return dataUrl;
            });
        });
    }

    window.toggleProdFilterMenu = function () {
        const menu = document.getElementById('prod-filter-menu');
        if (menu) menu.classList.toggle('hidden');
    };

    window.applyCategoryFilter = function (cat) {
        const items = document.querySelectorAll('#product-table-body .product-row, #product-mobile-list .product-mobile-card');
        items.forEach(item => {
            if (cat === 'all' || item.getAttribute('data-category') === cat) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
        const menu = document.getElementById('prod-filter-menu');
        if (menu) menu.classList.add('hidden');
    };

    window.toggleProductSort = function () {
        prodSortAsc = prodSortAsc === null ? true : !prodSortAsc;
        [
            { container: document.getElementById('product-table-body'), selector: '.product-row' },
            { container: document.getElementById('product-mobile-list'), selector: '.product-mobile-card' },
        ].forEach(({ container, selector }) => {
            if (!container) return;
            const items = Array.from(container.querySelectorAll(selector));
            items.sort((a, b) => {
                const nameA = a.getAttribute('data-name') || '';
                const nameB = b.getAttribute('data-name') || '';
                return prodSortAsc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });
            items.forEach(el => container.appendChild(el));
        });
    };

    window.openAddModal = function () {
        if (!modal || !form || !title || !methodInput) return;
        const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
        title.innerText = isEn ? 'Add New Product' : 'Tambah Produk Baru';
        form.action = form.dataset.storeUrl || '/admin/products/store';
        methodInput.value = 'POST';
        form.reset();
        if (imageInput) {
            imageInput.disabled = false;
            imageInput.value = '';
        }
        if (imageDataInput) imageDataInput.value = '';
        pendingProductImageCompression = Promise.resolve('');
        hideProductPreview();
        const availEl = document.getElementById('prod_avail');
        if (availEl) availEl.checked = true;
        modal.classList.remove('hidden');
    };

    window.openEditModal = function (product, triggerBtn = null) {
        if (!modal || !form || !title || !methodInput) return;
        const isEn = (window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US');
        title.innerText = (isEn ? 'Edit Product: ' : 'Edit Produk: ') + product.name;
        form.action = `/admin/products/${product.id}`;
        methodInput.value = 'PUT';
        if (imageInput) {
            imageInput.disabled = false;
            imageInput.value = '';
        }
        if (imageDataInput) imageDataInput.value = '';
        pendingProductImageCompression = Promise.resolve('');
        const cardOrRow = triggerBtn && triggerBtn.closest ? triggerBtn.closest('.product-row, .product-mobile-card') : null;
        const thumbImg = cardOrRow ? cardOrRow.querySelector('.product-thumb-img') : null;
        if (thumbImg && thumbImg.getAttribute('src')) {
            showProductPreview(thumbImg.getAttribute('src'));
        } else {
            hideProductPreview();
        }
        document.getElementById('prod_name').value = product.name;
        document.getElementById('prod_cat').value = product.category_id;
        document.getElementById('prod_price').value = formatRupiah(product.price);
        document.getElementById('prod_desc').value = product.description || '';
        document.getElementById('prod_avail').checked = product.is_available == 1;
        document.getElementById('prod_pop').checked = product.is_popular == 1;
        modal.classList.remove('hidden');
    };

    window.closeModal = function () {
        if (modal) modal.classList.add('hidden');
    };

    if (form && form.dataset.productBound !== 'true') {
        form.dataset.productBound = 'true';
        let isSubmitting = false;
        form.addEventListener('submit', function (e) {
            if (isSubmitting) return;

            const priceInput = document.getElementById('prod_price');
            if (priceInput) {
                const price = parseRupiah(priceInput.value);
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
                priceInput.value = price;
            }

            // Jeda proses saat mengedit atau menambahkan produk
            e.preventDefault();
            isSubmitting = true;
            if (modal) modal.classList.add('hidden');

            const finalizeProductSubmit = async () => {
                await pendingProductImageCompression;
                if (imageDataInput && imageDataInput.value.startsWith('data:image/') && imageInput) {
                    const isPng = imageDataInput.value.startsWith('data:image/png');
                    const file = dataUrlToFile(imageDataInput.value, isPng ? 'product.png' : 'product.jpg');
                    if (file && attachFileToInput(imageInput, file)) {
                        imageInput.disabled = false;
                        imageDataInput.value = '';
                    } else {
                        imageInput.disabled = true;
                    }
                }
                form.submit();
            };

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
                    finalizeProductSubmit();
                });
            } else {
                finalizeProductSubmit();
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
}

initAdminProducts();
window.addEventListener('tb:admin:pjax:loaded', initAdminProducts);

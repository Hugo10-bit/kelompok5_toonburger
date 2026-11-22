function isAdminEnglish() {
    return window._tbLang === 'US'
        || window._tbLang === 'EN'
        || localStorage.getItem('tb_admin_lang') === 'US';
}

window.dismissUndoToast = function () {
    const toast = document.getElementById('undo-toast');
    if (toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(16px)';
        setTimeout(() => toast.remove(), 300);
    }
};

window.handleUndoSubmit = function (form) {
    const btn = form.querySelector('#undo-btn');
    if (btn) {
        btn.disabled = true;
        const isEn = isAdminEnglish();
        btn.innerHTML = `<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span>${isEn ? 'Restoring...' : 'Memulihkan...'}</span>`;
    }
};

function initUndoToast() {
    const toast = document.getElementById('undo-toast');
    if (toast) {
        const isEn = isAdminEnglish();
        const hintEl = toast.querySelector('[data-i18n="undo_toast_hint"]');
        const suffixEl = toast.querySelector('[data-i18n="deleted_success_suffix"]');
        const btnText = toast.querySelector('[data-i18n="btn_undo"]');
        if (isEn) {
            if (hintEl) hintEl.textContent = 'Deleted by mistake? You can restore it now.';
            if (suffixEl) suffixEl.textContent = 'successfully deleted';
            if (btnText) btnText.textContent = 'Undo';
        }
        setTimeout(() => {
            window.dismissUndoToast();
        }, 10000);
    }
}

function withSwal(cb) {
    if (typeof Swal !== 'undefined') {
        cb(Swal);
    } else {
        let attempts = 0;
        const interval = setInterval(() => {
            attempts++;
            if (typeof Swal !== 'undefined') {
                clearInterval(interval);
                cb(Swal);
            } else if (attempts >= 30) {
                clearInterval(interval);
            }
        }, 100);
    }
}

function showAdminFlashAlerts() {
    initUndoToast();

    const el = document.getElementById('admin-flash-data');
    if (!el || el.dataset.consumed === '1') return;
    el.dataset.consumed = '1';

    const storeToastRaw = el.dataset.storeStatusToast;
    const undoActionRaw = el.dataset.undoAction;
    const successMsg = el.dataset.flashSuccess;
    const errorMsg = el.dataset.flashError;

    if (undoActionRaw) {
        try {
            const undoData = JSON.parse(undoActionRaw);
            const isEn = isAdminEnglish();
            const itemName = undoData.name || undoData.label || (isEn ? 'Item' : 'Data');

            withSwal((SwalInstance) => {
                SwalInstance.fire({
                    icon: 'success',
                    title: isEn ? 'Successfully Deleted!' : 'Berhasil Dihapus!',
                    html: `
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">${isEn ? `<b>${itemName}</b> was successfully deleted.` : `<b>${itemName}</b> berhasil dihapus.`}</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 font-medium">${isEn ? 'Deleted by mistake? Click Undo to restore it immediately.' : 'Salah hapus? Klik tombol Urungkan untuk mengembalikannya.'}</p>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#F59E0B',
                    cancelButtonColor: '#415C58',
                    confirmButtonText: isEn ? '↩ Undo' : '↩ Urungkan (Undo)',
                    cancelButtonText: isEn ? 'Dismiss' : 'Selesai',
                    timer: 10000,
                    timerProgressBar: true,
                    customClass: { popup: 'rounded-3xl' },
                }).then((result) => {
                    if (result.isConfirmed && undoData.url) {
                        const undoForm = document.querySelector('#undo-toast form');
                        if (undoForm) {
                            handleUndoSubmit(undoForm);
                            undoForm.submit();
                        } else {
                            const tempForm = document.createElement('form');
                            tempForm.method = 'POST';
                            tempForm.action = undoData.url;
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            const metaCsrf = document.querySelector('meta[name="csrf-token"]');
                            csrfInput.value = metaCsrf ? metaCsrf.getAttribute('content') : '';
                            tempForm.appendChild(csrfInput);
                            document.body.appendChild(tempForm);
                            tempForm.submit();
                        }
                    }
                });
            });
        } catch (e) {
            console.error('Failed to parse undoAction:', e);
        }
    } else if (storeToastRaw) {
        try {
            const toastData = JSON.parse(storeToastRaw);
            if (typeof window.showStoreStatusToast === 'function') {
                window.showStoreStatusToast(toastData);
            } else {
                withSwal((SwalInstance) => {
                    const isEn = isAdminEnglish();
                    const isOpen = Boolean(toastData.is_open);
                    const reason = toastData.reason || '';
                    SwalInstance.fire({
                        icon: isOpen ? 'success' : 'warning',
                        title: isOpen
                            ? (isEn ? 'Outlet Successfully Opened!' : 'Outlet Berhasil Dibuka!')
                            : (isEn ? 'Outlet Successfully Closed!' : 'Outlet Berhasil Ditutup!'),
                        text: isOpen
                            ? (isEn ? 'Customers can now add items to cart and checkout on Toon Burger website.' : 'Toko kembali BUKA. Pelanggan sudah dapat melakukan pemesanan dan checkout kembali di website Toon Burger.')
                            : (isEn ? `Outlet is temporarily closed (${reason}). Customer orders are now paused.` : `Toko berhasil DITUTUP sementara (${reason}). Pemesanan pelanggan dinonaktifkan.`),
                        confirmButtonColor: isOpen ? '#40605D' : '#DC2626',
                        confirmButtonText: isEn ? 'Got it' : 'Mengerti',
                        timer: 3500,
                        timerProgressBar: true,
                    });
                });
            }
        } catch (e) {
            console.error('Failed to parse store_status_toast:', e);
        }
    } else if (successMsg) {
        withSwal((SwalInstance) => {
            const isEn = isAdminEnglish();
            SwalInstance.fire({
                icon: 'success',
                title: isEn ? 'Success!' : 'Berhasil!',
                text: successMsg,
                confirmButtonColor: '#415C58',
                confirmButtonText: isEn ? 'OK' : 'Selesai',
                timer: 3500,
                timerProgressBar: true,
            });
        });
    }

    if (errorMsg) {
        withSwal((SwalInstance) => {
            const isEn = isAdminEnglish();
            SwalInstance.fire({
                icon: 'error',
                title: isEn ? 'Failed!' : 'Gagal!',
                text: errorMsg,
                confirmButtonColor: '#DE3B28',
                confirmButtonText: isEn ? 'Close' : 'Tutup',
            });
        });
    }
}

window.showAdminFlashAlerts = showAdminFlashAlerts;
window.addEventListener('tb:admin:pjax:loaded', showAdminFlashAlerts);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', showAdminFlashAlerts);
} else {
    showAdminFlashAlerts();
}

function isAdminEnglish() {
    return window._tbLang === 'US'
        || window._tbLang === 'EN'
        || localStorage.getItem('tb_admin_lang') === 'US';
}

function showAdminFlashAlerts() {
    const el = document.getElementById('admin-flash-data');
    if (!el || el.dataset.consumed === '1') return;
    el.dataset.consumed = '1';

    const storeToastRaw = el.dataset.storeStatusToast;
    const successMsg = el.dataset.flashSuccess;
    const errorMsg = el.dataset.flashError;

    if (storeToastRaw) {
        try {
            const toastData = JSON.parse(storeToastRaw);
            if (typeof window.showStoreStatusToast === 'function') {
                window.showStoreStatusToast(toastData);
            } else if (typeof Swal !== 'undefined') {
                const isEn = isAdminEnglish();
                const isOpen = Boolean(toastData.is_open);
                const reason = toastData.reason || '';
                Swal.fire({
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
            }
        } catch (e) {
            console.error('Failed to parse store_status_toast:', e);
        }
    } else if (successMsg && typeof Swal !== 'undefined') {
        const isEn = isAdminEnglish();
        Swal.fire({
            icon: 'success',
            title: isEn ? 'Success!' : 'Berhasil!',
            text: successMsg,
            confirmButtonColor: '#415C58',
            confirmButtonText: isEn ? 'OK' : 'Selesai',
            timer: 3500,
            timerProgressBar: true,
        });
    }

    if (errorMsg && typeof Swal !== 'undefined') {
        const isEn = isAdminEnglish();
        Swal.fire({
            icon: 'error',
            title: isEn ? 'Failed!' : 'Gagal!',
            text: errorMsg,
            confirmButtonColor: '#DE3B28',
            confirmButtonText: isEn ? 'Close' : 'Tutup',
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', showAdminFlashAlerts);
} else {
    showAdminFlashAlerts();
}

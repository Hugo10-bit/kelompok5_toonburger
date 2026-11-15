window.confirmOrderDetailProcess = function (btn, nextStatus, orderNumber) {
    const isEn = (window._tbLang === 'EN' || window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    let statusText = 'Lanjutkan Proses';
    if (nextStatus === 'preparing') statusText = isEn ? 'Accept & Cook' : 'Terima & Masak';
    else if (nextStatus === 'ready') statusText = isEn ? 'Mark as Ready to Serve' : 'Tandai Siap Saji';
    else if (nextStatus === 'completed') statusText = isEn ? 'Complete Order' : 'Selesaikan Pesanan';

    Swal.fire({
        title: isEn ? 'Update Order Status?' : 'Perbarui Status Pesanan?',
        html: isEn
            ? `Proceed order <b>#${orderNumber}</b> to <b>${statusText}</b>?`
            : `Apakah pesanan <b>#${orderNumber}</b> siap untuk <b>${statusText}</b>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#385A56',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: isEn ? 'Yes, Proceed' : 'Ya, Lanjutkan',
        cancelButtonText: isEn ? 'Cancel' : 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: isEn ? 'Processing Order...' : 'Memproses Pesanan...',
                html: isEn
                    ? 'Updating status in <b></b> seconds...'
                    : 'Memperbarui status pesanan dalam <b></b> detik...',
                timer: 1500,
                timerProgressBar: true,
                allowOutsideClick: false,
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
        }
    });
};

window.confirmOrderDetailCancel = function (btn, orderNumber) {
    const isEn = (window._tbLang === 'EN' || window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    Swal.fire({
        title: isEn ? 'Cancel Order?' : 'Batalkan Pesanan Ini?',
        html: isEn
            ? `Are you sure you want to cancel order <b>#${orderNumber}</b>? This action cannot be undone.`
            : `Apakah Anda yakin ingin membatalkan pesanan <b>#${orderNumber}</b>? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DE3B28',
        cancelButtonColor: '#6B7280',
        confirmButtonText: isEn ? 'Yes, Cancel Order' : 'Ya, Batalkan Pesanan',
        cancelButtonText: isEn ? 'Back' : 'Kembali',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: isEn ? 'Cancelling...' : 'Membatalkan...',
                html: isEn ? 'Please wait...' : 'Mohon tunggu sebentar...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            form.submit();
        }
    });
};

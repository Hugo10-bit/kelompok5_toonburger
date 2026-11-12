window.confirmProcessOrder = function (btn, nextStatus, orderNumber) {
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    let statusLabel = 'tahap berikutnya';
    if (nextStatus === 'diproses' || nextStatus === 'preparing') statusLabel = isEn ? 'Cooking / Kitchen' : 'Dimasak';
    else if (nextStatus === 'ready') statusLabel = isEn ? 'Ready to Serve' : 'Siap Saji';
    else if (nextStatus === 'completed') statusLabel = isEn ? 'Completed' : 'Selesai';

    Swal.fire({
        title: isEn ? 'Process Order?' : 'Konfirmasi Pesanan?',
        html: isEn
            ? `Move order <b>#${orderNumber}</b> to <b>${statusLabel}</b>?`
            : `Lanjutkan proses pesanan <b>#${orderNumber}</b> ke status <b>${statusLabel}</b>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#415C58',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: isEn ? 'Yes, Process' : 'Ya, Proses Sekarang',
        cancelButtonText: isEn ? 'Cancel' : 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: isEn ? 'Processing Order...' : 'Memproses Pesanan...',
                html: isEn
                    ? 'Applying status update in <b></b> seconds...'
                    : 'Meneruskan status pesanan ke dapur dalam <b></b> detik...',
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

window.confirmCancelOrder = function (btn, orderNumber) {
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
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

function escapeOrderDetailHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

window.confirmOrderDetailProcess = function (btn, nextStatus, orderNumber) {
    const isEn = (window._tbLang === 'EN' || window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    const safeOrderNumber = escapeOrderDetailHtml(orderNumber);
    let statusText = 'Lanjutkan Proses';
    if (nextStatus === 'preparing') statusText = isEn ? 'Accept & Cook' : 'Terima & Masak';
    else if (nextStatus === 'ready') statusText = isEn ? 'Mark as Ready to Serve' : 'Tandai Siap Saji';
    else if (nextStatus === 'completed') statusText = isEn ? 'Complete Order' : 'Selesaikan Pesanan';
    else if (nextStatus === 'confirm_payment') statusText = isEn ? 'Confirm Payment as Paid' : 'Konfirmasi Pembayaran Lunas';

    Swal.fire({
        title: isEn ? 'Update Order Status?' : 'Perbarui Status Pesanan?',
        html: isEn
            ? `Proceed order <b>#${safeOrderNumber}</b> to <b>${statusText}</b>?`
            : `Apakah pesanan <b>#${safeOrderNumber}</b> siap untuk <b>${statusText}</b>?`,
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

    const safeOrderNumber = escapeOrderDetailHtml(orderNumber);

    Swal.fire({
        title: isEn ? 'Cancel Order?' : 'Batalkan Pesanan Ini?',
        html: isEn
            ? `Are you sure you want to cancel order <b>#${safeOrderNumber}</b>? This action cannot be undone.`
            : `Apakah Anda yakin ingin membatalkan pesanan <b>#${safeOrderNumber}</b>? Tindakan ini tidak dapat dibatalkan.`,
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

window.confirmRejectPaymentProof = function (btn, orderNumber) {
    const isEn = (window._tbLang === 'EN' || window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    const safeOrderNumber = escapeOrderDetailHtml(orderNumber);

    Swal.fire({
        title: isEn ? 'Reject Payment Proof?' : 'Tolak Bukti Pembayaran?',
        html: isEn
            ? `Request customer to re-upload proof for order <b>#${safeOrderNumber}</b>.`
            : `Minta pelanggan mengunggah ulang bukti transfer untuk pesanan <b>#${safeOrderNumber}</b>.`,
        input: 'text',
        inputPlaceholder: isEn ? 'Reason (optional, e.g. blurred / wrong amount)' : 'Alasan (opsional, misal: nominal kurang / foto buram)',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DE3B28',
        cancelButtonColor: '#6B7280',
        confirmButtonText: isEn ? 'Reject Proof' : 'Ya, Tolak Bukti',
        cancelButtonText: isEn ? 'Cancel' : 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const reasonInput = form.querySelector('input[name="reason"]');
            if (reasonInput) {
                reasonInput.value = (result.value || '').trim();
            }
            form.submit();
        }
    });
};

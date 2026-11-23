function escapeOrderHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

window.confirmProcessOrder = function (btn, nextStatus, orderNumber) {
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
    const form = btn.closest('form');
    if (!form) return;

    const safeOrderNumber = escapeOrderHtml(orderNumber);
    let statusLabel = 'tahap berikutnya';
    if (nextStatus === 'diproses' || nextStatus === 'preparing') statusLabel = isEn ? 'Cooking / Kitchen' : 'Dimasak';
    else if (nextStatus === 'ready') statusLabel = isEn ? 'Ready to Serve' : 'Siap Saji';
    else if (nextStatus === 'completed') statusLabel = isEn ? 'Completed' : 'Selesai';

    Swal.fire({
        title: isEn ? 'Process Order?' : 'Konfirmasi Pesanan?',
        html: isEn
            ? `Move order <b>#${safeOrderNumber}</b> to <b>${statusLabel}</b>?`
            : `Lanjutkan proses pesanan <b>#${safeOrderNumber}</b> ke status <b>${statusLabel}</b>?`,
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

    const safeOrderNumber = escapeOrderHtml(orderNumber);

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

// ==========================================================================
// Realtime Live Clock & Relative Order Time Updater (WITA - Asia/Makassar)
// ==========================================================================
function updateRealtimeClock() {
    const clockEl = document.getElementById('realtime-clock');
    if (!clockEl) return;
    try {
        const now = new Date();
        const witaString = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Makassar',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        }).format(now);
        clockEl.textContent = `${witaString.replace(/\./g, ':')} WITA`;
    } catch (e) {
        const now = new Date();
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const witaDate = new Date(utc + (3600000 * 8));
        const hh = String(witaDate.getHours()).padStart(2, '0');
        const mm = String(witaDate.getMinutes()).padStart(2, '0');
        const ss = String(witaDate.getSeconds()).padStart(2, '0');
        clockEl.textContent = `${hh}:${mm}:${ss} WITA`;
    }
}

function updateRealtimeOrderTimes() {
    const els = document.querySelectorAll('.order-time-display[data-timestamp]');
    if (!els.length) return;

    const nowMs = Date.now();
    els.forEach((el) => {
        const createdMs = parseInt(el.dataset.timestamp, 10);
        if (isNaN(createdMs)) return;

        const diffSecs = Math.max(0, Math.floor((nowMs - createdMs) / 1000));
        const diffMins = Math.floor(diffSecs / 60);
        const isToday = el.dataset.isToday === 'true';
        const isYesterday = el.dataset.isYesterday === 'true';
        const timeWita = el.dataset.timeWita || '';
        const dateWita = el.dataset.dateWita || '';

        let text = '';
        if (isToday) {
            if (diffMins < 1) {
                text = `Baru saja • ${timeWita}`;
            } else if (diffMins < 60) {
                text = `${diffMins} Menit yang lalu • ${timeWita}`;
            } else {
                text = `Hari ini, ${timeWita}`;
            }
        } else if (isYesterday) {
            text = `Kemarin, ${timeWita}`;
        } else {
            text = `${dateWita}, ${timeWita}`;
        }

        if (el.textContent.trim() !== text.trim()) {
            el.textContent = text;
        }
    });
}

// ==========================================================================
// Background Realtime Order Polling (Seamless Auto-Sync without Reload)
// ==========================================================================
let _orderPollInterval = null;
let _clockInterval = null;

function initOrdersRealtime() {
    const ordersGrid = document.getElementById('orders-cards-container');
    if (!ordersGrid) {
        if (_orderPollInterval) { clearInterval(_orderPollInterval); _orderPollInterval = null; }
        if (_clockInterval) { clearInterval(_clockInterval); _clockInterval = null; }
        return;
    }

    updateRealtimeClock();
    updateRealtimeOrderTimes();

    if (!_clockInterval) {
        _clockInterval = setInterval(() => {
            updateRealtimeClock();
            updateRealtimeOrderTimes();
        }, 1000);
    }

    if (!_orderPollInterval) {
        _orderPollInterval = setInterval(pollOrdersBackground, 15000);
    }
}

async function pollOrdersBackground() {
    if (document.hidden || document.querySelector('.swal2-shown') || document.querySelector('#catModal:not(.hidden)')) {
        return;
    }

    const ordersGrid = document.getElementById('orders-cards-container');
    const tabsContainer = document.getElementById('orders-status-tabs');
    if (!ordersGrid || !tabsContainer) return;

    try {
        const res = await fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            },
            cache: 'no-store'
        });

        if (!res.ok) return;
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        const newGrid = doc.getElementById('orders-cards-container');
        const newTabs = doc.getElementById('orders-status-tabs');

        if (newGrid && newGrid.innerHTML.trim() !== ordersGrid.innerHTML.trim()) {
            ordersGrid.innerHTML = newGrid.innerHTML;
            updateRealtimeOrderTimes();
        }

        if (newTabs && newTabs.innerHTML.trim() !== tabsContainer.innerHTML.trim()) {
            tabsContainer.innerHTML = newTabs.innerHTML;
        }
    } catch (e) {
        // Silently ignore background poll errors
    }
}

document.addEventListener('DOMContentLoaded', initOrdersRealtime);
window.addEventListener('tb:admin:pjax:loaded', initOrdersRealtime);
document.addEventListener('visibilitychange', () => {
    if (!document.hidden) {
        updateRealtimeClock();
        updateRealtimeOrderTimes();
        pollOrdersBackground();
    }
});

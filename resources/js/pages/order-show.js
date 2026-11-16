let qrisTimerSeconds = 5 * 60;
let qrisTimerInterval = null;
let paymentPollingInterval = null;
let snapScriptPromise = null;

function openReviewModal(productId, productName) {
    document.getElementById('review-product-id').value = productId;
    document.getElementById('review-product-name').innerText = productName;
    document.getElementById('review-modal').classList.remove('hidden');
}

function startQrisCountdown() {
    if (qrisTimerInterval) clearInterval(qrisTimerInterval);
    const overlay = document.getElementById('qris-expired-overlay');
    if (overlay) {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }

    function tick() {
        const min = Math.floor(qrisTimerSeconds / 60);
        const sec = qrisTimerSeconds % 60;
        const display = String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
        const el = document.getElementById('qris-timer-display');
        if (el) el.innerText = display;

        if (qrisTimerSeconds <= 0) {
            clearInterval(qrisTimerInterval);
            if (overlay) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            }
        } else {
            qrisTimerSeconds--;
        }
    }

    tick();
    qrisTimerInterval = setInterval(tick, 1000);
}

function restartQrisTimer() {
    qrisTimerSeconds = 5 * 60;
    startQrisCountdown();
}

function getPaymentConfig() {
    const el = document.getElementById('midtrans-payment-config');
    return el ? el.dataset : null;
}

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function loadSnapScript(scriptUrl, clientKey) {
    if (window.snap) {
        return Promise.resolve(window.snap);
    }
    if (snapScriptPromise) {
        return snapScriptPromise;
    }

    snapScriptPromise = new Promise((resolve, reject) => {
        const existing = document.querySelector('script[data-midtrans-snap="true"]');
        if (existing) {
            existing.addEventListener('load', () => resolve(window.snap));
            existing.addEventListener('error', reject);
            return;
        }

        const script = document.createElement('script');
        script.src = scriptUrl;
        script.setAttribute('data-client-key', clientKey);
        script.setAttribute('data-midtrans-snap', 'true');
        script.onload = () => resolve(window.snap);
        script.onerror = () => {
            snapScriptPromise = null;
            reject(new Error('Gagal memuat Midtrans Snap.js'));
        };
        document.head.appendChild(script);
    });

    return snapScriptPromise;
}

async function syncPaymentStatus(config) {
    if (!config || !config.syncUrl) return false;
    try {
        const res = await fetch(config.syncUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
        });
        if (!res.ok) return false;
        const data = await res.json();
        return data.payment_status === 'paid';
    } catch (e) {
        return false;
    }
}

function handlePaidRedirect() {
    if (paymentPollingInterval) {
        clearInterval(paymentPollingInterval);
        paymentPollingInterval = null;
    }
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil!',
            text: 'Pembayaran Anda telah terkonfirmasi otomatis. Memperbarui status pesanan...',
            timer: 1800,
            showConfirmButton: false,
            allowOutsideClick: false,
        }).then(() => {
            window.location.reload();
        });
    } else {
        window.location.reload();
    }
}

async function payWithMidtrans(forceNew = false) {
    const config = getPaymentConfig();
    if (!config || config.midtransConfigured !== 'true') return;

    const btn = document.getElementById('btn-midtrans-pay');
    const originalText = btn ? btn.innerText : '';
    if (btn) {
        btn.disabled = true;
        btn.innerText = 'Memuat Pembayaran...';
    }

    try {
        await loadSnapScript(config.snapScriptUrl, config.clientKey);

        let token = !forceNew ? config.snapToken : '';
        if (!token) {
            const res = await fetch(config.tokenUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({ force_new: forceNew }),
            });
            const data = await res.json();
            if (data.already_paid) {
                handlePaidRedirect();
                return;
            }
            if (!res.ok || !data.snap_token) {
                throw new Error(data.message || 'Gagal memulai transaksi Midtrans.');
            }
            token = data.snap_token;
            const cfgEl = document.getElementById('midtrans-payment-config');
            if (cfgEl) cfgEl.dataset.snapToken = token;
        }

        if (btn) {
            btn.disabled = false;
            btn.innerText = originalText;
        }

        window.snap.pay(token, {
            onSuccess: async () => {
                const paid = await syncPaymentStatus(config);
                if (paid) {
                    handlePaidRedirect();
                } else {
                    window.location.reload();
                }
            },
            onPending: async () => {
                const paid = await syncPaymentStatus(config);
                if (paid) handlePaidRedirect();
            },
            onError: () => {
                if (!forceNew) {
                    payWithMidtrans(true);
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Terjadi kendala saat memproses pembayaran. Silakan coba lagi.',
                        confirmButtonColor: '#385850',
                    });
                }
            },
            onClose: async () => {
                const paid = await syncPaymentStatus(config);
                if (paid) handlePaidRedirect();
            },
        });
    } catch (err) {
        if (btn) {
            btn.disabled = false;
            btn.innerText = originalText;
        }
        if (config.snapRedirectUrl) {
            window.location.href = config.snapRedirectUrl;
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Membuka Pembayaran',
                text: err.message || 'Silakan coba beberapa saat lagi.',
                confirmButtonColor: '#385850',
            });
        }
    }
}

function startPaymentPolling(config) {
    if (paymentPollingInterval) {
        clearInterval(paymentPollingInterval);
        paymentPollingInterval = null;
    }

    if (!config || config.paymentStatus === 'paid' || !config.statusUrl) {
        return;
    }

    paymentPollingInterval = setInterval(async () => {
        if (document.hidden) return;
        const currentCfg = getPaymentConfig();
        if (!currentCfg || !currentCfg.statusUrl) {
            clearInterval(paymentPollingInterval);
            paymentPollingInterval = null;
            return;
        }

        try {
            const res = await fetch(currentCfg.statusUrl, {
                headers: { 'Accept': 'application/json' },
            });
            if (!res.ok) return;
            const data = await res.json();
            if (data.payment_status === 'paid') {
                handlePaidRedirect();
            }
        } catch (e) {}
    }, 4000);
}

function initOrderShowPage() {
    const qrisModal = document.getElementById('qris-modal');
    if (qrisModal && qrisModal.dataset.autoOpenQris === 'true') {
        qrisModal.classList.remove('hidden');
        startQrisCountdown();
    }

    const config = getPaymentConfig();
    if (config && config.midtransConfigured === 'true' && config.snapScriptUrl && config.clientKey) {
        loadSnapScript(config.snapScriptUrl, config.clientKey).catch(() => {});
    }
    startPaymentPolling(config);
}

window.openReviewModal = openReviewModal;
window.startQrisCountdown = startQrisCountdown;
window.restartQrisTimer = restartQrisTimer;
window.payWithMidtrans = payWithMidtrans;

if (document.readyState === 'loading') {
    window.addEventListener('DOMContentLoaded', initOrderShowPage);
} else {
    initOrderShowPage();
}
window.addEventListener('tb:pjax:loaded', initOrderShowPage);

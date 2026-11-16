let qrisTimerSeconds = 5 * 60;
let qrisTimerInterval = null;
let paymentPollingInterval = null;
let snapScriptPromise = null;

function openQrisModal() {
    const modal = document.getElementById('qris-modal');
    if (modal) {
        modal.classList.remove('hidden');
        startQrisCountdown();
    }
}

function openPaymentProofModal() {
    const qrisModal = document.getElementById('qris-modal');
    if (qrisModal) qrisModal.classList.add('hidden');
    const modal = document.getElementById('payment-proof-modal');
    if (modal) modal.classList.remove('hidden');
}

function openProofLightbox() {
    const modal = document.getElementById('proof-lightbox-modal');
    if (modal) modal.classList.remove('hidden');
}

function showProofError(prefix, message) {
    const errEl = document.getElementById(`${prefix}-client-error`);
    if (!errEl) return;
    if (message) {
        errEl.textContent = message;
        errEl.classList.remove('hidden');
    } else {
        errEl.textContent = '';
        errEl.classList.add('hidden');
    }
}

function compressImageToDataUrl(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = () => {
            const rawDataUrl = typeof reader.result === 'string' ? reader.result : '';
            if (!rawDataUrl) {
                resolve('');
                return;
            }
            const img = new Image();
            img.onload = () => {
                try {
                    const maxDim = 1280;
                    const scale = Math.min(1, maxDim / Math.max(img.width || 1, img.height || 1));
                    const w = Math.max(1, Math.round((img.width || 1) * scale));
                    const h = Math.max(1, Math.round((img.height || 1) * scale));
                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    if (!ctx) {
                        resolve(rawDataUrl);
                        return;
                    }
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, w, h);
                    ctx.drawImage(img, 0, 0, w, h);
                    const compressed = canvas.toDataURL('image/jpeg', 0.82);
                    resolve(compressed && compressed.startsWith('data:image/') ? compressed : rawDataUrl);
                } catch (e) {
                    resolve(rawDataUrl);
                }
            };
            img.onerror = () => resolve(rawDataUrl);
            img.src = rawDataUrl;
        };
        reader.onerror = () => resolve('');
        reader.readAsDataURL(file);
    });
}

function bindPaymentProofForm(form) {
    if (!form || form.dataset.proofBound === 'true') return;
    form.dataset.proofBound = 'true';

    const prefix = form.dataset.proofForm;
    const fileInput = document.getElementById(`${prefix}-proof-input`);
    const proofDataInput = document.getElementById(`${prefix}-proof-data`);
    const emptyState = document.getElementById(`${prefix}-empty-state`);
    const previewState = document.getElementById(`${prefix}-preview-state`);
    const previewImg = document.getElementById(`${prefix}-preview-img`);
    const fileNameEl = document.getElementById(`${prefix}-file-name`);
    const clearBtn = form.querySelector(`[data-proof-clear="${prefix}"]`);
    const submitBtn = form.querySelector('[data-proof-submit]');
    const submitTextEl = submitBtn ? submitBtn.querySelector('[data-submit-text]') : null;

    let pendingCompression = Promise.resolve('');

    function resetSelection() {
        if (fileInput) {
            fileInput.disabled = false;
            fileInput.value = '';
        }
        if (proofDataInput) proofDataInput.value = '';
        if (previewState) previewState.classList.add('hidden');
        if (emptyState) emptyState.classList.remove('hidden');
        if (fileNameEl) fileNameEl.textContent = '';
        showProofError(prefix, '');
        pendingCompression = Promise.resolve('');
    }

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            const file = fileInput.files && fileInput.files[0];
            showProofError(prefix, '');
            if (!file) {
                resetSelection();
                return;
            }

            if (!/^image\/(jpeg|png|webp)$/i.test(file.type)) {
                resetSelection();
                showProofError(prefix, 'Format file harus gambar JPG, PNG, atau WEBP.');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                resetSelection();
                showProofError(prefix, 'Ukuran gambar maksimal 5 MB.');
                return;
            }

            if (fileNameEl) fileNameEl.textContent = file.name;
            if (emptyState) emptyState.classList.add('hidden');
            if (previewState) previewState.classList.remove('hidden');

            pendingCompression = compressImageToDataUrl(file).then((dataUrl) => {
                if (dataUrl) {
                    if (proofDataInput) proofDataInput.value = dataUrl;
                    if (previewImg) previewImg.src = dataUrl;
                }
                return dataUrl;
            });
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            resetSelection();
        });
    }

    form.addEventListener('submit', async (e) => {
        if (form.dataset.submitting === 'true') return;

        const hasFile = Boolean(fileInput && fileInput.files && fileInput.files.length > 0);
        const hasData = Boolean(proofDataInput && proofDataInput.value);

        if (!hasFile && !hasData) {
            e.preventDefault();
            showProofError(prefix, 'Silakan pilih foto / screenshot bukti transfer terlebih dahulu.');
            return;
        }

        e.preventDefault();
        form.dataset.submitting = 'true';
        showProofError(prefix, '');

        if (submitBtn) submitBtn.disabled = true;
        if (submitTextEl) submitTextEl.textContent = 'Mengirim Bukti...';

        await pendingCompression;

        if (proofDataInput && proofDataInput.value && fileInput) {
            // Avoid hitting serverless body size limits with redundant uncompressed file bytes
            fileInput.disabled = true;
        }

        form.submit();
    });
}

function initPaymentProofForms() {
    document.querySelectorAll('form[data-proof-form]').forEach(bindPaymentProofForm);
}

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
            title: 'Pembayaran Dikonfirmasi!',
            text: 'Pembayaran Anda telah dikonfirmasi lunas. Memperbarui status pesanan...',
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
            } else if (currentCfg.proofState === 'uploaded' && data.proof_rejected) {
                clearInterval(paymentPollingInterval);
                paymentPollingInterval = null;
                window.location.reload();
            }
        } catch (e) {}
    }, 4000);
}

function initOrderShowPage() {
    initPaymentProofForms();

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
window.openQrisModal = openQrisModal;
window.openPaymentProofModal = openPaymentProofModal;
window.openProofLightbox = openProofLightbox;
window.startQrisCountdown = startQrisCountdown;
window.restartQrisTimer = restartQrisTimer;
window.payWithMidtrans = payWithMidtrans;

if (document.readyState === 'loading') {
    window.addEventListener('DOMContentLoaded', initOrderShowPage);
} else {
    initOrderShowPage();
}
window.addEventListener('tb:pjax:loaded', initOrderShowPage);

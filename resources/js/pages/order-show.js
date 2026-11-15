function openReviewModal(productId, productName) {
    document.getElementById('review-product-id').value = productId;
    document.getElementById('review-product-name').innerText = productName;
    document.getElementById('review-modal').classList.remove('hidden');
}

let qrisTimerSeconds = 5 * 60; // 5 menit
let qrisTimerInterval = null;

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

function initOrderShowQris() {
    const qrisModal = document.getElementById('qris-modal');
    if (qrisModal && qrisModal.dataset.autoOpenQris === 'true') {
        qrisModal.classList.remove('hidden');
        startQrisCountdown();
    }
}

window.openReviewModal = openReviewModal;
window.startQrisCountdown = startQrisCountdown;
window.restartQrisTimer = restartQrisTimer;

if (document.readyState === 'loading') {
    window.addEventListener('DOMContentLoaded', initOrderShowQris);
} else {
    initOrderShowQris();
}
window.addEventListener('tb:pjax:loaded', initOrderShowQris);

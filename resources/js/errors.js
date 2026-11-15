(function () {
    const body = document.body;
    if (!body) return;

    const probeUrl = body.dataset.probeUrl;
    if (!probeUrl) return;

    const isPreview = window.location.pathname.startsWith('/error/');
    const defaultBtnLabel = body.dataset.btnDefault || 'Muat Ulang Halaman';
    const checkingBtnLabel = body.dataset.btnChecking || 'Mengecek Dapur...';
    const onlineBtnLabel = body.dataset.btnOnline || 'Membuka Halaman...';
    const checkingStatus = body.dataset.statusChecking || 'Mengecek koneksi server & database...';
    const onlineStatus = body.dataset.statusOnline || 'Dapur sudah nyala! Memuat ulang halaman...';
    const offlineStatus = body.dataset.statusOffline || 'Dapur masih offline. Mengecek ulang otomatis...';
    const previewStatus = body.dataset.statusPreview || 'Mode preview — auto-refresh aktif saat error nyata.';

    let isChecking = false;

    async function checkServerAndDb() {
        if (isChecking) return false;
        isChecking = true;

        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(function () {
                controller.abort();
            }, 2500);

            const separator = probeUrl.includes('?') ? '&' : '?';
            const response = await fetch(probeUrl + separator + 't=' + Date.now(), {
                method: 'GET',
                signal: controller.signal,
                cache: 'no-store'
            });
            clearTimeout(timeoutId);

            if (response.ok) {
                const dot = document.getElementById('status-dot');
                const text = document.getElementById('status-text');
                const btnText = document.getElementById('retry-btn-text');

                if (dot) {
                    dot.classList.remove('bg-[#D92625]', 'animate-pulse');
                    dot.classList.add('bg-[#16A34A]');
                }
                if (text) text.textContent = onlineStatus;
                if (btnText) btnText.textContent = onlineBtnLabel;

                setTimeout(function () {
                    window.location.reload();
                }, 400);
                return true;
            }
        } catch (err) {
            // Server or database still offline
        } finally {
            isChecking = false;
        }

        return false;
    }

    window.checkAndReload = async function () {
        const btnText = document.getElementById('retry-btn-text');
        const text = document.getElementById('status-text');

        if (btnText) btnText.textContent = checkingBtnLabel;
        if (text) text.textContent = checkingStatus;

        const online = await checkServerAndDb();
        if (!online) {
            if (btnText) btnText.textContent = defaultBtnLabel;
            if (text) text.textContent = offlineStatus;
        }
    };

    if (isPreview) {
        const text = document.getElementById('status-text');
        if (text) text.textContent = previewStatus;
        return;
    }

    setInterval(checkServerAndDb, 3000);
    window.addEventListener('online', checkServerAndDb);
})();

function loadFileAsImage(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onerror = () => resolve(null);
        reader.onload = () => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = () => resolve(null);
            img.src = String(reader.result || '');
        };
        reader.readAsDataURL(file);
    });
}

function isPngFile(file) {
    const type = (file?.type || '').toLowerCase();
    const name = (file?.name || '').toLowerCase();
    return type === 'image/png' || name.endsWith('.png');
}

export function openAvatarCropperModal(file, options = {}) {
    const isEn = Boolean(options.isEn);
    const outputSize = options.outputSize || 480;
    const maxDataUrlLength = options.maxDataUrlLength || 450000;
    const preferPng = isPngFile(file);

    return new Promise(async (resolve) => {
        const img = await loadFileAsImage(file);
        if (!img || !img.naturalWidth || !img.naturalHeight) {
            resolve(null);
            return;
        }

        const existing = document.getElementById('tb-avatar-cropper-modal');
        if (existing) existing.remove();

        const isDark = document.documentElement.classList.contains('dark');
        const t = (idText, enText) => (isEn ? enText : idText);

        const overlay = document.createElement('div');
        overlay.id = 'tb-avatar-cropper-modal';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-label', t('Atur Foto Profil', 'Adjust Profile Photo'));
        overlay.style.cssText = [
            'position:fixed', 'inset:0', 'z-index:10050',
            'background:rgba(0,0,0,0.68)', 'backdrop-filter:blur(4px)',
            'display:flex', 'align-items:center', 'justify-content:center',
            'padding:16px',
        ].join(';');

        const cardBg = isDark ? '#2B2B2B' : '#FFFFFF';
        const cardBorder = isDark ? '#4A4A4A' : '#E5E7EB';
        const textMain = isDark ? '#F3F4F6' : '#111827';
        const textSub = isDark ? '#A3A3A3' : '#6B7280';
        const btnBg = isDark ? '#3A3A3A' : '#F3F4F6';
        const btnBorder = isDark ? '#525252' : '#D1D5DB';

        const card = document.createElement('div');
        card.style.cssText = [
            'width:100%', 'max-width:390px', 'border-radius:20px',
            `background:${cardBg}`, `border:1px solid ${cardBorder}`,
            'box-shadow:0 24px 60px rgba(0,0,0,0.35)', 'overflow:hidden',
            'font-family:Inter,Roboto,system-ui,sans-serif',
        ].join(';');

        card.innerHTML = `
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px 12px;border-bottom:1px solid ${cardBorder};">
                <div>
                    <h3 style="margin:0;font-size:15px;font-weight:700;color:${textMain};line-height:1.3;">${t('Atur Foto Profil', 'Adjust Profile Photo')}</h3>
                    <p style="margin:2px 0 0;font-size:11.5px;color:${textSub};">${t('Geser & perbesar untuk menyesuaikan posisi foto', 'Drag & zoom to position your photo')}</p>
                </div>
                <button type="button" data-crop-close aria-label="${t('Tutup', 'Close')}" style="width:32px;height:32px;border-radius:9999px;border:none;background:${btnBg};color:${textMain};display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:18px;line-height:1;">&times;</button>
            </div>
            <div style="padding:18px 20px 14px;display:flex;flex-direction:column;align-items:center;gap:14px;">
                <div data-crop-stage style="position:relative;width:270px;height:270px;max-width:74vw;max-height:74vw;border-radius:16px;overflow:hidden;background:#111827;touch-action:none;cursor:grab;user-select:none;">
                    <canvas data-crop-canvas style="width:100%;height:100%;display:block;"></canvas>
                </div>
                <div style="width:100%;display:flex;align-items:center;gap:8px;">
                    <button type="button" data-crop-zoom-out aria-label="${t('Perkecil', 'Zoom out')}" style="width:32px;height:32px;border-radius:10px;border:1px solid ${btnBorder};background:${btnBg};color:${textMain};font-weight:700;font-size:16px;line-height:1;cursor:pointer;flex-shrink:0;">&minus;</button>
                    <input type="range" data-crop-slider min="1" max="3" step="0.01" value="1" aria-label="${t('Perbesar foto', 'Zoom photo')}" style="flex:1;accent-color:#3B6E64;cursor:pointer;">
                    <button type="button" data-crop-zoom-in aria-label="${t('Perbesar', 'Zoom in')}" style="width:32px;height:32px;border-radius:10px;border:1px solid ${btnBorder};background:${btnBg};color:${textMain};font-weight:700;font-size:16px;line-height:1;cursor:pointer;flex-shrink:0;">+</button>
                    <button type="button" data-crop-reset style="height:32px;padding:0 10px;border-radius:10px;border:1px solid ${btnBorder};background:${btnBg};color:${textMain};font-size:11.5px;font-weight:600;cursor:pointer;flex-shrink:0;">${t('Reset', 'Reset')}</button>
                </div>
            </div>
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:12px 20px 16px;border-top:1px solid ${cardBorder};">
                <button type="button" data-crop-cancel style="height:38px;padding:0 16px;border-radius:12px;border:1px solid ${btnBorder};background:${btnBg};color:${textMain};font-size:12.5px;font-weight:600;cursor:pointer;">${t('Batal', 'Cancel')}</button>
                <button type="button" data-crop-confirm style="height:38px;padding:0 18px;border-radius:12px;border:none;background:#3B6E64;color:#FFFFFF;font-size:12.5px;font-weight:700;cursor:pointer;">${t('Konfirmasi Foto', 'Confirm Photo')}</button>
            </div>
        `;

        overlay.appendChild(card);
        document.body.appendChild(overlay);

        const prevOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';

        const stage = card.querySelector('[data-crop-stage]');
        const canvas = card.querySelector('[data-crop-canvas]');
        const slider = card.querySelector('[data-crop-slider]');
        const zoomOutBtn = card.querySelector('[data-crop-zoom-out]');
        const zoomInBtn = card.querySelector('[data-crop-zoom-in]');
        const resetBtn = card.querySelector('[data-crop-reset]');
        const cancelBtn = card.querySelector('[data-crop-cancel]');
        const closeBtn = card.querySelector('[data-crop-close]');
        const confirmBtn = card.querySelector('[data-crop-confirm]');

        const ctx = canvas.getContext('2d');
        const stageSize = stage.clientWidth || 270;
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.round(stageSize * dpr);
        canvas.height = Math.round(stageSize * dpr);

        const cropRadius = stageSize * 0.44;
        const cropDiameter = cropRadius * 2;
        const baseScale = Math.max(cropDiameter / img.naturalWidth, cropDiameter / img.naturalHeight);

        let zoom = 1;
        let offsetX = 0;
        let offsetY = 0;
        let isDragging = false;
        let dragStartX = 0;
        let dragStartY = 0;
        let startOffsetX = 0;
        let startOffsetY = 0;

        function clampOffsets() {
            const drawW = img.naturalWidth * baseScale * zoom;
            const drawH = img.naturalHeight * baseScale * zoom;
            const maxX = Math.max(0, (drawW - cropDiameter) / 2);
            const maxY = Math.max(0, (drawH - cropDiameter) / 2);
            offsetX = Math.max(-maxX, Math.min(maxX, offsetX));
            offsetY = Math.max(-maxY, Math.min(maxY, offsetY));
        }

        function renderPreview() {
            clampOffsets();
            ctx.save();
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            ctx.clearRect(0, 0, stageSize, stageSize);

            const drawW = img.naturalWidth * baseScale * zoom;
            const drawH = img.naturalHeight * baseScale * zoom;
            const cx = stageSize / 2 + offsetX;
            const cy = stageSize / 2 + offsetY;

            ctx.fillStyle = '#111827';
            ctx.fillRect(0, 0, stageSize, stageSize);
            ctx.drawImage(img, cx - drawW / 2, cy - drawH / 2, drawW, drawH);

            // Dim outside circular avatar crop area
            ctx.save();
            ctx.fillStyle = 'rgba(0, 0, 0, 0.52)';
            ctx.beginPath();
            ctx.rect(0, 0, stageSize, stageSize);
            ctx.arc(stageSize / 2, stageSize / 2, cropRadius, 0, Math.PI * 2, true);
            ctx.fill('evenodd');
            ctx.restore();

            // Crisp white circle guide ring
            ctx.beginPath();
            ctx.arc(stageSize / 2, stageSize / 2, cropRadius, 0, Math.PI * 2);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.92)';
            ctx.lineWidth = 2;
            ctx.stroke();

            ctx.restore();
        }

        function setZoom(nextZoom) {
            zoom = Math.max(1, Math.min(3, Number(nextZoom) || 1));
            slider.value = zoom.toFixed(2);
            renderPreview();
        }

        function exportCroppedDataUrl() {
            clampOffsets();
            const outCanvas = document.createElement('canvas');
            outCanvas.width = outputSize;
            outCanvas.height = outputSize;
            const outCtx = outCanvas.getContext('2d');
            if (!outCtx) return '';

            const scaleToOut = outputSize / cropDiameter;
            const drawW = img.naturalWidth * baseScale * zoom * scaleToOut;
            const drawH = img.naturalHeight * baseScale * zoom * scaleToOut;
            const cx = outputSize / 2 + offsetX * scaleToOut;
            const cy = outputSize / 2 + offsetY * scaleToOut;

            if (!preferPng) {
                outCtx.fillStyle = '#FFFFFF';
                outCtx.fillRect(0, 0, outputSize, outputSize);
            }
            outCtx.drawImage(img, cx - drawW / 2, cy - drawH / 2, drawW, drawH);

            if (preferPng) {
                const pngUrl = outCanvas.toDataURL('image/png');
                if (pngUrl.length <= maxDataUrlLength) {
                    return pngUrl;
                }
            }

            let quality = 0.86;
            let jpegUrl = outCanvas.toDataURL('image/jpeg', quality);
            while (jpegUrl.length > maxDataUrlLength && quality > 0.45) {
                quality -= 0.1;
                jpegUrl = outCanvas.toDataURL('image/jpeg', quality);
            }
            return jpegUrl;
        }

        function cleanup(result) {
            document.removeEventListener('keydown', onKeyDown);
            document.body.style.overflow = prevOverflow;
            overlay.remove();
            resolve(result);
        }

        function onKeyDown(e) {
            if (e.key === 'Escape') {
                cleanup(null);
            }
        }

        stage.addEventListener('pointerdown', (e) => {
            isDragging = true;
            stage.style.cursor = 'grabbing';
            stage.setPointerCapture(e.pointerId);
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            startOffsetX = offsetX;
            startOffsetY = offsetY;
        });

        stage.addEventListener('pointermove', (e) => {
            if (!isDragging) return;
            offsetX = startOffsetX + (e.clientX - dragStartX);
            offsetY = startOffsetY + (e.clientY - dragStartY);
            renderPreview();
        });

        const endDrag = (e) => {
            if (!isDragging) return;
            isDragging = false;
            stage.style.cursor = 'grab';
            try { stage.releasePointerCapture(e.pointerId); } catch (_) {}
        };
        stage.addEventListener('pointerup', endDrag);
        stage.addEventListener('pointercancel', endDrag);

        stage.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY < 0 ? 0.12 : -0.12;
            setZoom(zoom + delta);
        }, { passive: false });

        slider.addEventListener('input', () => setZoom(slider.value));
        zoomOutBtn.addEventListener('click', () => setZoom(zoom - 0.15));
        zoomInBtn.addEventListener('click', () => setZoom(zoom + 0.15));
        resetBtn.addEventListener('click', () => {
            offsetX = 0;
            offsetY = 0;
            setZoom(1);
        });

        cancelBtn.addEventListener('click', () => cleanup(null));
        closeBtn.addEventListener('click', () => cleanup(null));
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) cleanup(null);
        });
        confirmBtn.addEventListener('click', () => {
            const croppedDataUrl = exportCroppedDataUrl();
            cleanup(croppedDataUrl || null);
        });

        document.addEventListener('keydown', onKeyDown);
        renderPreview();
    });
}

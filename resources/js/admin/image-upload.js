export function isValidJpgOrPngFile(file) {
    if (!file) return false;
    const type = (file.type || '').toLowerCase();
    const name = file.name || '';
    const validMime = type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png';
    const validExt = /\.(jpe?g|png)$/i.test(name);

    if (type) {
        return validMime && (name ? validExt : true);
    }

    return validExt;
}

export function compressJpgOrPngToDataUrl(file, { maxDim = 800, quality = 0.82, maxDataUrlLength = 900000 } = {}) {
    return new Promise((resolve) => {
        if (!file) {
            resolve('');
            return;
        }

        const isPng = (file.type || '').toLowerCase() === 'image/png' || /\.png$/i.test(file.name || '');
        const reader = new FileReader();

        reader.onload = () => {
            const rawDataUrl = typeof reader.result === 'string' ? reader.result : '';
            if (!rawDataUrl) {
                resolve('');
                return;
            }

            const img = new Image();
            img.onload = () => {
                const renderAt = (targetMaxDim, jpegQuality) => {
                    const scale = Math.min(1, targetMaxDim / Math.max(img.width || 1, img.height || 1));
                    const w = Math.max(1, Math.round((img.width || 1) * scale));
                    const h = Math.max(1, Math.round((img.height || 1) * scale));
                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;

                    const ctx = canvas.getContext('2d');
                    if (!ctx) return '';

                    if (isPng) {
                        ctx.clearRect(0, 0, w, h);
                        ctx.drawImage(img, 0, 0, w, h);
                        return canvas.toDataURL('image/png');
                    }

                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, w, h);
                    ctx.drawImage(img, 0, 0, w, h);
                    return canvas.toDataURL('image/jpeg', jpegQuality);
                };

                try {
                    let result = renderAt(maxDim, quality);

                    if (isPng && result.length > maxDataUrlLength) {
                        result = renderAt(Math.max(256, Math.round(maxDim * 0.75)), quality);
                        if (result.length > maxDataUrlLength) {
                            result = renderAt(Math.max(200, Math.round(maxDim * 0.5)), quality);
                        }
                    } else if (!isPng && result.length > maxDataUrlLength) {
                        result = renderAt(maxDim, 0.72);
                        if (result.length > maxDataUrlLength) {
                            result = renderAt(Math.max(256, Math.round(maxDim * 0.75)), 0.72);
                        }
                    }

                    resolve(result && result.startsWith('data:image/') ? result : '');
                } catch (e) {
                    resolve('');
                }
            };
            img.onerror = () => resolve('');
            img.src = rawDataUrl;
        };

        reader.onerror = () => resolve('');
        reader.readAsDataURL(file);
    });
}

(function () {
    const STORE_LAT = -3.435655;
    const STORE_LNG = 114.823324;

    let map = null;
    let storeMarker = null;
    let currentTileLayer = null;

    function initLiveMap() {
        const container = document.getElementById('live-leaflet-map');
        if (!container || typeof L === 'undefined') return;
        if (container._leaflet_id) return;

        if (map) {
            try { map.remove(); } catch (e) {}
            map = null;
        }

        map = L.map('live-leaflet-map', {
            center: [STORE_LAT, STORE_LNG],
            zoom: 18,
            zoomControl: false,
            attributionControl: false,
            scrollWheelZoom: false
        });

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&hl=id&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        const storeIcon = L.divIcon({
            className: 'custom-toon-pin',
            html: `
                <div style="display: flex; align-items: center; gap: 6px; transform: translate(-16px, -40px); pointer-events: auto;">
                    <div style="position: relative; width: 32px; height: 40px; flex-shrink: 0; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.28));">
                        <svg viewBox="0 0 32 42" width="32" height="40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 1C7.716 1 1 7.716 1 16c0 10.2 15 24.5 15 24.5S31 26.2 31 16C31 7.716 24.284 1 16 1z" fill="#F26B1D" stroke="#FFFFFF" stroke-width="2"/>
                            <path d="M12 10v5c0 .8.6 1.5 1.4 1.5v5.5h1.2v-5.5c.8 0 1.4-.7 1.4-1.5v-5h-1v4h-.6v-4h-.8v4h-.6v-4H12zm6.8 0c-1.2 0-2.2 1.2-2.2 2.7v3.3h1.4v6h1.3V10h-.5z" fill="#FFFFFF"/>
                        </svg>
                    </div>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #E8601C; letter-spacing: 0.02em; white-space: nowrap; text-shadow: -1.5px -1.5px 0 #fff, 1.5px -1.5px 0 #fff, -1.5px 1.5px 0 #fff, 1.5px 1.5px 0 #fff, 0 2px 4px rgba(255,255,255,0.9);">
                        TOON BURGER
                    </span>
                </div>
            `,
            iconSize: [160, 42],
            iconAnchor: [0, 0],
            popupAnchor: [0, -38]
        });

        storeMarker = L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon })
            .addTo(map)
            .bindPopup(
                '<div style="font-family: Poppins, sans-serif; padding: 2px 4px;">' +
                    '<strong style="color:#27443E; font-size:13px;">Toon Burger Banjarbaru</strong><br>' +
                    '<span style="color:#555; font-size:11px;">Jl. Berlian, Loktabat Utara, Banjarbaru</span>' +
                '</div>'
            );

        // Ctrl + Scroll Up/Down zoom (centered on cursor) without hijacking normal page scroll
        let hintTimer = null;
        let hintEl = container.querySelector('.map-ctrl-scroll-hint');
        if (!hintEl) {
            hintEl = document.createElement('div');
            hintEl.className = 'map-ctrl-scroll-hint pointer-events-none select-none opacity-0 transition-opacity duration-200 absolute inset-x-0 bottom-3 z-[400] flex justify-center px-3';
            hintEl.innerHTML = '<span class="bg-[#121212]/80 text-white text-[11px] font-medium px-3 py-1.5 rounded-full shadow-sm">Tekan Ctrl + Scroll untuk zoom peta</span>';
            container.appendChild(hintEl);
        }

        container.addEventListener('wheel', function (event) {
            if (!map) return;

            if (event.ctrlKey || event.metaKey) {
                event.preventDefault();
                event.stopPropagation();

                hintEl.classList.remove('opacity-100');
                hintEl.classList.add('opacity-0');

                if (event.deltaY === 0) return;
                const delta = event.deltaY < 0 ? 1 : -1;
                const targetZoom = Math.min(map.getMaxZoom(), Math.max(map.getMinZoom(), map.getZoom() + delta));
                if (targetZoom !== map.getZoom()) {
                    const latlng = map.mouseEventToLatLng(event);
                    map.setZoomAround(latlng, targetZoom);
                }
                return;
            }

            hintEl.classList.remove('opacity-0');
            hintEl.classList.add('opacity-100');
            if (hintTimer) clearTimeout(hintTimer);
            hintTimer = setTimeout(function () {
                hintEl.classList.remove('opacity-100');
                hintEl.classList.add('opacity-0');
            }, 1400);
        }, { passive: false });
    }

    if (document.readyState === 'loading') {
        document.addEventListener("DOMContentLoaded", initLiveMap);
    } else {
        initLiveMap();
    }

    if (!window._tbContactPjaxBound) {
        window._tbContactPjaxBound = true;
        window.addEventListener('tb:pjax:loaded', initLiveMap);
    }

    window.switchMapView = function switchMapView(viewType) {
        if (!map) return;
        const btnLeaflet = document.getElementById('btn-view-leaflet');
        const btnGoogle = document.getElementById('btn-view-google');

        if (currentTileLayer) {
            map.removeLayer(currentTileLayer);
        }

        const activeClass = 'bg-white text-gray-800 shadow-2xs rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer';
        const inactiveClass = 'bg-transparent text-gray-500 hover:text-gray-700 rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer';

        if (viewType === 'satellite' || viewType === 'google') {
            currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=y&hl=id&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            if (btnGoogle) btnGoogle.className = activeClass;
            if (btnLeaflet) btnLeaflet.className = inactiveClass;
        } else {
            currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&hl=id&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            if (btnLeaflet) btnLeaflet.className = activeClass;
            if (btnGoogle) btnGoogle.className = inactiveClass;
        }

        map.invalidateSize();
    };

    window.toggleFaqItem = function toggleFaqItem(button) {
        const item = button.closest('.faq-item');
        if (!item) return;
        const body = item.querySelector('.faq-body');
        const chevron = item.querySelector('.faq-chevron');
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        if (isHidden) {
            body.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        } else {
            body.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    };

    window.handleContactSubmit = function handleContactSubmit(event) {
        event.preventDefault();
        const name = document.getElementById('contact-name').value;

        Swal.fire({
            icon: 'success',
            title: 'Pesan Terkirim!',
            text: `Terima kasih ${name}, pesan Anda telah diterima oleh tim Toon Burger. Kami akan segera menghubungi Anda.`,
            confirmButtonColor: '#415C58',
            confirmButtonText: 'Selesai',
            customClass: { popup: 'rounded-3xl' }
        });

        event.target.reset();
    };
})();

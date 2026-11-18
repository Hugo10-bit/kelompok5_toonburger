// Toon Burger Offline & Asset Cache Service Worker
const CACHE_NAME = 'toonburger-offline-v6';
const PRECACHE_ASSETS = [
    '/manifest.json',
    '/offline.html',
    '/images/icon-192.png',
    '/images/icon-512.png',
    '/images/icon-512-maskable.png',
    '/images/toon-head.png',
    '/images/hero-burger-real.png',
    '/images/star-sparkle.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS);
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    // Only handle GET requests
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);
    if (url.origin !== self.location.origin) return;
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/pos')) return;

    // For HTML navigation requests (page loads)
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(async () => {
                // Network failed (e.g. Laragon stopped, connection refused, offline)
                const cache = await caches.open(CACHE_NAME);
                const cachedOffline = await cache.match('/offline.html');
                return cachedOffline || Response.error();
            })
        );
        return;
    }

    // Cache-First for immutable versioned Vite build assets and fast stale-while-revalidate for static images
    if (url.pathname.startsWith('/build/assets/') || url.pathname.startsWith('/images/')) {
        event.respondWith(
            caches.open(CACHE_NAME).then(async (cache) => {
                const cached = await cache.match(event.request);
                const networkFetch = fetch(event.request)
                    .then((res) => {
                        if (res && res.ok) {
                            cache.put(event.request, res.clone());
                        }
                        return res;
                    })
                    .catch(() => null);

                if (cached) {
                    if (url.pathname.startsWith('/images/')) {
                        event.waitUntil(networkFetch);
                    }
                    return cached;
                }

                const fresh = await networkFetch;
                if (fresh) return fresh;
                if (event.request.destination === 'image') {
                    return cache.match('/images/toon-head.png');
                }
                return Response.error();
            })
        );
        return;
    }

    // For cached static assets (fonts, js, offline assets)
    event.respondWith(
        fetch(event.request).catch(async () => {
            const cachedResponse = await caches.match(event.request);
            if (cachedResponse) return cachedResponse;
            if (event.request.destination === 'image') {
                const cache = await caches.open(CACHE_NAME);
                return cache.match('/images/toon-head.png');
            }
            return Response.error();
        })
    );
});


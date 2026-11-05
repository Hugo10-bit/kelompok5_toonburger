// Toon Burger Offline Fallback Service Worker
const CACHE_NAME = 'toonburger-offline-v1';
const PRECACHE_ASSETS = [
    '/offline.html',
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

    // For cached static assets (images, fonts, offline assets)
    event.respondWith(
        fetch(event.request).catch(async () => {
            const cachedResponse = await caches.match(event.request);
            if (cachedResponse) return cachedResponse;
            // If an image fails to load while offline, return the cached mascot head if available
            if (event.request.destination === 'image') {
                const cache = await caches.open(CACHE_NAME);
                return cache.match('/images/toon-head.png');
            }
            return Response.error();
        })
    );
});

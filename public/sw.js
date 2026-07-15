const CACHE_NAME = 'byiza-v2';
const OFFLINE_FALLBACK = '/';

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.add(OFFLINE_FALLBACK))
    );
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    const { request } = event;
    if (request.method !== 'GET') return;

    const url = new URL(request.url);
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/api') || url.pathname.startsWith('/csrf-token')) return;

    // Hashed build assets never change for a given filename: cache-first is safe.
    if (url.pathname.startsWith('/build/assets/')) {
        event.respondWith(
            caches.match(request).then(cached => cached || fetch(request).then(response => {
                if (response && response.status === 200) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                }
                return response;
            }))
        );
        return;
    }

    // Everything else (pages, images, manifest): NETWORK-FIRST.
    // Fresh content always wins; the cache is only an offline fallback.
    event.respondWith(
        fetch(request).then(response => {
            if (response && response.status === 200 && response.type === 'basic') {
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
            }
            return response;
        }).catch(() =>
            caches.match(request).then(cached => cached || caches.match(OFFLINE_FALLBACK))
        )
    );
});

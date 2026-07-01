const CACHE_NAME = 'nyumbahub-cache-v1';
const STATIC_CACHE = 'nyumbahub-static-v1';
const IMAGE_CACHE = 'nyumbahub-images-v1';
const DYNAMIC_CACHE = 'nyumbahub-dynamic-v1';

const OFFLINE_URL = '/offline.html';

const STATIC_ASSETS = [
    '/',
    OFFLINE_URL,
    '/css/app.css',
    '/css/home.css',
    '/css/listings.css',
    '/css/auth.css',
    '/css/dashboard-premium.css',
    '/css/admin.css',
    '/js/pwa.js',
    '/images/nyumbahublogo.png'
];

const EXCLUDED_ROUTES = [
    '/login',
    '/register',
    '/admin',
    '/agent',
    '/password',
    '/payment',
    '/logout'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (![CACHE_NAME, STATIC_CACHE, IMAGE_CACHE, DYNAMIC_CACHE].includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Helper to check if a request URL matches excluded routes
const isExcluded = (url) => {
    return EXCLUDED_ROUTES.some(route => url.pathname.includes(route));
};

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // 1. Exclude sensitive routes (Always network only)
    if (isExcluded(url) || request.method !== 'GET') {
        return; // Let the browser handle it
    }

    // 2. Static Assets (Cache First)
    if (
        url.pathname.endsWith('.css') || 
        url.pathname.endsWith('.js') || 
        url.pathname.endsWith('.woff2') || 
        url.pathname.endsWith('.ttf')
    ) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                if (cachedResponse) return cachedResponse;
                return fetch(request).then((networkResponse) => {
                    return caches.open(STATIC_CACHE).then((cache) => {
                        cache.put(request, networkResponse.clone());
                        return networkResponse;
                    });
                });
            })
        );
        return;
    }

    // 3. Images (Stale While Revalidate)
    if (request.destination === 'image') {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                const fetchPromise = fetch(request).then((networkResponse) => {
                    caches.open(IMAGE_CACHE).then((cache) => {
                        cache.put(request, networkResponse.clone());
                    });
                    return networkResponse;
                }).catch(() => {
                    // Ignore image fetch errors
                });
                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // 4. API Requests & HTML Pages (Network First, fallback to cache or offline page)
    if (request.destination === 'document' || url.pathname.startsWith('/api')) {
        event.respondWith(
            fetch(request).then((networkResponse) => {
                return caches.open(DYNAMIC_CACHE).then((cache) => {
                    cache.put(request, networkResponse.clone());
                    return networkResponse;
                });
            }).catch(() => {
                return caches.match(request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    if (request.destination === 'document') {
                        return caches.match(OFFLINE_URL);
                    }
                    return new Response(JSON.stringify({ error: 'Offline', message: 'You are currently offline.' }), {
                        headers: { 'Content-Type': 'application/json' }
                    });
                });
            })
        );
    }
});

// Prepare for Background Sync (Future placeholder)
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-bookings') {
        console.log('Background Sync: Preparing to sync offline bookings...');
    }
});

// Prepare for Push Notifications (Future placeholder)
self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'NyumbaHub';
    const options = {
        body: data.body || 'You have a new notification.',
        icon: '/images/nyumbahublogo.png',
        badge: '/images/nyumbahublogo.png',
        data: { url: data.url || '/' }
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});

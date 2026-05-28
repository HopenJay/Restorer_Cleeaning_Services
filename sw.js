const CACHE_NAME = 'restorer-cache-v1';
const ASSETS = [
    '/index.html',
    '/about_Us.html',
    '/contact.html',
    '/contact.css',
    '/services.html',
    '/images/Commercial_Cleaning.jpg'
];

// Installing the service worker and caching assets

self.addEventListener('install', (e) => {
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS);
        })
    );
});

// Serve cached assets when offline

self.addEventListener('fetch', (e) => {
    e.respondWith(
        caches.match(e.request).then((response) => {
            return response || fetch(e.request);
        })
    );
});
// Service Worker for WakafApp
// "Network Only" strategy to ensure changes are immediately visible as requested

self.addEventListener('install', (event) => {
    // Skip waiting to activate the new SW immediately
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    // Take control of all pages immediately
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', (event) => {
    // Always fetch from network, do not use cache
    event.respondWith(fetch(event.request).catch(() => {
        // Optional: show an offline page if you have one
        // return caches.match('/offline');
    }));
});

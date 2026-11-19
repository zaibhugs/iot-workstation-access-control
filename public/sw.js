/*
 * Minimal service worker — installability only.
 *
 * Chrome will not offer "Install app" unless a service worker with a fetch
 * handler is registered. This one deliberately caches NOTHING: every request
 * goes straight to the server, because workstation data must never be stale.
 *
 * No offline mode. No asset caching. No background sync.
 */

self.addEventListener('install', function () {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', function (event) {
    var request = event.request;

    // Let the browser handle non-GET requests normally.
    if (request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(request).catch(function () {
            return Response.error();
        })
    );
});

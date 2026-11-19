import './bootstrap';
import 'flowbite';

/*
 * Register the minimal service worker required for "Install app".
 * It only passes requests through to the network — nothing is cached.
 * Browsers require HTTPS or localhost; on a plain HTTP LAN address this
 * silently does nothing, and the in-app install guide is shown instead.
 */
if ('serviceWorker' in navigator && window.isSecureContext) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js').catch(function () {
            // Install prompt simply will not appear; the app still works.
        });
    });
}

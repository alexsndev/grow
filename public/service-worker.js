const CACHE_VERSION = 'v1.1.0';
const APP_CACHE = `grow-app-${CACHE_VERSION}`;
const CORE_ASSETS = [
  '/',
  '/manifest.webmanifest',
  '/favicon.ico',
  '/offline.html'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(APP_CACHE).then(cache => cache.addAll(CORE_ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => Promise.all(
      keys.filter(k => k.startsWith('grow-app-') && k !== APP_CACHE).map(k => caches.delete(k))
    ))
  );
  self.clients.claim();
});

self.addEventListener('fetch', event => {
  const req = event.request;
  if (req.method !== 'GET') return; // ignore non-get

  const urlPath = new URL(req.url).pathname;

  // Network first for HTML navigation with offline fallback
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req).then(res => {
        const copy = res.clone();
        caches.open(APP_CACHE).then(cache => cache.put(req, copy));
        return res;
      }).catch(() => caches.match(req).then(r => r || caches.match('/offline.html')))
    );
    return;
  }

  // Stale-while-revalidate for static assets
  if (/\.(?:css|js|png|jpg|jpeg|webp|svg|gif|ico|woff2?|ttf)$/i.test(urlPath)) {
    event.respondWith(
      caches.match(req).then(cached => {
        const fetchPromise = fetch(req).then(res => {
          const copy = res.clone();
            caches.open(APP_CACHE).then(cache => cache.put(req, copy));
          return res;
        }).catch(() => cached);
        return cached || fetchPromise;
      })
    );
    return;
  }
});

self.addEventListener('message', event => {
  if (event.data === 'SKIP_WAITING') self.skipWaiting();
});

const CACHE_NAME = 'escuchalo-fm-v1';
const urlsToCache = [
  '/',
  '/index.html',
  '/manifest.json',
  'https://i.imgur.com/Hblj7SQ.png'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((names) =>
      Promise.all(
        names.map((n) => n !== CACHE_NAME ? caches.delete(n) : null)
      )
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  if (event.request.url.match(/\.(mp3|aac|ogg|m3u8)$/)) return;

  event.respondWith(
    caches.match(event.request).then((res) =>
      res || fetch(event.request).then((fetchRes) => {
        return caches.open(CACHE_NAME).then((cache) => {
          if (event.request.method === 'GET' && fetchRes.status === 200) {
            cache.put(event.request, fetchRes.clone());
          }
          return fetchRes;
        });
      })
    ).catch(() => {
      if (event.request.mode === 'navigate') return caches.match('/index.html');
    })
  );
});

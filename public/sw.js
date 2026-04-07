// PRODUCTION-READY SERVICE WORKER FOR IMAGES
// Version: 1.0.0
const CACHE_NAME = 'zaylish-cache-v1';
const IMAGE_CACHE_NAME = 'zaylish-images-v1';

// Assets to cache immediately on install
const PRECACHE_ASSETS = [
  // Add your most critical images here
  '/offline.svg',
  '/favicon.ico'
];

// Install event - precache critical assets
self.addEventListener('install', event => {
  console.log('Service Worker: Installing...');

  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(PRECACHE_ASSETS))
      .then(() => self.skipWaiting())
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
  console.log('Service Worker: Activating...');

  event.waitUntil(
    Promise.all([
      // Clean old caches
      caches.keys().then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheName !== CACHE_NAME && cacheName !== IMAGE_CACHE_NAME) {
              console.log('Service Worker: Deleting old cache:', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      }),
      // Take control immediately
      self.clients.claim()
    ])
  );
});

// Helper: Check if request is for an image
const isImageRequest = (request) => {
  return request.destination === 'image' ||
         /\.(jpg|jpeg|png|gif|webp|svg|ico|avif|bmp)$/i.test(request.url);
};

// Helper: Create fallback image
const createFallbackImage = () => {
  return new Response(
    `<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg">
      <rect width="400" height="400" fill="#f0f0f0"/>
      <text x="50%" y="50%" text-anchor="middle" fill="#999" font-family="Arial" font-size="14">
        Image unavailable
      </text>
    </svg>`,
    {
      headers: {
        'Content-Type': 'image/svg+xml',
        'Cache-Control': 'no-store'
      }
    }
  );
};

// Fetch event - OPTIMIZED FOR SPEED
self.addEventListener('fetch', event => {
  const { request } = event;

  // Only handle image requests
  if (!isImageRequest(request)) {
    return; // Let browser handle non-image requests normally
  }

  // FAST CACHE-FIRST STRATEGY
  event.respondWith(
    (async () => {
      // Try cache first (SUPER FAST)
      const cache = await caches.open(IMAGE_CACHE_NAME);
      const cachedResponse = await cache.match(request);

      if (cachedResponse) {
        // Found in cache - return immediately (milliseconds)
        console.log('✅ Image from cache:', request.url);
        return cachedResponse;
      }

      // Not in cache - fetch from network
      try {
        console.log('🌐 Image from network:', request.url);
        const networkResponse = await fetch(request);

        // Cache successful responses for next time
        if (networkResponse && networkResponse.status === 200) {
          // Clone response before caching
          const responseToCache = networkResponse.clone();
          cache.put(request, responseToCache).catch(() => {});
        }

        return networkResponse;
      } catch (error) {
        console.log('❌ Image failed:', request.url);
        // Return fallback if offline
        return createFallbackImage();
      }
    })()
  );
});

// Optional: Background sync for failed requests
self.addEventListener('sync', event => {
  if (event.tag === 'image-sync') {
    console.log('Service Worker: Syncing failed image requests');
    // Implement retry logic here
  }
});

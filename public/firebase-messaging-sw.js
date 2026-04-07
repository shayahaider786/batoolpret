// Import Firebase scripts
importScripts('https://www.gstatic.com/firebasejs/12.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/12.7.0/firebase-messaging-compat.js');

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAKvYZRyQtyxa7j3rSWGF1jliF4QTh7y2E",
    authDomain: "zaylish-56f79.firebaseapp.com",
    projectId: "zaylish-56f79",
    storageBucket: "zaylish-56f79.firebasestorage.app",
    messagingSenderId: "844375879908",
    appId: "1:844375879908:web:ad0784e22383426f46fcf1",
    measurementId: "G-B871GGYC5P"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    
    const notificationTitle = payload.notification?.title || 'New Notification';
    const notificationOptions = {
        body: payload.notification?.body || '',
        icon: payload.notification?.icon || '/frontend/images/icons/favicon.png',
        badge: '/frontend/images/icons/favicon.png',
        tag: payload.data?.product_id || 'notification',
        data: payload.data || {},
        requireInteraction: false,
        silent: false,
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('[firebase-messaging-sw.js] Notification click received.');
    
    event.notification.close();

    // Get the URL from notification data
    let urlToOpen = event.notification.data?.click_action || 
                   event.notification.data?.url || 
                   '/';
    
    // Ensure URL is absolute
    if (urlToOpen.startsWith('/')) {
        urlToOpen = self.location.origin + urlToOpen;
    }

    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then((clientList) => {
            // Check if there's already a window/tab open with the target URL
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url === urlToOpen && 'focus' in client) {
                    return client.focus();
                }
            }
            // If no window is open, open a new one
            if (clients.openWindow) {
                return clients.openWindow(urlToOpen);
            }
        })
    );
});


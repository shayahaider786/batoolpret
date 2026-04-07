# Firebase Cloud Messaging (FCM) Setup Guide

## Overview
This application uses Firebase Cloud Messaging (FCM) to send web push notifications to users when new products are added.

## Prerequisites
1. Firebase project created at https://console.firebase.google.com/
2. Firebase Server Key (Legacy Server Key) from Firebase Console

## Setup Instructions

### 1. Configure Firebase for Web Push

**Option A: Enable Legacy API (Simpler - Recommended for now)**
1. Go to Firebase Console: https://console.firebase.google.com/
2. Select your project: `zaylish-56f79`
3. Go to Project Settings (gear icon) → Cloud Messaging
4. Under "Cloud Messaging API (Legacy)", click **Enable**
5. Copy the **Server Key** - This is your `FIREBASE_SERVER_KEY`

**Option B: Use V1 API (Recommended for production)**
1. Go to Firebase Console → Project Settings → Service Accounts
2. Click "Generate New Private Key" to download Service Account JSON
3. Store the JSON file securely (not in public directory)
4. Use the Service Account for V1 API authentication

**VAPID Key (Already configured)**
- Your VAPID key is already set in the code: `BMT7Qjk9VJnzm-Tyl0tZAiOAYVYBTtPnBAAepYr2p8kDvmdiZfYfMfcI3R71qi20sNyEpfpO5FIJ6FAjM-kP1Rw`
- This is used for frontend token generation
- You can override it in `.env` if needed

### 2. Add Environment Variables
Add the following to your `.env` file:

```env
# Firebase Configuration
FIREBASE_API_KEY=AIzaSyAKvYZRyQtyxa7j3rSWGF1jliF4QTh7y2E
FIREBASE_AUTH_DOMAIN=zaylish-56f79.firebaseapp.com
FIREBASE_PROJECT_ID=zaylish-56f79
FIREBASE_STORAGE_BUCKET=zaylish-56f79.firebasestorage.app
FIREBASE_MESSAGING_SENDER_ID=844375879908
FIREBASE_APP_ID=1:844375879908:web:ad0784e22383426f46fcf1
FIREBASE_MEASUREMENT_ID=G-B871GGYC5P

# VAPID Key (for Web Push - already configured, optional to override)
FIREBASE_VAPID_KEY=BMT7Qjk9VJnzm-Tyl0tZAiOAYVYBTtPnBAAepYr2p8kDvmdiZfYfMfcI3R71qi20sNyEpfpO5FIJ6FAjM-kP1Rw

# Server Key (Legacy API - Enable Legacy API in Firebase Console first)
FIREBASE_SERVER_KEY=YOUR_SERVER_KEY_HERE
```

**Important:** 
- If using Legacy API: Enable it in Firebase Console and add the Server Key
- If Legacy API is disabled, you'll need to use V1 API with Service Account (more complex setup)

### 3. Run Migration
```bash
php artisan migrate
```

This will create the `device_tokens` table to store FCM tokens.

### 4. Test the Implementation

1. **Frontend Test:**
   - Visit your website
   - Allow notification permission when prompted
   - Check browser console for FCM token
   - Verify token is stored in database

2. **Backend Test:**
   - Create a new product in admin panel
   - Check if notification is sent to all registered devices
   - Check Laravel logs for any errors

## How It Works

### Frontend Flow:
1. User visits website
2. Browser requests notification permission
3. If granted, Firebase SDK initializes
4. FCM token is retrieved
5. Token is sent to Laravel backend via AJAX
6. Service worker handles background notifications

### Backend Flow:
1. When a new product is created in `ProductController@store`
2. `FirebaseNotificationService` sends notification to all active tokens
3. Notification includes product name, URL, and metadata
4. Invalid tokens are automatically cleaned up

## Files Created/Modified

### New Files:
- `database/migrations/2026_01_02_152016_create_device_tokens_table.php`
- `app/Models/DeviceToken.php`
- `app/Services/FirebaseNotificationService.php`
- `app/Http/Controllers/NotificationController.php`
- `public/firebase-messaging-sw.js`

### Modified Files:
- `resources/views/layouts/frontend.blade.php` - Added Firebase SDK and notification logic
- `app/Http/Controllers/ProductController.php` - Added notification trigger
- `config/services.php` - Added Firebase configuration
- `routes/web.php` - Added notification routes

## API Endpoints

### Store Device Token
```
POST /notifications/token
Body: {
    token: "FCM_TOKEN",
    browser: "Chrome",
    device: "Desktop",
    platform: "Windows"
}
```

### Remove Device Token
```
DELETE /notifications/token
Body: {
    token: "FCM_TOKEN"
}
```

## Troubleshooting

### Notifications Not Working?

1. **Check Browser Support:**
   - Ensure browser supports Service Workers and Notifications API
   - Chrome, Firefox, Edge (Chromium) are supported
   - Safari has limited support

2. **Check Permission:**
   - User must grant notification permission
   - Check browser notification settings

3. **Check Service Worker:**
   - Open DevTools → Application → Service Workers
   - Ensure `firebase-messaging-sw.js` is registered
   - Check for errors in console

4. **Check Server Key:**
   - Verify `FIREBASE_SERVER_KEY` is set in `.env`
   - Run `php artisan config:clear` after updating `.env`

5. **Check Logs:**
   - Check Laravel logs: `storage/logs/laravel.log`
   - Check browser console for JavaScript errors

### Invalid Token Errors

The system automatically deactivates invalid tokens. To manually clean up:
```sql
UPDATE device_tokens SET is_active = 0 WHERE token = 'INVALID_TOKEN';
```

## Security Notes

- Firebase Server Key should be kept secret
- Never commit `.env` file to version control
- Use HTTPS in production (required for service workers)
- Validate all incoming tokens on backend

## Future Enhancements

- Queue notifications for better performance
- Add notification preferences per user
- Support for notification categories
- Analytics for notification delivery rates


# Firebase VAPID Key Setup

## Your VAPID Key
Your Firebase Web Push certificate (VAPID key) is:
```
BMT7Qjk9VJnzm-Tyl0tZAiOAYVYBTtPnBAAepYr2p8kDvmdiZfYfMfcI3R71qi20sNyEpfpO5FIJ6FAjM-kP1Rw
```

## Current Status
- ✅ **VAPID Key**: Already configured in the code
- ✅ **Frontend**: Uses VAPID key for token generation
- ⚠️ **Backend**: Needs Legacy API Server Key OR V1 API Service Account

## Important Notes

### If Legacy API is Disabled:
The current implementation uses the Legacy FCM API endpoint which requires a Server Key. Since your Legacy API is disabled, you have two options:

#### Option 1: Enable Legacy API (Easiest)
1. Go to Firebase Console → Project Settings → Cloud Messaging
2. Under "Cloud Messaging API (Legacy)", click **Enable**
3. Copy the Server Key
4. Add to `.env`: `FIREBASE_SERVER_KEY=your_server_key`

#### Option 2: Migrate to V1 API (Recommended for production)
The V1 API requires Service Account credentials. This is more secure but requires additional setup:
1. Go to Firebase Console → Project Settings → Service Accounts
2. Generate and download Service Account JSON
3. Update `FirebaseNotificationService` to use V1 API endpoints
4. Use OAuth2 authentication instead of Server Key

## Current Implementation
- **Frontend**: ✅ Uses VAPID key (already working)
- **Backend**: ⚠️ Uses Legacy API (needs Server Key or migration to V1)

## Quick Fix
To get notifications working immediately:
1. Enable Legacy API in Firebase Console
2. Get the Server Key
3. Add to `.env`: `FIREBASE_SERVER_KEY=your_key_here`
4. Run: `php artisan config:clear`

The VAPID key is already correctly configured in the frontend code!


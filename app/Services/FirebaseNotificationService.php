<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class FirebaseNotificationService
{
    protected $fcmUrl;
    protected $serverKey;

    public function __construct()
    {
        $this->fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $this->serverKey = config('services.firebase.server_key');
        
        // Check if server key is configured
        if (empty($this->serverKey)) {
            Log::warning('Firebase Server Key is not configured. Please enable Legacy API in Firebase Console or migrate to V1 API.');
        } else {
            Log::info('Firebase Server Key is configured', [
                'key_length' => strlen($this->serverKey),
                'key_prefix' => substr($this->serverKey, 0, 10) . '...',
            ]);
        }
    }

    /**
     * Send notification to a single device token
     */
    public function sendToDevice(string $token, string $title, string $body, array $data = []): bool
    {
        if (empty($this->serverKey)) {
            Log::error('Firebase Server Key is not configured');
            return false;
        }

        $payload = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'icon' => asset('frontend/images/icons/favicon.png'),
                'click_action' => $data['url'] ?? url('/'),
            ],
            'data' => array_merge([
                'click_action' => $data['url'] ?? url('/'),
            ], $data),
        ];

        return $this->sendRequest($payload, $token);
    }

    /**
     * Send notification to multiple device tokens
     */
    public function sendToMultipleDevices(array $tokens, string $title, string $body, array $data = []): array
    {
        if (empty($this->serverKey)) {
            Log::error('Firebase Server Key is not configured');
            return ['success' => 0, 'failure' => count($tokens)];
        }

        // FCM allows up to 1000 tokens per batch
        $chunks = array_chunk($tokens, 1000);
        $results = ['success' => 0, 'failure' => 0, 'invalid_tokens' => []];

        foreach ($chunks as $chunk) {
            $payload = [
                'registration_ids' => $chunk,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'icon' => asset('frontend/images/icons/favicon.png'),
                    'click_action' => $data['url'] ?? url('/'),
                ],
                'data' => array_merge([
                    'click_action' => $data['url'] ?? url('/'),
                ], $data),
            ];

            $response = $this->sendBatchRequest($payload);
            $results['success'] += $response['success'];
            $results['failure'] += $response['failure'];
            
            // Track invalid tokens for cleanup
            if (isset($response['invalid_tokens'])) {
                $results['invalid_tokens'] = array_merge($results['invalid_tokens'], $response['invalid_tokens']);
            }
        }

        // Clean up invalid tokens
        if (!empty($results['invalid_tokens'])) {
            $this->cleanupInvalidTokens($results['invalid_tokens']);
        }

        return $results;
    }

    /**
     * Send notification to all active device tokens
     */
    public function sendToAll(string $title, string $body, array $data = []): array
    {
        $tokens = DeviceToken::where('is_active', true)
            ->pluck('token')
            ->toArray();

        if (empty($tokens)) {
            Log::info('No active device tokens found for push notification');
            return ['success' => 0, 'failure' => 0];
        }

        Log::info('Sending push notification to all devices', [
            'title' => $title,
            'body' => $body,
            'token_count' => count($tokens),
        ]);

        return $this->sendToMultipleDevices($tokens, $title, $body, $data);
    }

    /**
     * Send HTTP request to FCM
     */
    protected function sendRequest(array $payload, string $token): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->post($this->fcmUrl, $payload);

            if ($response->successful()) {
                $result = $response->json();
                
                // Check if token is invalid
                if (isset($result['results'][0]['error'])) {
                    $error = $result['results'][0]['error'];
                    if (in_array($error, ['InvalidRegistration', 'NotRegistered'])) {
                        $this->deactivateToken($token);
                    }
                    Log::warning("FCM error for token: {$error}");
                    return false;
                }

                return true;
            }

            Log::error('FCM request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('FCM request exception', [
                'message' => $e->getMessage(),
                'token' => substr($token, 0, 20) . '...',
            ]);

            return false;
        }
    }

    /**
     * Send batch request to FCM
     */
    protected function sendBatchRequest(array $payload): array
    {
        try {
            if (empty($this->serverKey)) {
                Log::error('Cannot send FCM batch request: Server key is empty');
                return ['success' => 0, 'failure' => count($payload['registration_ids']), 'invalid_tokens' => []];
            }

            Log::info('Sending FCM batch request', [
                'token_count' => count($payload['registration_ids']),
                'title' => $payload['notification']['title'] ?? 'N/A',
                'body' => $payload['notification']['body'] ?? 'N/A',
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->post($this->fcmUrl, $payload);

            if ($response->successful()) {
                $result = $response->json();
                $success = $result['success'] ?? 0;
                $failure = $result['failure'] ?? 0;
                $invalidTokens = [];

                // Extract invalid tokens
                if (isset($result['results'])) {
                    foreach ($result['results'] as $index => $item) {
                        if (isset($item['error'])) {
                            $error = $item['error'];
                            Log::warning('FCM token error', [
                                'error' => $error,
                                'token_index' => $index,
                            ]);
                            if (in_array($error, ['InvalidRegistration', 'NotRegistered'])) {
                                $invalidTokens[] = $payload['registration_ids'][$index];
                            }
                        }
                    }
                }

                Log::info('FCM batch request completed', [
                    'success' => $success,
                    'failure' => $failure,
                    'invalid_count' => count($invalidTokens),
                ]);

                return [
                    'success' => $success,
                    'failure' => $failure,
                    'invalid_tokens' => $invalidTokens,
                ];
            }

            Log::error('FCM batch request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'response_data' => $response->json(),
            ]);

            return ['success' => 0, 'failure' => count($payload['registration_ids']), 'invalid_tokens' => []];
        } catch (\Exception $e) {
            Log::error('FCM batch request exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ['success' => 0, 'failure' => count($payload['registration_ids']), 'invalid_tokens' => []];
        }
    }

    /**
     * Deactivate invalid token
     */
    protected function deactivateToken(string $token): void
    {
        DeviceToken::where('token', $token)->update(['is_active' => false]);
    }

    /**
     * Clean up multiple invalid tokens
     */
    protected function cleanupInvalidTokens(array $tokens): void
    {
        DeviceToken::whereIn('token', $tokens)->update(['is_active' => false]);
        Log::info('Deactivated invalid FCM tokens', ['count' => count($tokens)]);
    }
}


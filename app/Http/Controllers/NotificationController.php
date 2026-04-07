<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Store or update device token
     */
    public function storeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'browser' => 'nullable|string|max:255',
            'device' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $userId = Auth::check() ? Auth::id() : null;
            $token = $request->input('token');

            // Check if token already exists
            $deviceToken = DeviceToken::where('token', $token)->first();

            if ($deviceToken) {
                // Update existing token
                $deviceToken->update([
                    'user_id' => $userId,
                    'browser' => $request->input('browser'),
                    'device' => $request->input('device'),
                    'platform' => $request->input('platform'),
                    'is_active' => true,
                    'last_used_at' => now(),
                ]);
            } else {
                // Create new token
                $deviceToken = DeviceToken::create([
                    'token' => $token,
                    'user_id' => $userId,
                    'browser' => $request->input('browser'),
                    'device' => $request->input('device'),
                    'platform' => $request->input('platform'),
                    'is_active' => true,
                    'last_used_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Device token stored successfully',
                'data' => $deviceToken,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error storing device token', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to store device token',
            ], 500);
        }
    }

    /**
     * Remove device token
     */
    public function removeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Token is required',
            ], 422);
        }

        try {
            DeviceToken::where('token', $request->input('token'))->delete();

            return response()->json([
                'success' => true,
                'message' => 'Device token removed successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error removing device token', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove device token',
            ], 500);
        }
    }
}

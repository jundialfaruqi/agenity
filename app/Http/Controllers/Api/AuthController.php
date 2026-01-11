<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Handle user login and issue token.
     *
     * Use this endpoint to get an authentication token.
     * You can copy the `token` from the response and use it in the **Get authenticated user details** endpoint.
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = 'login-attempts:' . $request->ip();
        $maxAttempts = 4;

        // 1. Cek apakah sudah terkena limit
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'status' => 'error',
                'message' => "Terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        $user = User::where('email', $request->email)->first();

        // 2. Cek kredensial
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Tambahkan hit hanya saat GAGAL
            RateLimiter::hit($key, 60); // Decay 1 menit

            $remaining = RateLimiter::remaining($key, $maxAttempts);

            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah. ' . ($remaining > 0
                    ? "Sisa percobaan: {$remaining} kali lagi."
                    : "Anda telah mencapai batas percobaan. Silakan tunggu 1 menit."),
                'attempts_left' => $remaining,
            ], 401);
        }

        // 3. Jika BERHASIL, hapus catatan kegagalan
        RateLimiter::clear($key);

        // Set expiration time
        $expiresAt = Carbon::now()->addMinutes(config('sanctum.expiration', 1440));

        $token = $user->createToken('auth_token', ['*'], $expiresAt)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'id' => $user->id,
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiresAt->toDateTimeString(),
            ]
        ]);
    }

    /**
     * Get authenticated user details.
     *
     * Returns the details of the currently authenticated user including their role, permissions, and OPD information.
     * If the user status is not active, the session will be terminated.
     * 
     * @response {
     *  "status": "success",
     *  "message": "User details retrieved",
     *  "data": {
     *    "name": "User Example",
     *    "email": "user@example.com",
     *    "status": "active",
     *    "phone": "+6281234567893",
     *    "address": "Jl. Example No. 3",
     *    "role": "user-example",
     *    "permissions": ["view-example", "add-example"],
     *    "photo": "avatars/uuid.png",
     *    "photo_url": "http://localhost/storage/avatars/uuid.png",
     *    "opd": {
     *      "id": 1,
     *      "name": "Dinas Komunikasi Informatika dan Statistik",
     *      "singkatan": "DISKOMINFO",
     *      "logo_url": "http://localhost/storage/opd_logos/uuid.png"
     *    }
     *  }
     * }
     */
    public function me(Request $request)
    {
        $user = $request->user();

        // Check if user status is not active
        if ($user->status !== 'active') {
            // Revoke the current token
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => 'error',
                'message' => 'Your account is not active. Session terminated.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User details retrieved',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'phone' => $user->phone,
                'address' => $user->address,
                'role' => $user->getRoleNames()->first(),
                'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                'photo' => $user->photo,
                'photo_url' => $user->photo_url,
                'opd' => $user->opdMaster ? [
                    'id' => $user->opdMaster->id,
                    'name' => $user->opdMaster->name,
                    'singkatan' => $user->opdMaster->singkatan,
                    'logo_url' => $user->opdMaster->logo_url,
                ] : null,
            ]
        ]);
    }

    /**
     * Logout and revoke token.
     *
     * Revokes the current access token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }
}

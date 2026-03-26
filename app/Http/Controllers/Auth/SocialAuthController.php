<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;

class SocialAuthController extends Controller
{
    use ApiResponse;

    // Step 1: Generate Google auth URL
    public function getGoogleAuthUrl(): JsonResponse
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return $this->success([
            'auth_url' => $url
        ], 'Google auth url generated');
    }

    // Step 2: Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName() ?? 'User',
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('12345678'), // Default password
                    'is_verified' => true,
                ]);
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;
            return redirect("http://127.0.0.1:8000");
        } catch (\Exception $e) {
            return redirect("http://127.0.0.1:8000/api/login");
        }
    }
}

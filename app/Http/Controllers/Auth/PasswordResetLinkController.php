<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    use ApiResponse;
    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('User not found', 404);
        }

        $otp = '1234';
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(3);
        $user->save();
        return $this->success([
            'email' => $user->email,
            'otp' => $otp,
        ], 'OTP sent successfully');
    }
}

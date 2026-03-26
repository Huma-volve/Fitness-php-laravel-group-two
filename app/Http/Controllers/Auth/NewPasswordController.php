<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    use ApiResponse;
    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {

            return $this->error('Invalid email or OTP', 400);
        }

        if ($user->otp_expires_at < now()) {
            return $this->error('OTP expired', 400);
        }


        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
        $user->tokens()->delete();
        return $this->success(null, 'Password reset successfully');
    }
}

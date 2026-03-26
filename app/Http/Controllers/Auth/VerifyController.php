<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    use ApiResponse;
    public function verifyOtp(VerifyOtpRequest $request)
    {


        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {
            return $this->error('Invalid OTP or email', 400);
        }

        if ($user->otp_expires_at < now()) {
            return $this->error('OTP expired', 400);
        }

        $user->is_verified = true;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return $this->success(null, 'OTP verified successfully');
    }
    // resend OTP method
    public function resendOtp(ResendOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('User not found', 404);
        }

        if ($user->is_verified) {
            return $this->error('User already verified', 400);
        }

        $otp = '1234';
        $user->otp = $otp;

        $user->otp_expires_at = now()->addMinutes(3);
        $user->save();
        return $this->success(['otp' => $otp], 'OTP resent successfully');
    }
}

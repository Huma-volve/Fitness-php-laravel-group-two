<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\VerifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/verify-otp', [VerifyController::class, 'verifyOtp']);
Route::post('/resend-otp', [VerifyController::class, 'resendOtp']);
Route::get('/auth/google/redirect', [SocialAuthController::class, 'getGoogleAuthUrl']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
require __DIR__ . '/auth.php';

Route::apiResource('packages', PackageController::class);
Route::apiResource('Booking', BookingController::class);
Route::get('/Booking/confirm/{id}', [BookingController::class, 'confirm']);
Route::get('/Booking/cancel/{id}', [BookingController::class, 'cancel']);
Route::post('/Booking/reschedule/{id}', [BookingController::class, 'reschedule']);

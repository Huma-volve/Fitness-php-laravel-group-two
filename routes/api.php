<?php

use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Auth\VerifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/verify-otp', [VerifyController::class, 'verifyOtp']);
Route::post('/resend-otp', [VerifyController::class, 'resendOtp']);

require __DIR__ . '/auth.php';

Route::apiResource('packages', PackageController::class);

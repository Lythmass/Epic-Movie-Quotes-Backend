<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['guest'])->group(function () {
    Route::post('/register', [RegistrationController::class, 'store']);
    Route::post('/login', [AuthController::class, 'store']);

    Route::post('/forgot', [PasswordResetController::class, 'send']);
    Route::post('/reset', [PasswordResetController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email/verify', [RegistrationController::class, 'sendEmailVerificationRequest']);
});

Route::get('/email/verify/{id}/{hash}', [RegistrationController::class, 'verifyEmail'])->name('verification.verify');

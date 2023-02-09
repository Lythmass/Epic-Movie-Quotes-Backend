<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePictureController;
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

    Route::post('/google-auth', [GoogleAuthController::class, 'login']);
});
Route::get('/google/redirect', [GoogleAuthController::class, 'index']);
Route::get('/google/callback', [GoogleAuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email/verify', [RegistrationController::class, 'sendEmailVerificationRequest']);
    Route::get('/get-user-data', [ProfileController::class, 'sendUserData']);
    Route::post('/post-user-data', [ProfileController::class, 'store']);
    Route::post('/add-new-email', [EmailsController::class, 'store']);
    Route::post('/delete-email', [EmailsController::class, 'destroy']);
    Route::post('/change-primary-email', [EmailsController::class, 'update']);
    Route::post('/upload-photo', [ProfilePictureController::class, 'store']);
});

Route::get('/email/verify/{id}/{hash}', [RegistrationController::class, 'verifyEmail'])->name('verification.verify');
Route::get('/secondary-email/verify/{id}/{hash}/{email}', [EmailsController::class, 'verifyEmail']);

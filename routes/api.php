<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegistrationController::class, 'store'])->middleware('guest');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email/verify', [RegistrationController::class, 'sendEmailVerificationRequest']);
});
Route::get('/email/verify/{id}/{hash}', [RegistrationController::class, 'verifyEmail'])->name('verification.verify');

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['guest'])->group(function () {
    Route::post('/register', [RegistrationController::class, 'store']);
    Route::post('/login', [AuthController::class, 'store']);

    Route::post('/forgot', [PasswordResetController::class, 'send']);
    Route::post('/reset', [PasswordResetController::class, 'update']);

    Route::post('/google-auth', [GoogleAuthController::class, 'login']);
    Route::get('/google/redirect', [GoogleAuthController::class, 'index']);
    Route::get('/google/callback', [GoogleAuthController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email/verify', [RegistrationController::class, 'sendEmailVerificationRequest']);
    Route::post('/post-user-data', [ProfileController::class, 'store']);
    Route::post('/add-new-email', [EmailsController::class, 'store']);
    Route::post('/delete-email', [EmailsController::class, 'destroy']);
    Route::post('/change-primary-email', [EmailsController::class, 'update']);
    Route::post('/upload-photo', [ProfilePictureController::class, 'store']);
    Route::post('/upload-movie', [MoviesController::class, 'store']);
    Route::post('/delete-movie', [MoviesController::class, 'destroy']);
    Route::post('/update-movie', [MoviesController::class, 'update']);

    Route::get('/get-user-data', [ProfileController::class, 'sendUserData']);
    Route::get('/genres', [GenresController::class, 'index']);
    Route::get('/movies', [MoviesController::class, 'index']);

    Route::post('/upload-quote', [QuotesController::class, 'store']);
    Route::post('/get-quotes', [QuotesController::class, 'index']);
    Route::post('/update-quote', [QuotesController::class, 'update']);
    Route::post('/delete-quote', [QuotesController::class, 'destroy']);

    Route::post('/news-feed/quotes', [NewsFeedController::class, 'index']);
    Route::post('/news-feed/post', [NewsFeedController::class, 'store']);
    Route::get('/news-feed/number-of-quotes', [NewsFeedController::class, 'getNumberOfQuotes']);

    Route::get('/news-feed/comments', [CommentsController::class, 'index']);
    Route::post('/news-feed/post-comment', [CommentsController::class, 'store']);

    Route::get('/news-feed/likes', [LikesController::class, 'index']);
    Route::post('/news-feed/like', [LikesController::class, 'store']);
    Route::post('/news-feed/unlike', [LikesController::class, 'destroy']);

    Route::post('/notifications/get-messages', [NotificationsController::class, 'index']);
    Route::post('/notifications/mark-all-as-read', [NotificationsController::class, 'update']);
});

Route::get('/email/verify/{id}/{hash}', [RegistrationController::class, 'verifyEmail'])->name('verification.verify');
Route::get('/secondary-email/verify/{id}/{hash}/{email}', [EmailsController::class, 'verifyEmail']);

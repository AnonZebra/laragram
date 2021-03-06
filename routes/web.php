<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Locale\LocaleController;
use App\Http\Controllers\Photo\PhotoController;
use App\Http\Controllers\ProfileController;

Route::middleware(['guest'])->name('guest.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('showLogin');

    Route::post('/login', [AuthController::class, 'processLogin'])
        ->name('processLogin');

    Route::get('/register', [AuthController::class, 'showRegistration'])
        ->name('showRegistration');

    Route::post('/register', [AuthController::class, 'processRegistration'])
        ->name('processRegistration');
});

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])
        ->name('profile');

    Route::post('/foo', [ProfileController::class, 'processUpdateProfile'])
        ->name('processUpdateProfile');

    Route::post('/logout', [AuthController::class, 'processLogout'])
        ->name('processLogout');

    Route::get('/photo/add', [PhotoController::class, 'showPhotoForm'])
        ->name('showPhotoForm');

    Route::post('/photo/submit', [PhotoController::class, 'processPhotoForm'])
        ->name('processPhotoForm');

    Route::get('/user/{photoOwnerId}/photos/{photoId}/comment', [PhotoController::class, 'showPhotoCommentForm'])
        ->name('showPhotoCommentForm');

    Route::post('/user/{photoOwnerId}/photos/{photoId}/comment', [PhotoController::class, 'processPhotoCommentForm'])
        ->name('processPhotoCommentForm');
});

Route::get('/set-locale/{language}', [LocaleController::class, 'updateLocale'])->name('updateLocale');

Route::get('/user/{photoOwnerId}/photos', [PhotoController::class, 'showPhotoList'])
    ->name('showPhotoList');

Route::get('/user/{photoOwnerId}/photos/{photoId}', [PhotoController::class, 'showPhotoDetail'])
    ->name('showPhotoDetail');

Route::get('/', [PhotoController::class, 'showUserList'])
    ->name('newUsers');

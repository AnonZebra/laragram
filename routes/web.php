<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests\LoginFormRequest;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Locale\LocaleController;

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
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'processLogout'])
        ->name('processLogout');
});

Route::get('/set-locale/{language}', [LocaleController::class, 'updateLocale'])->name('updateLocale');

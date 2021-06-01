<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests\LoginFormRequest;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Locale\LocaleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->name('guest.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');

    Route::post('/login', [AuthController::class, 'processLogin'])->name('processLogin');
});

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/logout', [AuthController::class, 'processLogout'])->name('processLogout');
});

Route::get('/set-locale/{language}', [LocaleController::class, 'updateLocale'])->name('updateLocale');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('home.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/register', [UserAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
});

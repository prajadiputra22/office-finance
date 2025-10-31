<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/registrasi', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

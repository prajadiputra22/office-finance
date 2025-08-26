<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PasswordResetController;

// Route::get('/', function () {
//     return view('splash');
// })->name('splash');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/transaksi', function () {
    return view('transaksi');
})->name('transaksi');


Route::get('/kategori', function () {
    return view('kategori');
})->name('kategori');

// Route::middleware('guest:admin')->group(function () {
//     // Login
//     Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('/admin/login', [AdminAuthController::class, 'login']);

//     // Register
//     Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
//     Route::post('/admin/register', [AdminAuthController::class, 'register']);

//     // Reset password
//     // Route::get('/admin/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
//     // Route::post('/admin/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
//     // Route::get('/admin/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
//     // Route::post('/admin/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
// });


// Route::middleware('auth:admin')->group(function () {
//     Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//     Route::get('/home', function () {
//         return redirect()->route('kategori');
//     })->name('home');
// });

// Route::get('/login', function () {
//     return redirect()->route('admin.login');
// })->name('login');

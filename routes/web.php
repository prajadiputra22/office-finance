<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PasswordResetController;
=======
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\AuthController;
>>>>>>> origin/ui-ux

// Route::get('/', function () {
//     return view('splash');
// })->name('splash');

<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/transaction', function () {
    return view('transaction');
})->name('transaction');
=======
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::resource('/transaction', TransactionController::class);

Route::resource('/categories', CategoryController::class);

Route::resource('reports', ReportController::class)->only(['index']);

Route::prefix('kas-keluar')->group(function () {
    Route::get('/angsuran', [KasKeluarController::class, 'angsuran'])->name('kas-keluar.angsuran');
    Route::get('/hutang', [KasKeluarController::class, 'hutang'])->name('kas-keluar.hutang');
    Route::get('/besar', [KasKeluarController::class, 'besar'])->name('kas-keluar.besar');
    Route::get('/kecil', [KasKeluarController::class, 'kecil'])->name('kas-keluar.kecil');
});

Route::prefix('kas-masuk')->group(function () {
    Route::get('/cv-tiga-jaya', [KasMasukController::class, 'cvTigaJaya'])->name('kas-masuk.cv-tiga-jaya');
    Route::get('/sas-sukabumi', [KasMasukController::class, 'sasSukabumi'])->name('kas-masuk.sas-sukabumi');
    Route::get('/sas-karawang', [KasMasukController::class, 'sasKarawang'])->name('kas-masuk.sas-karawang');
});;
>>>>>>> origin/ui-ux


Route::get('/category', function () {
    return view('category');
})->name('category');

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

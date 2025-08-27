<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('splash');
});

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




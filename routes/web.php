<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;


Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/api/category/{type}', [CategoryController::class, 'getByType'])->name('api.category.byType');

Route::middleware('guest:admin')->group(function () {
    // Login
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Register
    Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});


// Route::middleware('auth:admin')->group(function () {
//     Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//     Route::get('/home', function () {
//         return redirect()->route('kategori');
//     })->name('home');
// });

// Route::get('/login', function () {
//     return redirect()->route('admin.login');
// })->name('login');
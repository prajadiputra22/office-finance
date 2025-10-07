<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;
=======
>>>>>>> origin/ui-ux
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CategoryTransactionController;

Route::get('/', function () {
    return view('splash');
})->name('splash');

<<<<<<< HEAD
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
Route::post('/transactions/bulk-delete', [TransactionController::class, 'bulkDelete']);

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/api/category/{type}', [CategoryController::class, 'getByType'])->name('api.category.byType');
Route::get('/category/income', [CategoryTransactionController::class, 'income'])->name('category.income');
Route::get('/category/expenditure', [CategoryTransactionController::class, 'expenditure'])->name('category.expenditure');

Route::get('/report', [ReportsController::class, 'index'])->name('report');
Route::get('/api/chart-data', [ReportsController::class, 'getChartData'])->name('chart.data');
Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');

Route::middleware('guest:admin')->group(function () {

=======
Route::middleware('guest:admin')->group(function () {
>>>>>>> origin/ui-ux
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');
<<<<<<< HEAD
    
    Route::get('/transactions', [TransactionController::class, 'index'], function () {
        return redirect()->route('transactions');
    })->name('transactions.index');

    // Route::get('/transactions', function () {
    //     return redirect()->route('transactions');
    // })->name('transactions');
});

Route::get('/login', function () {
    return redirect()->route('auth.login');
})->name('login');
=======
});

Route::get('/login', function () {
    return redirect()->route('auth.login');
})->name('login');
    
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
Route::post('/transactions/bulk-delete', [TransactionController::class, 'bulkDelete']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/api/category/{type}', [CategoryController::class, 'getByType'])->name('api.category.byType');
Route::get('/category/income', [CategoryTransactionController::class, 'income'])->name('category.income');
Route::get('/category/expenditure', [CategoryTransactionController::class, 'expenditure'])->name('category.expenditure');

Route::get('/report', [ReportsController::class, 'index'])->name('report.index');
Route::get('/api/chart-data', [ReportsController::class, 'getChartData'])->name('chart.data');
Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');



>>>>>>> origin/ui-ux

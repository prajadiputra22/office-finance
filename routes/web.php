<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// CRUD Category
Route::resource('category', CategoryController::class);
// API kategori berdasarkan tipe
Route::get('/categories/{type}', [CategoryController::class, 'getByType']);


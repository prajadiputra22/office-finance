<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('splash');
});

Route::get('/login', function () {
    return view('login');
});

Route::resource('category', CategoryController::class);

Route::get('/categories/{type}', [CategoryController::class, 'getByType']);




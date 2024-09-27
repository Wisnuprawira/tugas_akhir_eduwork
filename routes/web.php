<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/members', [App\Http\Controllers\MemberController::class, 'index']);
// Route::get('/members/create', [App\Http\Controllers\MemberController::class, 'create']);
// Route::post('/members', [App\Http\Controllers\MemberController::class, 'store']);
// Route::get('/members/{member}/edit', [App\Http\Controllers\MemberController::class, 'edit']);
// Route::put('/members/{member}', [App\Http\Controllers\MemberController::class, 'update']);
// Route::delete('/members/{member}', [App\Http\Controllers\MemberController::class, 'destroy']);
Route::resource('/members', App\Http\Controllers\MemberController::class);
Route::resource('/products', App\Http\Controllers\ProductController::class);
Route::resource('/categories', App\Http\Controllers\CategoryController::class);
Route::resource('/orders', App\Http\Controllers\OrderController::class);


Route::get('/api/products',[App\Http\Controllers\ProductController::class,'api']);
// Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update']);
Route::get('/api/orders',[App\Http\Controllers\OrderController::class,'api']);

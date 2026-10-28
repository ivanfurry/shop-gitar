<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/del/item/{product_id}', [CartController::class, 'delItem'])->name('cart.del_item');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');
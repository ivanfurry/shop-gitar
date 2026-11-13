<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

// Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
// Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
// Route::get('/cart/del/item/{product_id}', [CartController::class, 'delItem'])->name('cart.del_item');
// Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
// Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');

// Route::match(['get', 'post'], '/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Route::get('/register', [UserController::class, 'create'])->name('register.create');
// Route::post('/register', [UserController::class, 'store'])->name('register.store');

// Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
// Route::post('/login', [UserController::class, 'login'])->name('login');
// Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// Маршруты админки
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
    
    // Товары
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    
    // Категории
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Статусы
    Route::resource('statuses', \App\Http\Controllers\Admin\StatusController::class);
});


// Главная страница
Route::get('/', [ProductController::class, 'index'])->name('home');

// Товары и категории
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Корзина и оформление заказа
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/del/item/{product_id}', [CartController::class, 'delItem'])->name('cart.del_item');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');
Route::match(['get', 'post'], '/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Регистрация и вход (только для неавторизованных пользователей)
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register.create');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');
    Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

// Выход (только для авторизованных пользователей)
Route::get('/logout', [UserController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
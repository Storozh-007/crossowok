<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\LoginController;

// PRODUCTS / CATEGORIES
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// GOD MODE
use App\Http\Controllers\GodController;

// PROFILE
use App\Http\Controllers\ProfileController;

// CART + CHECKOUT
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/catalog', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| Auth Routes (Login / Register)
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');


/*
|--------------------------------------------------------------------------
| Profile (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');


/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'process'])
    ->name('checkout.process');

Route::get('/thank-you', [CheckoutController::class, 'thankyou'])
    ->name('orders.thankyou');


/*
|--------------------------------------------------------------------------
| Admin Panel Routes (auth + admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/panel', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |---------------------------
        | Orders
        |---------------------------
        */
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        /*
        |---------------------------
        | Products CRUD
        |---------------------------
        */
        Route::get('/products', [ProductController::class, 'adminIndex'])
            ->name('products.index');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');


        /*
        |---------------------------
        | Categories CRUD
        |---------------------------
        */
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        /*
        |---------------------------
        | Users
        |---------------------------
        */
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');
    });


/*
|--------------------------------------------------------------------------
| GOD PANEL (superuser)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'god'])->group(function () {

    Route::get('/god', [GodController::class, 'index'])
        ->name('god.panel');

    Route::post('/god/set-admin', [GodController::class, 'setAdmin'])
        ->name('god.setAdmin');
});

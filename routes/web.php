<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $carouselSlides = App\Models\CarouselSlide::orderBy('order', 'asc')->get();
    return view('home', compact('carouselSlides'));
});

Route::get('/catalog', function () {
    return view('catalog');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/payment-instruction', function () {
    return view('payment-instruction');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (public)
    Route::get('/login', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'logout'])->name('logout');
    
    // Protected admin routes
    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/products', function () {
            return view('admin.products.index');
        })->name('products.index');
        
        Route::get('/products/create', function () {
            return view('admin.products.create');
        })->name('products.create');
        
        Route::get('/products/{id}/edit', function ($id) {
            return view('admin.products.edit');
        })->name('products.edit');
        
        // Carousel routes
        Route::resource('carousel', App\Http\Controllers\Admin\CarouselController::class);
        Route::post('/carousel/{carouselSlide}/move-up', [App\Http\Controllers\Admin\CarouselController::class, 'moveUp'])->name('carousel.move-up');
        Route::post('/carousel/{carouselSlide}/move-down', [App\Http\Controllers\Admin\CarouselController::class, 'moveDown'])->name('carousel.move-down');
        
        // Category routes
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        
        Route::get('/orders', function () {
            return view('admin.orders.index');
        })->name('orders.index');
        
        Route::get('/orders/{id}', function ($id) {
            return view('admin.orders.show');
        })->name('orders.show');
        
        Route::get('/accounts', function () {
            return view('admin.accounts.index');
        })->name('accounts.index');
        
        Route::get('/accounts/create', function () {
            return view('admin.accounts.create');
        })->name('accounts.create');
        
        Route::get('/accounts/{id}/edit', function ($id) {
            return view('admin.accounts.edit');
        })->name('accounts.edit');
    });
});


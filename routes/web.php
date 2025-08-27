<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $carouselSlides = App\Models\CarouselSlide::orderBy('order', 'asc')->get();
    $featuredProducts = App\Models\Product::with(['category'])
        ->active()
        ->inStock()
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();
    $categories = App\Models\Category::withCount(['products' => function ($query) {
        $query->active()->inStock();
    }])->withCoverImage()->get();
    
    return view('home', compact('carouselSlides', 'featuredProducts', 'categories'));
});

Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog');

Route::get('/product/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product-detail');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

// RajaOngkir API Routes
Route::prefix('api/rajaongkir')->group(function () {
    Route::get('/search-destination', [App\Http\Controllers\RajaOngkirController::class, 'searchDestination']);
    Route::post('/calculate-cost', [App\Http\Controllers\RajaOngkirController::class, 'calculateCost']);
    
    // Address API Routes
    Route::get('/provinces', [App\Http\Controllers\RajaOngkirController::class, 'getProvinces']);
    Route::get('/cities', [App\Http\Controllers\RajaOngkirController::class, 'getCities']);
    Route::get('/cities/{city_id}', [App\Http\Controllers\RajaOngkirController::class, 'getCityById']);
    Route::get('/provinces/{province_id}', [App\Http\Controllers\RajaOngkirController::class, 'getProvinceById']);
});

Route::get('/payment-instruction', function (Request $request) {
    $orderNumber = $request->query('order');
    return view('payment-instruction', compact('orderNumber'));
})->name('payment-instruction');

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
        
        // Product routes
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::delete('/products/{product}/gallery/{image}', [App\Http\Controllers\Admin\ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
        
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
        
        // Bank Account routes
        Route::resource('accounts', App\Http\Controllers\Admin\BankAccountController::class)->except(['show']);
    });
});


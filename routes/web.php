<?php

use Illuminate\Support\Facades\Route;

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
    }])->get();
    
    return view('home', compact('carouselSlides', 'featuredProducts', 'categories'));
});

Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog');

// Test route to check database data
Route::get('/test-catalog', function () {
    $products = App\Models\Product::with(['category'])->active()->inStock()->get();
    $categories = App\Models\Category::withCount(['products' => function ($query) {
        $query->active()->inStock();
    }])->get();
    
    return response()->json([
        'products_count' => $products->count(),
        'categories_count' => $categories->count(),
        'sample_products' => $products->take(3)->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->formatted_price,
                'category' => $product->category->name,
                'image_url' => $product->main_image_url,
                'status' => $product->status,
                'stock' => $product->stock
            ];
        }),
        'categories' => $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'products_count' => $category->products_count
            ];
        })
    ]);
});

Route::get('/product/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product-detail');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/payment-instruction', function () {
    return view('payment-instruction');
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


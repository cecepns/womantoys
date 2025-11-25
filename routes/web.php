<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog');

Route::get('/product/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product-detail');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

// Cart (public) - static/dummy view for frontend
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// API Routes
Route::prefix('api')->group(function () {
    // RajaOngkir API Routes
    Route::prefix('rajaongkir')->group(function () {
        Route::get('/search-destination', [App\Http\Controllers\RajaOngkirController::class, 'searchDestination']);
        Route::post('/calculate-cost', [App\Http\Controllers\RajaOngkirController::class, 'calculateCost']);

        // Address API Routes
        Route::get('/provinces', [App\Http\Controllers\RajaOngkirController::class, 'getProvinces']);
        Route::get('/cities', [App\Http\Controllers\RajaOngkirController::class, 'getCities']);
        Route::get('/cities/{city_id}', [App\Http\Controllers\RajaOngkirController::class, 'getCityById']);
        Route::get('/provinces/{province_id}', [App\Http\Controllers\RajaOngkirController::class, 'getProvinceById']);
    });

    // Voucher API Routes
    Route::post('/vouchers/validate', [App\Http\Controllers\VoucherController::class, 'validateVoucher'])->name('api.vouchers.validate');
});

Route::get('/payment-instruction', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment-instruction');
Route::post('/payment-instruction', [App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('payment.confirm');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (public)
    Route::get('/login', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Product routes
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::delete('/products/{product}/gallery/{image}', [App\Http\Controllers\Admin\ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
        
        // Product Variant routes
        Route::post('/products/{product}/variants', [App\Http\Controllers\Admin\ProductVariantController::class, 'store'])->name('products.variants.store');
        Route::put('/products/{product}/variants/{variant}', [App\Http\Controllers\Admin\ProductVariantController::class, 'update'])->name('products.variants.update');
        Route::delete('/products/{product}/variants/{variant}', [App\Http\Controllers\Admin\ProductVariantController::class, 'destroy'])->name('products.variants.destroy');
        Route::post('/products/{product}/variants/{variant}/toggle-active', [App\Http\Controllers\Admin\ProductVariantController::class, 'toggleActive'])->name('products.variants.toggle-active');
        Route::post('/products/{product}/variants/update-order', [App\Http\Controllers\Admin\ProductVariantController::class, 'updateOrder'])->name('products.variants.update-order');

        // Carousel routes
        Route::resource('carousel', App\Http\Controllers\Admin\CarouselController::class);
        Route::post('/carousel/{carouselSlide}/move-up', [App\Http\Controllers\Admin\CarouselController::class, 'moveUp'])->name('carousel.move-up');
        Route::post('/carousel/{carouselSlide}/move-down', [App\Http\Controllers\Admin\CarouselController::class, 'moveDown'])->name('carousel.move-down');

        // Promotion routes
        Route::resource('promotions', App\Http\Controllers\Admin\PromotionController::class);

        // Category routes
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

        // Main Category routes
        Route::resource('main-categories', App\Http\Controllers\Admin\MainCategoryController::class);
        Route::post('/main-categories/{mainCategory}/move-up', [App\Http\Controllers\Admin\MainCategoryController::class, 'moveUp'])->name('main-categories.move-up');
        Route::post('/main-categories/{mainCategory}/move-down', [App\Http\Controllers\Admin\MainCategoryController::class, 'moveDown'])->name('main-categories.move-down');

        // Order routes
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
        Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

        // Bank Account routes
        Route::resource('accounts', App\Http\Controllers\Admin\BankAccountController::class)->except(['show']);

        // Settings routes
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/password', [App\Http\Controllers\Admin\SettingController::class, 'updatePassword'])->name('settings.password');
        Route::put('/settings/store', [App\Http\Controllers\Admin\SettingController::class, 'updateStore'])->name('settings.store');
        Route::put('/settings/contact', [App\Http\Controllers\Admin\SettingController::class, 'updateContact'])->name('settings.contact');
        Route::put('/settings/about-image', [App\Http\Controllers\Admin\SettingController::class, 'updateAboutImage'])->name('settings.about-image');

        // Voucher routes
        Route::resource('vouchers', App\Http\Controllers\VoucherController::class);
        Route::post('/vouchers/{voucher}/toggle-status', [App\Http\Controllers\VoucherController::class, 'toggleStatus'])->name('vouchers.toggle-status');
        Route::get('/vouchers/generate/code', [App\Http\Controllers\VoucherController::class, 'generateCode'])->name('vouchers.generate-code');
        Route::post('/vouchers/bulk-action', [App\Http\Controllers\VoucherController::class, 'bulkAction'])->name('vouchers.bulk-action');
        Route::get('/vouchers/export/excel', [App\Http\Controllers\VoucherController::class, 'export'])->name('vouchers.export');
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
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

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/products', function () {
    return view('admin.products.index');
});

Route::get('/admin/products/create', function () {
    return view('admin.products.create');
});

Route::get('/admin/products/{id}/edit', function ($id) {
    return view('admin.products.edit');
});

Route::get('/admin/carousel', function () {
    return view('admin.carousel.index');
});

Route::get('/admin/carousel/create', function () {
    return view('admin.carousel.create');
});

Route::get('/admin/carousel/{id}/edit', function ($id) {
    return view('admin.carousel.edit');
});

Route::get('/admin/orders', function () {
    return view('admin.orders.index');
});

Route::get('/admin/orders/{id}', function ($id) {
    return view('admin.orders.show');
});

Route::get('/admin/accounts', function () {
    return view('admin.accounts.index');
});

Route::get('/admin/accounts/create', function () {
    return view('admin.accounts.create');
});

Route::get('/admin/accounts/{id}/edit', function ($id) {
    return view('admin.accounts.edit');
});


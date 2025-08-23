@extends('layouts.app')

@section('title', 'Home - WomanToys')

@section('content')
<!-- Hero Section -->
<div class="relative h-96 md:h-[500px] overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img 
            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" 
            alt="WomanToys Hero" 
            class="w-full h-full object-cover"
        >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Discover Your <span class="text-pink-400">Intimate</span> Pleasure
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Premium adult toys and intimate products for enhanced satisfaction
            </p>
            <a href="/catalog" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-8 rounded-lg transition-colors duration-200 text-lg">
                View Collection
            </a>
        </div>
    </div>
</div>

<!-- Trust & Guarantee Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- 100% Kemasan Rahasia -->
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">100% Discreet Packaging</h3>
                <p class="text-gray-600">Completely private packaging for your peace of mind</p>
            </div>
            
            <!-- Transaksi Aman & Privat -->
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Secure & Private Transactions</h3>
                <p class="text-gray-600">Your privacy and security are our top priority</p>
            </div>
            
            <!-- Produk Terkurasi & Aman -->
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Curated & Safe Products</h3>
                <p class="text-gray-600">Premium quality products tested for safety and satisfaction</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Featured Products</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our most popular and premium adult toys for enhanced pleasure
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Product Card 1 -->
            <x-product-card />
            
            <!-- Product Card 2 -->
            <x-product-card />
            
            <!-- Product Card 3 -->
            <x-product-card />
            
            <!-- Product Card 4 -->
            <x-product-card />
        </div>
        
        <div class="text-center mt-12">
            <a href="/catalog" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                View All Products
            </a>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Shop by Category</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Find the perfect products for your intimate needs
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- For Women -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg shadow-lg">
                    <img 
                        src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                        alt="For Women" 
                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-2xl font-bold mb-2">For Women</h3>
                        <p class="text-sm opacity-90">Premium products designed for women</p>
                    </div>
                </div>
            </div>
            
            <!-- For Men -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg shadow-lg">
                    <img 
                        src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                        alt="For Men" 
                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-2xl font-bold mb-2">For Men</h3>
                        <p class="text-sm opacity-90">Quality products for men's pleasure</p>
                    </div>
                </div>
            </div>
            
            <!-- For Couples -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg shadow-lg">
                    <img 
                        src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                        alt="For Couples" 
                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-2xl font-bold mb-2">For Couples</h3>
                        <p class="text-sm opacity-90">Enhance intimacy together</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Us Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">About Us</h2>
            <div class="text-lg text-gray-600 space-y-4">
                <p>
                    WomanToys is a trusted online store that provides high-quality adult products to meet your intimate needs. 
                    We are committed to providing a safe, comfortable, and discreet shopping experience.
                </p>
                <p>
                    All our products have undergone strict curation to ensure quality, safety, and customer satisfaction. 
                    With years of experience in this industry, we understand the importance of customer privacy and trust.
                </p>
                <p>
                    Join thousands of customers who have trusted WomanToys for their intimate needs. 
                    Enjoy a pleasant shopping experience with responsive customer service and fast delivery.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Catalog - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Header Katalog -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Our Collection</h1>
        
        <!-- Control Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <!-- Filter Kategori -->
            <div class="flex flex-wrap gap-4">
                <a href="#" class="px-4 py-2 bg-pink-600 text-white rounded-lg font-medium hover:bg-pink-700 transition-colors duration-200">All</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">For Women</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">For Men</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">BDSM</a>
            </div>
            
            <!-- Bar Pencarian -->
            <form class="flex gap-2 w-full md:w-auto">
                <input 
                    type="text" 
                    placeholder="Search products..." 
                    class="flex-1 md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                >
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-pink-600 text-white rounded-lg font-medium hover:bg-pink-700 transition-colors duration-200"
                >
                    Search
                </button>
            </form>
        </div>
    </div>
    
    <!-- Grid Produk -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
        <!-- Product Card 1 -->
        <x-product-card />
        
        <!-- Product Card 2 -->
        <x-product-card />
        
        <!-- Product Card 3 -->
        <x-product-card />
        
        <!-- Product Card 4 -->
        <x-product-card />
        
        <!-- Product Card 5 -->
        <x-product-card />
        
        <!-- Product Card 6 -->
        <x-product-card />
        
        <!-- Product Card 7 -->
        <x-product-card />
        
        <!-- Product Card 8 -->
        <x-product-card />
        
        <!-- Product Card 9 -->
        <x-product-card />
        
        <!-- Product Card 10 -->
        <x-product-card />
        
        <!-- Product Card 11 -->
        <x-product-card />
        
        <!-- Product Card 12 -->
        <x-product-card />
    </div>
    
    <!-- Paginasi -->
    <nav class="flex justify-center">
        <div class="flex items-center space-x-2">
            <!-- Previous Button -->
            <a href="#" class="px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                « Previous
            </a>
            
            <!-- Page Numbers -->
            <a href="#" class="px-3 py-2 text-white bg-pink-600 border border-pink-600 rounded-lg font-medium">
                1
            </a>
            <a href="#" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                2
            </a>
            <a href="#" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                3
            </a>
            
            <!-- Next Button -->
            <a href="#" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                Next »
            </a>
        </div>
    </nav>
</div>
@endsection

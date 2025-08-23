@extends('layouts.app')

@section('title', 'Products - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Our Products</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Discover our premium collection of adult toys and intimate products designed for enhanced pleasure and satisfaction.
        </p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
    </div>
</div>
@endsection

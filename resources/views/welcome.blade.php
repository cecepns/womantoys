@extends('layouts.app')

@section('title', 'Home - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">
            Welcome to <span class="text-pink-600">WomanToys</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Discover our premium collection of adult toys and intimate products designed for enhanced pleasure and satisfaction.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/products" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                View Collection
            </a>
            <a href="#" class="border border-pink-600 text-pink-600 hover:bg-pink-600 hover:text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                Learn More
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="text-center p-6 bg-white rounded-lg shadow-md">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Premium Quality</h3>
            <p class="text-gray-600">High-quality materials and craftsmanship for safe and pleasurable experiences.</p>
        </div>
        
        <div class="text-center p-6 bg-white rounded-lg shadow-md">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Safe & Discreet</h3>
            <p class="text-gray-600">100% body-safe materials with discreet packaging for your privacy.</p>
        </div>
        
        <div class="text-center p-6 bg-white rounded-lg shadow-md">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Enhanced Pleasure</h3>
            <p class="text-gray-600">Designed to provide maximum satisfaction and intimate pleasure.</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg p-8 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Explore Your Desires With Confidence</h2>
        <p class="text-xl mb-6 opacity-90">Join thousands of satisfied customers who trust WomanToys for their intimate needs.</p>
        <a href="/products" class="bg-white text-pink-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-colors duration-200 inline-block">
            Shop Now
        </a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Product Detail - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="/" class="hover:text-pink-600 transition-colors duration-200">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/catalog" class="hover:text-pink-600 transition-colors duration-200">Collection</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800 font-medium">Lelo Sona Cruise 2</li>
        </ol>
    </nav>

    <!-- Main Product Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Left Column - Image Gallery -->
        <div>
            <!-- Main Image -->
            <div class="mb-6">
                <img 
                    src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                    alt="Lelo Sona Cruise 2" 
                    class="w-full h-96 lg:h-[500px] object-cover rounded-lg shadow-lg"
                >
            </div>
            
            <!-- Thumbnail Gallery -->
            <div class="flex space-x-4">
                <img 
                    src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" 
                    alt="Product Image 1" 
                    class="w-20 h-20 object-cover rounded-lg border-2 border-pink-600 cursor-pointer hover:opacity-80 transition-opacity duration-200"
                >
                <img 
                    src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                    alt="Product Image 2" 
                    class="w-20 h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200"
                >
                <img 
                    src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                    alt="Product Image 3" 
                    class="w-20 h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200"
                >
                <img 
                    src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                    alt="Product Image 4" 
                    class="w-20 h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200"
                >
            </div>
        </div>

        <!-- Right Column - Product Information -->
        <div>
            <!-- Product Name -->
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                Lelo Sona Cruise 2
            </h1>
            
            <!-- Product Price -->
            <p class="text-3xl font-bold text-pink-600 mb-6">
                Rp 1.500.000
            </p>
            
            <!-- Product Description -->
            <div class="mb-8">
                <p class="text-gray-600 text-lg leading-relaxed">
                    Experience ultimate pleasure with the Lelo Sona Cruise 2, a premium sonic wave massager designed for intense clitoral stimulation. 
                    This innovative device uses sonic waves to create powerful, deep-reaching sensations that traditional vibrators cannot achieve.
                </p>
            </div>
            
            <!-- Product Features -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Key Features:</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Sonic wave technology for deep stimulation
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        8 different intensity levels
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Waterproof and body-safe silicone
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Rechargeable with long battery life
                    </li>
                </ul>
            </div>
            
            <!-- Buy Now Button -->
            <button class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                Buy Now
            </button>
        </div>
    </div>

    <!-- Detailed Information Tabs -->
    <div class="border-t border-gray-200 pt-8">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 mb-8">
            <button class="px-6 py-3 text-pink-600 border-b-2 border-pink-600 font-medium">
                Complete Description
            </button>
            <button class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium">
                Specifications
            </button>
            <button class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium">
                Care Instructions
            </button>
        </div>

        <!-- Tab Content -->
        <div class="space-y-6">
            <!-- Complete Description Tab (Active) -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Complete Description</h3>
                <div class="prose prose-lg text-gray-600 space-y-4">
                    <p>
                        The Lelo Sona Cruise 2 represents the pinnacle of intimate pleasure technology, combining cutting-edge sonic wave technology with elegant design. 
                        Unlike traditional vibrators that rely on surface-level vibrations, this revolutionary device uses sonic waves to create deep, penetrating sensations 
                        that reach the internal clitoral structure.
                    </p>
                    <p>
                        Crafted from premium body-safe silicone, the Sona Cruise 2 features a sleek, ergonomic design that fits perfectly in your hand. 
                        The device offers 8 different intensity levels, allowing you to find the perfect setting for your pleasure journey. 
                        Whether you prefer gentle, teasing sensations or powerful, intense stimulation, this device delivers exactly what you need.
                    </p>
                    <p>
                        The waterproof design makes it perfect for use in the shower or bath, adding an extra dimension to your intimate moments. 
                        The rechargeable battery provides hours of pleasure on a single charge, ensuring you never have to interrupt your experience.
                    </p>
                    <p>
                        This premium adult toy is designed for solo use and couples play, making it a versatile addition to your intimate collection. 
                        The sonic wave technology creates unique sensations that many users describe as more intense and satisfying than traditional vibration patterns.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

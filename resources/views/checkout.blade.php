@extends('layouts.app')

@section('title', 'Checkout - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="/" class="hover:text-pink-600 transition-colors duration-200">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/catalog" class="hover:text-pink-600 transition-colors duration-200">Collection</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/product-detail" class="hover:text-pink-600 transition-colors duration-200">Product</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800 font-medium">Checkout</li>
        </ol>
    </nav>

    <!-- Main Checkout Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Left Column - Shipping Form -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Shipping Details</h2>
            
            <form class="space-y-6">
                <!-- Full Name -->
                <div>
                    <label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>
                    <input 
                        type="text" 
                        id="fullName" 
                        name="fullName" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Enter your phone number"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Enter your email address"
                        required
                    >
                </div>

                <!-- Complete Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Complete Address
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Enter your complete shipping address"
                        required
                    ></textarea>
                </div>

                <!-- Shipping Method -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Shipping Method</h3>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 transition-colors duration-200">
                            <input 
                                type="radio" 
                                name="shipping" 
                                value="regular" 
                                class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                                checked
                            >
                            <div class="ml-3">
                                <div class="font-medium text-gray-800">Regular Shipping</div>
                                <div class="text-sm text-gray-600">3-5 business days</div>
                            </div>
                            <div class="ml-auto font-semibold text-gray-800">
                                Rp 20.000
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 transition-colors duration-200">
                            <input 
                                type="radio" 
                                name="shipping" 
                                value="express" 
                                class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                            >
                            <div class="ml-3">
                                <div class="font-medium text-gray-800">Express Shipping</div>
                                <div class="text-sm text-gray-600">1-2 business days</div>
                            </div>
                            <div class="ml-auto font-semibold text-gray-800">
                                Rp 35.000
                            </div>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column - Order Summary -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
            
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <!-- Product Item -->
                <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                    <img 
                        src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                        alt="Lelo Sona Cruise 2" 
                        class="w-16 h-16 object-cover rounded-lg"
                    >
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">Lelo Sona Cruise 2</h3>
                        <p class="text-sm text-gray-600">Premium Sonic Wave Massager</p>
                        <p class="text-sm text-gray-600">Quantity: 1</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp 1.500.000</p>
                    </div>
                </div>

                <!-- Cost Breakdown -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp 1.500.000</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping Cost</span>
                        <span>Rp 20.000</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-bold text-gray-800">
                            <span>Total Payment</span>
                            <span>Rp 1.520.000</span>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium">Discreet Packaging</p>
                            <p>Your order will be packaged discreetly for your privacy and security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-12">
        <a href="/payment-instruction" class="block">
            <button class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                Place Order
            </button>
        </a>
    </div>
</div>
@endsection

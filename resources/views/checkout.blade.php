@extends('layouts.app')

@section('title', 'Checkout - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="/" class="hover:text-pink-600 transition-colors duration-200">Beranda</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/catalog" class="hover:text-pink-600 transition-colors duration-200">Koleksi</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('product-detail', $product->slug) }}" class="hover:text-pink-600 transition-colors duration-200">{{ $product->name }}</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800 font-medium">Checkout</li>
        </ol>
    </nav>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Checkout Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Left Column - Shipping Form -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pengiriman</h2>
            
            <form class="space-y-6" method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <!-- Full Name -->
                <div>
                    <label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        id="fullName" 
                        name="fullName" 
                        value="{{ old('fullName') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Masukkan nama lengkap Anda"
                        required
                    >
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Masukkan nomor telepon Anda"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Masukkan alamat email Anda"
                        required
                    >
                </div>

                <!-- Complete Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Masukkan alamat pengiriman lengkap Anda"
                        required
                    >{{ old('address') }}</textarea>
                </div>

                <!-- Shipping Method -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Metode Pengiriman</h3>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 transition-colors duration-200">
                            <input 
                                type="radio" 
                                name="shipping" 
                                value="regular" 
                                class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                                {{ old('shipping', 'regular') === 'regular' ? 'checked' : '' }}
                            >
                            <div class="ml-3">
                                <div class="font-medium text-gray-800">Pengiriman Reguler</div>
                                <div class="text-sm text-gray-600">3-5 hari kerja</div>
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
                                {{ old('shipping') === 'express' ? 'checked' : '' }}
                            >
                            <div class="ml-3">
                                <div class="font-medium text-gray-800">Pengiriman Ekspres</div>
                                <div class="text-sm text-gray-600">1-2 hari kerja</div>
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
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>
            
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <!-- Product Item -->
                <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                    <img 
                        src="{{ asset('storage/' . $product->main_image) }}" 
                        alt="{{ $product->name }}" 
                        class="w-16 h-16 object-cover rounded-lg"
                    >
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->short_description }}</p>
                        <p class="text-xs text-gray-500 mt-1">Stok: {{ $product->stock }} unit</p>
                        
                        <!-- Quantity Selector -->
                        <div class="flex items-center space-x-3 mt-2">
                            <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button 
                                    type="button" 
                                    class="px-3 py-1 text-gray-600 hover:text-pink-600 hover:bg-gray-50 transition-colors duration-200 border-r border-gray-300"
                                    onclick="decreaseQuantity()"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    value="{{ old('quantity', 1) }}" 
                                    min="1" 
                                    max="{{ $product->stock }}"
                                    class="w-12 text-center py-1 text-sm font-medium text-gray-800 focus:outline-none"
                                    onchange="updateQuantity(this.value)"
                                >
                                <button 
                                    type="button" 
                                    class="px-3 py-1 text-gray-600 hover:text-pink-600 hover:bg-gray-50 transition-colors duration-200 border-l border-gray-300"
                                    onclick="increaseQuantity()"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800" id="product-price">{{ $product->formatted_price }}</p>
                    </div>
                </div>

                <!-- Cost Breakdown -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Pengiriman</span>
                        <span id="shipping-cost">Rp 20.000</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-bold text-gray-800">
                            <span>Total Pembayaran</span>
                            <span id="total-amount">Rp {{ number_format($product->price + 20000, 0, ',', '.') }}</span>
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
                            <p class="font-medium">Kemasan Rahasia</p>
                            <p>Pesanan Anda akan dikemas secara rahasia untuk privasi dan keamanan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-12">
        <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
            Buat Pesanan
        </button>
    </div>
</div>

<script>
// Product data from backend
const productData = {
    price: {{ $product->price }},
    stock: {{ $product->stock }}
};

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateQuantity(currentValue - 1);
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue < productData.stock) {
        quantityInput.value = currentValue + 1;
        updateQuantity(currentValue + 1);
    }
}

function updateQuantity(value) {
    const quantity = parseInt(value);
    if (quantity < 1) {
        document.getElementById('quantity').value = 1;
        quantity = 1;
    } else if (quantity > productData.stock) {
        document.getElementById('quantity').value = productData.stock;
        quantity = productData.stock;
    }
    
    updatePricing(quantity);
}

function updatePricing(quantity) {
    // Get shipping cost
    const shippingMethod = document.querySelector('input[name="shipping"]:checked').value;
    const shippingCost = shippingMethod === 'express' ? 35000 : 20000;
    
    // Calculate prices
    const subtotal = productData.price * quantity;
    const total = subtotal + shippingCost;
    
    // Update display
    document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('shipping-cost').textContent = 'Rp ' + formatNumber(shippingCost);
    document.getElementById('total-amount').textContent = 'Rp ' + formatNumber(total);
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Add event listeners for shipping method changes
document.addEventListener('DOMContentLoaded', function() {
    const shippingInputs = document.querySelectorAll('input[name="shipping"]');
    shippingInputs.forEach(input => {
        input.addEventListener('change', function() {
            const quantity = parseInt(document.getElementById('quantity').value);
            updatePricing(quantity);
        });
    });
    
    // Initialize pricing with old quantity or default to 1
    const initialQuantity = parseInt(document.getElementById('quantity').value) || 1;
    updatePricing(initialQuantity);
});
</script>
@endsection

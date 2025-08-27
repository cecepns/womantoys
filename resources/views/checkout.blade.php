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
            
            <form id="checkout-form" class="space-y-6" method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" id="hidden_quantity" value="{{ old('quantity', 1) }}">
                <input type="hidden" name="origin_id" id="origin_id" value="17473">
                <input type="hidden" name="destination_id" id="destination_id" value="">
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
                    <label for="address-autocomplete" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="address-autocomplete" 
                            name="address_location"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Mulai ketik kota, kecamatan, atau kode pos..."
                                autocomplete="off"
                            required
                            >
                            <!-- Dropdown untuk hasil pencarian -->
                            <div id="address-dropdown" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden mt-1">
                                <!-- Hasil pencarian akan ditampilkan di sini -->
                            </div>
                                </div>
                            </div>
                            
                <div>
                    <label for="address-detail" class="block text-sm font-medium text-gray-700 mb-2">
                        Detail Alamat
                    </label>
                            <textarea 
                        id="address-detail" 
                        name="address_detail" 
                                rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Masukkan detail alamat lengkap (nama jalan, nomor rumah, RT/RW, dll)"
                                required
                    >{{ old('address_detail') }}</textarea>
                </div>

                <!-- Shipping Method -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Metode Pengiriman</h3>
                    
                    <!-- Loading state -->
                    <div id="shipping-loading" class="hidden">
                        <div class="flex items-center justify-center p-4">
                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-pink-600"></div>
                            <span class="ml-2 text-gray-600">Menghitung ongkos kirim...</span>
                            </div>
                            </div>

                    <!-- Error state -->
                    <div id="shipping-error" class="hidden">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-red-800" id="shipping-error-message">Gagal menghitung ongkos kirim</span>
                            </div>
                            <button onclick="calculateShippingCost()" class="mt-2 text-sm text-red-600 hover:text-red-800 underline">
                                Coba lagi
                            </button>
                        </div>
                    </div>

                    <!-- Shipping options -->
                    <div id="shipping-options" class="space-y-3">
                        <div class="text-center text-gray-500 py-4">
                            Pilih alamat tujuan untuk melihat opsi pengiriman
                        </div>
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
                        <span id="shipping-cost">Pilih alamat tujuan</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-bold text-gray-800">
                            <span>Total Pembayaran</span>
                            <span id="total-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
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
        <button type="submit" form="checkout-form" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
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

let selectedLocationId = null;
let lastQuery = '';
let currentController = null;

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

function cancelPreviousRequest() {
    if (currentController) {
        currentController.abort();
        currentController = null;
    }
}

function initRajaOngkirAutocomplete() {
    const addressInput = document.getElementById('address-autocomplete');
    const dropdown = document.getElementById('address-dropdown');
    if (!addressInput || !dropdown) return;

    const debouncedSearch = debounce((query) => {
        if (query !== lastQuery) {
            lastQuery = query;
            searchAddress(query);
        }
    }, 2000);

        addressInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                hideDropdown();
            lastQuery = '';
                return;
            }
        showLoadingState();
        debouncedSearch(query);
    });

        document.addEventListener('click', function(e) {
            if (!addressInput.contains(e.target) && !dropdown.contains(e.target)) {
                hideDropdown();
            }
        });
        
        addressInput.addEventListener('focus', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                searchAddress(query);
            }
        });
        
        addressInput.addEventListener('keydown', function(e) {
            const options = dropdown.querySelectorAll('.address-option');
            const currentIndex = Array.from(options).findIndex(option => option.classList.contains('bg-pink-50'));
        if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (options.length > 0) {
                        const nextIndex = currentIndex < options.length - 1 ? currentIndex + 1 : 0;
                        highlightOption(options, nextIndex);
                    }
        } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (options.length > 0) {
                        const prevIndex = currentIndex > 0 ? currentIndex - 1 : options.length - 1;
                        highlightOption(options, prevIndex);
                    }
        } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentIndex >= 0 && options[currentIndex]) {
                        const option = options[currentIndex];
                        const id = option.getAttribute('data-id');
                        const label = option.getAttribute('data-label');
                selectAddress(id, label);
            }
        } else if (e.key === 'Escape') {
            hideDropdown();
        }
    });
}

function highlightOption(options, index) {
    options.forEach((option, i) => {
        if (i === index) {
            option.classList.add('bg-pink-50', 'border-pink-200');
        } else {
            option.classList.remove('bg-pink-50', 'border-pink-200');
        }
    });
}

function showLoadingState() {
    const dropdown = document.getElementById('address-dropdown');
        dropdown.innerHTML = `
            <div class="p-4 text-center">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-pink-600"></div>
                <div class="mt-2 text-gray-500">Mencari alamat...</div>
            </div>
        `;
        showDropdown();
}

async function searchAddress(query) {
    const dropdown = document.getElementById('address-dropdown');
    cancelPreviousRequest();
    currentController = new AbortController();
    try {
        showLoadingState();
        const url = `/api/rajaongkir/search-destination?search=${encodeURIComponent(query)}`;
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            signal: currentController.signal
        });
        const data = await response.json();
        if (data.meta && data.meta.status === 'success' && data.data && data.data.length > 0) {
            displaySearchResults(data.data);
        } else {
            dropdown.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Tidak ada hasil ditemukan
                </div>
            `;
        }
    } catch (error) {
        if (error.name === 'AbortError') return;
        dropdown.innerHTML = `
            <div class="p-4 text-center text-red-500">
                <svg class="w-8 h-8 mx-auto mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Terjadi kesalahan saat mencari alamat
            </div>
        `;
    } finally {
        currentController = null;
    }
}

function displaySearchResults(results) {
    const dropdown = document.getElementById('address-dropdown');
    const resultsHtml = results.map(location => `
            <div class="address-option p-3 hover:bg-pink-50 hover:border-pink-200 cursor-pointer border-b border-gray-100 last:border-b-0 transition-colors duration-200" 
                 data-id="${location.id}" 
             data-label="${location.label}">
            <div class="font-medium text-gray-800">${location.label}</div>
            <div class="text-sm text-gray-600">
                ${location.province_name}, ${location.city_name}
                ${location.district_name ? ', ' + location.district_name : ''}
                ${location.subdistrict_name ? ', ' + location.subdistrict_name : ''}
            </div>
            ${location.zip_code ? `<div class="text-xs text-gray-500">Kode Pos: ${location.zip_code}</div>` : ''}
        </div>
    `).join('');
    dropdown.innerHTML = resultsHtml;
    const options = dropdown.querySelectorAll('.address-option');
    options.forEach(option => {
        option.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const label = this.getAttribute('data-label');
            selectAddress(id, label);
        });
        option.addEventListener('mouseenter', function() {
            options.forEach(opt => opt.classList.remove('bg-pink-50', 'border-pink-200'));
            this.classList.add('bg-pink-50', 'border-pink-200');
        });
    });
    showDropdown();
}

function selectAddress(id, label) {
    const addressInput = document.getElementById('address-autocomplete');
    const destinationInput = document.getElementById('destination_id');
    cancelPreviousRequest();
    addressInput.value = label;
    selectedLocationId = id;
    destinationInput.value = id;
    lastQuery = '';
    hideDropdown();
    if (id) {
        calculateShippingCost();
    }
}

function showDropdown() {
    const dropdown = document.getElementById('address-dropdown');
    dropdown.classList.remove('hidden');
}

function hideDropdown() {
    const dropdown = document.getElementById('address-dropdown');
    dropdown.classList.add('hidden');
}

async function calculateShippingCost() {
    const destinationId = document.getElementById('destination_id').value;
    const originId = document.getElementById('origin_id').value;
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    if (!destinationId) {
        showShippingError('Pilih alamat tujuan terlebih dahulu');
        return;
    }
    showShippingLoading();
    try {
        const weight = quantity * 500;
        // const couriers = ['jne', 'pos', 'tiki'];
        const couriers = ['jne'];
        const shippingPromises = couriers.map(courier => 
            fetch('/api/rajaongkir/calculate-cost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    origin: parseInt(originId),
                    destination: parseInt(destinationId),
                    weight: weight,
                    courier: courier
                })
            }).then(response => response.json())
        );
        const results = await Promise.all(shippingPromises);
        displayShippingOptions(results, weight);
    } catch (error) {
        console.log(error);
        // showShippingError('Gagal menghitung ongkos kirim. Silakan coba lagi.');
    }
}

function displayShippingOptions(results, weight) {
    console.log(results);
    const shippingOptions = document.getElementById('shipping-options');
    console.log(shippingOptions);
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingError = document.getElementById('shipping-error');
    shippingLoading.classList.add('hidden');
    shippingError.classList.add('hidden');
    let allOptions = [];
    
    results.forEach((result, index) => {
        if (result.meta && result.meta.status === 'success' && result.data && result.data.length > 0) {
            result.data.forEach(service => {
                allOptions.push({
                    courier: service.name,
                    courierCode: service.code,
                    service: service.service,
                    description: service.description,
                    cost: service.cost,
                    etd: service.etd,
                    weight: weight
                });
            });
        }
    });

    
    // Sort by cost (cheapest first)
    allOptions.sort((a, b) => a.cost - b.cost);
    
    const optionsHtml = allOptions.map((option, index) => {
        // Get service icon based on service type
        let serviceIcon = '';
        let serviceBadge = '';
        
        if (option.service === 'REG') {
            serviceIcon = '📦';
            serviceBadge = '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Reguler</span>';
        } else if (option.service === 'YES') {
            serviceIcon = '⚡';
            serviceBadge = '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Express</span>';
        } else if (option.service === 'SPS') {
            serviceIcon = '🚀';
            serviceBadge = '<span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Super</span>';
        } else if (option.service.includes('JTR')) {
            serviceIcon = '🚛';
            serviceBadge = '<span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Trucking</span>';
        } else {
            serviceIcon = '📮';
            serviceBadge = '<span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Standard</span>';
        }
        
        return `
            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 hover:shadow-md transition-all duration-200 ${index === 0 ? 'border-pink-500 bg-pink-50' : ''}">
                <input 
                    type="radio" 
                    name="shipping" 
                    value="${option.courierCode}_${option.service.toLowerCase()}_${option.cost}"
                    class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                    ${index === 0 ? 'checked' : ''}
                    onchange="updatePricingWithShipping(${option.cost})"
                >
                <div class="ml-3 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="font-medium text-gray-800">${option.service} - ${option.description}</div>
                        ${serviceBadge}
                    </div>
                    <div class="text-sm text-gray-600 mb-1">${option.courier}</div>
                    <div class="flex items-center gap-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            Estimasi: ${option.etd}
                        </span>
                        <span class="flex items-center gap-1">
                            Berat: ${option.weight}g
                        </span>
                    </div>
                </div>
                <div class="ml-auto text-right">
                    <div class="font-bold text-lg text-gray-800">
                        Rp ${formatNumber(option.cost)}
                    </div>
                    ${index === 0 ? '<div class="text-xs text-green-600 font-medium">Termurah</div>' : ''}
                </div>
            </label>
        `;
    }).join('');
    
    shippingOptions.innerHTML = optionsHtml;
    shippingOptions.classList.remove('hidden');
    
    // Add click handlers for better UX
    const radioLabels = shippingOptions.querySelectorAll('label');
    radioLabels.forEach(label => {
        label.addEventListener('click', function() {
            // Remove selection from all labels
            radioLabels.forEach(l => {
                l.classList.remove('border-pink-500', 'bg-pink-50');
                l.classList.add('border-gray-300');
            });
            // Add selection to clicked label
            this.classList.remove('border-gray-300');
            this.classList.add('border-pink-500', 'bg-pink-50');
        });
    });
    
    if (allOptions.length > 0) {
        updatePricingWithShipping(allOptions[0].cost);
    }
}

function updatePricingWithShipping(shippingCost) {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const subtotal = productData.price * quantity;
    const total = subtotal + shippingCost;
    document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('shipping-cost').textContent = 'Rp ' + formatNumber(shippingCost);
    document.getElementById('total-amount').textContent = 'Rp ' + formatNumber(total);
}

function showShippingLoading() {
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingError = document.getElementById('shipping-error');
    const shippingOptions = document.getElementById('shipping-options');
    shippingLoading.classList.remove('hidden');
    shippingError.classList.add('hidden');
    shippingOptions.classList.add('hidden');
}

function showShippingError(message) {
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingError = document.getElementById('shipping-error');
    const shippingOptions = document.getElementById('shipping-options');
    const errorMessage = document.getElementById('shipping-error-message');
    shippingLoading.classList.add('hidden');
    shippingError.classList.remove('hidden');
    shippingOptions.classList.add('hidden');
    errorMessage.textContent = message;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        const newValue = currentValue - 1;
        quantityInput.value = newValue;
        updateQuantity(newValue);
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue < productData.stock) {
        const newValue = currentValue + 1;
        quantityInput.value = newValue;
        updateQuantity(newValue);
    }
}

function updateQuantity(value) {
    let quantity = parseInt(value);
    if (quantity < 1) {
        document.getElementById('quantity').value = 1;
        quantity = 1;
    } else if (quantity > productData.stock) {
        document.getElementById('quantity').value = productData.stock;
        quantity = productData.stock;
    }
    
    // Update hidden input in form
    document.getElementById('hidden_quantity').value = quantity;
    
    const destinationId = document.getElementById('destination_id').value;
    if (destinationId) {
        calculateShippingCost();
    } else {
    updatePricing(quantity);
    }
}

function updatePricing(quantity) {
    const shippingMethodInput = document.querySelector('input[name="shipping"]:checked');
    let shippingCost = 0;
    if (shippingMethodInput) {
        const shippingValue = shippingMethodInput.value;
        const shippingData = shippingValue.split('_');
        shippingCost = parseInt(shippingData[2] || 0);
    }
    const subtotal = productData.price * quantity;
    const total = subtotal + shippingCost;
    document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('shipping-cost').textContent = 'Rp ' + formatNumber(shippingCost);
    document.getElementById('total-amount').textContent = 'Rp ' + formatNumber(total);
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.addEventListener('DOMContentLoaded', function() {
    const initialQuantity = parseInt(document.getElementById('quantity').value) || 1;
    
    // Initialize hidden quantity input
    document.getElementById('hidden_quantity').value = initialQuantity;
    
    updatePricing(initialQuantity);
    initRajaOngkirAutocomplete();
    document.addEventListener('change', function(e) {
        if (e.target.name === 'shipping') {
            const shippingValue = e.target.value;
            const shippingData = shippingValue.split('_');
            const shippingCost = parseInt(shippingData[2] || 0);
            updatePricingWithShipping(shippingCost);
        }
    });
});
</script>
@endsection

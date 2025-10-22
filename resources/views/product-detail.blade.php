@extends('layouts.app')

@section('title', $product->name . ' - ' . ($storeName ?? 'WomanToys'))

@section('content')
    <div class="container mx-auto px-4 py-6 md:py-10">
        <!-- Breadcrumb -->
        <nav class="mb-6 md:mb-8">
            <ol class="flex flex-wrap items-center gap-1 md:gap-2 text-xs md:text-sm text-gray-600">
                <li><a href="/" class="hover:text-pink-600 transition-colors duration-200">Beranda</a></li>
                <li><span class="mx-1 md:mx-2">/</span></li>
                <li><a href="{{ route('catalog') }}" class="hover:text-pink-600 transition-colors duration-200">Koleksi</a>
                </li>
                @if ($product->category)
                    <li><span class="mx-1 md:mx-2">/</span></li>
                    <li><a href="{{ route('catalog', ['category' => $product->category->slug]) }}"
                            class="hover:text-pink-600 transition-colors duration-200">{{ $product->category->name }}</a>
                    </li>
                @endif
                <li><span class="mx-1 md:mx-2">/</span></li>
                <li class="text-gray-800 font-medium truncate max-w-[200px] md:max-w-none">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 lg:gap-12 mb-12 md:mb-16">
            <!-- Left Column - Image Gallery -->
            <div>
                <!-- Main Image/Video -->
                <div class="mb-4 md:mb-6" id="main-media-container">
                    @if ($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
                            class="w-full object-contain rounded-lg shadow-lg"
                            id="main-product-image">
                    @else
                        <div
                            class="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] bg-gray-200 flex items-center justify-center rounded-lg shadow-lg">
                            <div class="text-center">
                                <svg class="mx-auto h-16 w-16 md:h-24 md:w-24 text-gray-400 mb-2 md:mb-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 text-sm md:text-lg font-medium">Tidak Ada Gambar</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Gallery -->
                <div class="flex overflow-x-auto space-x-3 md:space-x-4 py-2 scrollbar-hide"
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    @if ($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }} - Gambar Utama"
                            class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-pink-600 cursor-pointer hover:border-pink-700 transition-colors duration-200 thumbnail-image flex-shrink-0"
                            data-image="{{ $product->main_image_url }}">
                    @endif
                    @foreach ($product->images as $image)
                        @if ($image->isVideo())
                            <video src="{{ asset('storage/' . $image->image_path) }}" muted
                                class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200 thumbnail-image flex-shrink-0"
                                data-image="{{ asset('storage/' . $image->image_path) }}"
                                data-is-video="true">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->name }} - Gambar {{ $loop->iteration }}"
                                class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200 thumbnail-image flex-shrink-0"
                                data-image="{{ asset('storage/' . $image->image_path) }}">
                        @endif
                    @endforeach
                    @foreach ($product->variants()->active()->get() as $variant)
                        @if ($variant->image_url)
                            <img src="{{ $variant->image_url }}"
                                alt="{{ $product->name }} - {{ $variant->name }}"
                                class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200 thumbnail-image flex-shrink-0"
                                data-image="{{ $variant->image_url }}">
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Right Column - Product Information -->
            <div>
                <!-- Product Name -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-3 md:mb-4">
                    {{ $product->name }}
                </h1>

                <!-- Product Price -->
                <div id="price-container" class="mb-4 md:mb-6">
                    @if ($product->hasDiscount())
                        <div class="flex items-center gap-3 flex-wrap">
                            <p class="text-2xl md:text-3xl font-bold text-pink-600">
                                {{ $product->formatted_discount_price }}
                            </p>
                            <p class="text-lg md:text-xl text-gray-400 line-through">
                                {{ $product->formatted_price }}
                            </p>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @else
                        <p class="text-2xl md:text-3xl font-bold text-pink-600">
                            {{ $product->formatted_price }}
                        </p>
                    @endif
                </div>

                <!-- Product Description -->
                <div class="mb-6 md:mb-8">
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                        {{ $product->short_description }}
                    </p>
                </div>

                <!-- Variant Selection (if product has variants) -->
                @if ($product->hasActiveVariants())
                    <div class="mb-6 md:mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Pilih Variant <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="variant-buttons">
                            @foreach ($product->variants()->active()->get() as $variant)
                                <button type="button" 
                                    class="variant-button flex items-center p-3 border-2 border-gray-300 rounded-lg hover:border-pink-500 transition-colors duration-200 text-left"
                                    data-variant-id="{{ $variant->id }}"
                                    data-price="{{ $variant->price }}"
                                    data-discount-price="{{ $variant->discount_price }}"
                                    data-stock="{{ $variant->stock }}"
                                    data-image="{{ $variant->image_url }}"
                                    data-formatted-price="{{ $variant->formatted_price }}"
                                    data-formatted-discount-price="{{ $variant->formatted_discount_price }}"
                                    data-formatted-final-price="{{ $variant->formatted_final_price }}"
                                    data-has-discount="{{ $variant->hasDiscount() ? 'true' : 'false' }}"
                                    data-discount-percentage="{{ $variant->discount_percentage }}">
                                    @if ($variant->image_url)
                                        <img src="{{ $variant->image_url }}" 
                                            alt="{{ $variant->name }}"
                                            class="w-12 h-12 object-cover rounded-md mr-3 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-md mr-3 flex-shrink-0 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $variant->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if ($variant->stock > 0)
                                                {{ $variant->stock }} stok
                                            @else
                                                Stok Habis
                                            @endif
                                        </p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                        <p class="text-gray-500 text-xs mt-2">Pilih variant sebelum melakukan pembelian</p>
                    </div>
                @endif

                <!-- Product Info -->
                <div class="mb-6 space-y-2 md:space-y-3">
                    <!-- Stock Status -->
                    <div>
                        @if ($product->stock > 0)
                            <p class="text-green-600 font-medium text-sm md:text-base">
                                <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Tersedia ({{ $product->stock }} stok)
                            </p>
                        @else
                            <p class="text-red-600 font-medium text-sm md:text-base">
                                <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Habis Stok
                            </p>
                        @endif
                    </div>

                    <!-- Weight Info -->
                    @if ($product->weight)
                        <div>
                            <p class="text-gray-600 font-medium text-sm md:text-base">
                                <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Berat: {{ $product->formatted_weight }}
                            </p>
                        </div>
                    @endif

                    <!-- Category -->
                    @if ($product->category)
                        <div>
                            <p class="text-gray-600 font-medium text-sm md:text-base">
                                <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Kategori: {{ $product->category->name }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Quantity Input -->
                <div class="mb-6">
                    <div class="inline-flex items-center">
                        <button type="button" id="decrease-btn" class="px-3 py-2 border border-gray-300 bg-white text-gray-700 rounded-l-md hover:bg-gray-50 transition-colors duration-200">
                            -
                        </button>
                        <input type="number" id="quantity-input" value="1" min="1" max="{{ $product->stock }}"
                            class="w-20 px-2 py-2 border-t border-b border-gray-300 text-center focus:outline-none focus:border-pink-600">
                        <button type="button" id="increase-btn" class="px-3 py-2 border border-gray-300 bg-white text-gray-700 rounded-r-md hover:bg-gray-50 transition-colors duration-200">
                            +
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div id="buy-button-container" class="flex flex-col sm:flex-row gap-3">
                    @if ($product->hasActiveVariants())
                        <button id="add-to-cart-button"
                            class="w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed"
                            disabled>
                            Tambah ke Keranjang
                        </button>
                        <button id="buy-button"
                            class="w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed"
                            disabled>
                            Beli Sekarang
                        </button>
                    @else
                        @if ($product->stock > 0)
                            <button onclick="handleAddToCart()"
                                class="w-full sm:w-1/2 bg-white border-2 border-pink-600 text-pink-600 hover:bg-pink-50 font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-colors duration-200">
                                Tambah ke Keranjang
                            </button>
                            <button onclick="handleBuyNow()"
                                class="w-full sm:w-1/2 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                                Beli Sekarang
                            </button>
                        @else
                            <button
                                class="w-full bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed"
                                disabled>
                                Habis Stok
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Information Tabs -->
        <div class="pt-6 md:pt-8">
            <!-- Tab Navigation -->
            <div class="flex flex-col sm:flex-row border-b border-gray-200 mb-6 md:mb-8">
                <button
                    class="px-3 w-full  sm:w-auto md:px-6 py-2 md:py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200 text-sm md:text-base"
                    data-tab="description" id="tab-description">
                    Deskripsi Lengkap
                </button>
                <button
                    class="px-3 w-full sm:w-auto md:px-6 py-2 md:py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200 text-sm md:text-base"
                    data-tab="specifications" id="tab-specifications">
                    Spesifikasi
                </button>
                <button
                    class="px-3 w-full sm:w-auto md:px-6 py-2 md:py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200 text-sm md:text-base"
                    data-tab="care" id="tab-care">
                    Petunjuk Perawatan
                </button>
            </div>

            <!-- Tab Content -->
            <div class="space-y-4 md:space-y-6">
                <!-- Complete Description Tab (Active) -->
                <div data-tab-content="description">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Deskripsi Lengkap</h3>
                    <div class="prose prose-sm md:prose-lg text-gray-600 space-y-3 md:space-y-4">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="hidden" data-tab-content="specifications">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Spesifikasi</h3>
                    <div class="prose prose-sm md:prose-lg text-gray-600 space-y-3 md:space-y-4">
                        {!! nl2br(e($product->specifications)) !!}
                    </div>
                </div>

                <!-- Care Instructions Tab -->
                <div class="hidden" data-tab-content="care">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Petunjuk Perawatan</h3>
                    <div class="prose prose-sm md:prose-lg text-gray-600 space-y-3 md:space-y-4">
                        {!! nl2br(e($product->care_instructions)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="border-t border-gray-200 pt-8 md:pt-12 mt-12 md:mt-16">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 md:mb-8">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        // ANCHOR: Handle variant selection
        let selectedVariantId = null;
        let maxStock = {{ $product->stock }};

        function updateQuantityForInput(input, triggerRecalc = false) {
            const qty = Math.max(1, parseInt(input.value) || 1);
            const max = parseInt(input.getAttribute('max')) || Infinity;
            input.value = Math.min(qty, max);
        }

        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity-input');
            const max = parseInt(quantityInput.getAttribute('max')) || Infinity;
            let val = parseInt(quantityInput.value) || 1;
            if (val < max) {
                val++;
            }
            quantityInput.value = val;
            updateQuantityForInput(quantityInput);
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity-input');
            let val = parseInt(quantityInput.value) || 1;
            if (val > 1) {
                val--;
            }
            quantityInput.value = val;
            updateQuantityForInput(quantityInput);
        }

        function updateQuantityMax(stock) {
            const quantityInput = document.getElementById('quantity-input');
            
            if (!quantityInput) {
                console.warn('Quantity input element not found');
                return;
            }
            
            quantityInput.max = stock;
            
            // Reset quantity to 1 if current value exceeds new max
            if (parseInt(quantityInput.value) > stock) {
                quantityInput.value = 1;
            }
            
            // If stock is 0, reset to minimum
            if (stock <= 0) {
                quantityInput.value = 1;
                quantityInput.max = 1;
            }
        }

        function handleVariantSelection(button) {
            // Remove selection from all variant buttons
            const variantButtons = document.querySelectorAll('.variant-button');
            variantButtons.forEach(btn => {
                btn.classList.remove('border-pink-600', 'bg-pink-50');
                btn.classList.add('border-gray-300');
            });

            // Add selection to clicked button
            button.classList.remove('border-gray-300');
            button.classList.add('border-pink-600', 'bg-pink-50');

            selectedVariantId = button.dataset.variantId;
            const price = button.dataset.price;
            const discountPrice = button.dataset.discountPrice;
            const stock = parseInt(button.dataset.stock) || 0;
            const image = button.dataset.image;
            const formattedPrice = button.dataset.formattedPrice;
            const formattedDiscountPrice = button.dataset.formattedDiscountPrice;
            const formattedFinalPrice = button.dataset.formattedFinalPrice;
            const hasDiscount = button.dataset.hasDiscount === 'true';
            const discountPercentage = button.dataset.discountPercentage;

            console.log('Variant selected:', {
                variantId: selectedVariantId,
                stock: stock,
                hasStock: stock > 0
            });

            // Update price display
            updatePriceDisplay(hasDiscount, formattedFinalPrice, formattedPrice, formattedDiscountPrice, discountPercentage);

            // Update stock display
            updateStockDisplay(stock);

            // Update image if variant has one
            if (image && image !== 'null' && image !== '') {
                updateMainImage(image);
                updateThumbnailSelection(image);
            }

            // Update quantity max based on variant stock
            updateQuantityMax(stock);

            // Update buy button
            updateBuyButton(stock > 0, stock);
        }

        function updatePriceDisplay(hasDiscount, finalPrice, price, discountPrice, discountPercentage) {
            const priceContainer = document.querySelector('#price-container');
            if (!priceContainer) return;

            if (hasDiscount && discountPrice) {
                priceContainer.innerHTML = `
                    <div class="flex items-center gap-3 flex-wrap">
                        <p class="text-2xl md:text-3xl font-bold text-pink-600">${discountPrice}</p>
                        <p class="text-lg md:text-xl text-gray-400 line-through">${price}</p>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">-${discountPercentage}%</span>
                    </div>
                `;
            } else {
                priceContainer.innerHTML = `
                    <p class="text-2xl md:text-3xl font-bold text-pink-600">${finalPrice}</p>
                `;
            }
        }

        function updateStockDisplay(stock) {
            const stockContainer = document.querySelector('.mb-6.space-y-2 > div:first-child');
            if (!stockContainer) return;

            if (stock > 0) {
                stockContainer.innerHTML = `
                    <p class="text-green-600 font-medium text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Tersedia (${stock} stok)
                    </p>
                `;
            } else {
                stockContainer.innerHTML = `
                    <p class="text-red-600 font-medium text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Habis Stok
                    </p>
                `;
            }
        }

        function updateMainImage(imageUrl) {
            const mainImage = document.getElementById('main-product-image');
            if (mainImage && imageUrl) {
                mainImage.src = imageUrl;
            }
        }

        function updateThumbnailSelection(imageUrl) {
            // Reset all thumbnail borders
            const thumbnailImages = document.querySelectorAll('.thumbnail-image');
            thumbnailImages.forEach(img => {
                img.classList.remove('border-pink-600');
                img.classList.add('border-gray-300');
            });

            // Find and highlight the matching thumbnail
            const matchingThumbnail = document.querySelector(`[data-image="${imageUrl}"]`);
            if (matchingThumbnail) {
                matchingThumbnail.classList.remove('border-gray-300');
                matchingThumbnail.classList.add('border-pink-600');
            }
        }

        function updateBuyButton(hasStock, stock) {
            const buyButton = document.getElementById('buy-button');
            const addToCartButton = document.getElementById('add-to-cart-button');
            
            console.log('updateBuyButton called:', {
                selectedVariantId: selectedVariantId,
                hasStock: hasStock,
                stock: stock,
                buyButtonExists: !!buyButton,
                addToCartButtonExists: !!addToCartButton
            });

            if (!buyButton) {
                console.error('Buy button not found!');
                return;
            }

            if (!selectedVariantId) {
                console.log('No variant selected - disabling buttons');
                buyButton.disabled = true;
                buyButton.className = 'w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed';
                buyButton.textContent = 'Pilih Variant Terlebih Dahulu';
                buyButton.onclick = null;
                
                if (addToCartButton) {
                    addToCartButton.disabled = true;
                    addToCartButton.className = 'w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed';
                    addToCartButton.textContent = 'Pilih Variant Terlebih Dahulu';
                    addToCartButton.onclick = null;
                }
            } else if (hasStock) {
                console.log('Has stock - enabling buttons');
                buyButton.disabled = false;
                buyButton.className = 'w-full sm:w-1/2 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-colors duration-200 shadow-lg hover:shadow-xl';
                buyButton.textContent = 'Beli Sekarang';
                buyButton.onclick = handleBuyNow;
                
                if (addToCartButton) {
                    addToCartButton.disabled = false;
                    addToCartButton.className = 'w-full sm:w-1/2 bg-white border-2 border-pink-600 text-pink-600 hover:bg-pink-50 font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-colors duration-200';
                    addToCartButton.textContent = 'Tambah ke Keranjang';
                    addToCartButton.onclick = handleAddToCart;
                }
            } else {
                console.log('No stock - disabling buttons');
                buyButton.disabled = true;
                buyButton.className = 'w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed';
                buyButton.textContent = 'Habis Stok';
                buyButton.onclick = null;
                
                if (addToCartButton) {
                    addToCartButton.disabled = true;
                    addToCartButton.className = 'w-full sm:w-1/2 bg-gray-400 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg cursor-not-allowed';
                    addToCartButton.textContent = 'Habis Stok';
                    addToCartButton.onclick = null;
                }
            }
        }

        function handleBuyNow() {
            const productId = {{ $product->id }};
            const quantityInput = document.getElementById('quantity-input');
            const quantity = parseInt(quantityInput.value) || 1;
            
            // DIRECT CHECKOUT FLOW: bypass cart, langsung ke checkout
            if (selectedVariantId) {
                // Dengan variant
                window.location.href = `{{ route('checkout') }}?product=${productId}&variant=${selectedVariantId}&quantity=${quantity}&mode=direct`;
            } else {
                // Tanpa variant
                window.location.href = `{{ route('checkout') }}?product=${productId}&quantity=${quantity}&mode=direct`;
            }
        }

        function handleAddToCart() {
            const productId = {{ $product->id }};
            const quantityInput = document.getElementById('quantity-input');
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Prepare product data for cart
            const productData = {
                id: productId,
                name: '{{ addslashes($product->name) }}',
                slug: '{{ $product->slug }}',
                image: '{{ $product->main_image_url ?? '/images/default-product.jpg' }}',
                quantity: quantity
            };

            // Jika ada variant yang dipilih
            if (selectedVariantId) {
                const variantButton = document.querySelector(`.variant-button[data-variant-id="${selectedVariantId}"]`);
                if (!variantButton) {
                    alert('Variant tidak valid. Silakan pilih variant lain.');
                    return;
                }

                const variantName = variantButton.querySelector('p.text-sm.font-medium').textContent;
                const variantPrice = parseFloat(variantButton.dataset.discountPrice) || parseFloat(variantButton.dataset.price);
                const variantOriginalPrice = parseFloat(variantButton.dataset.price);
                const variantStock = parseInt(variantButton.dataset.stock) || 0;
                const hasDiscount = variantButton.dataset.hasDiscount === 'true';
                const discountPercentage = parseInt(variantButton.dataset.discountPercentage) || 0;
                const variantImage = variantButton.dataset.image;

                // Check stock
                if (variantStock <= 0) {
                    alert('Maaf, variant ini sedang habis stok.');
                    return;
                }

                if (quantity > variantStock) {
                    alert(`Maaf, stok variant ini hanya tersedia ${variantStock} item.`);
                    return;
                }

                productData.variantId = selectedVariantId;
                productData.variantName = variantName;
                productData.price = variantPrice;
                productData.originalPrice = variantOriginalPrice;
                productData.stock = variantStock;
                productData.hasDiscount = hasDiscount;
                productData.discountPercentage = discountPercentage;
                if (variantImage && variantImage !== 'null' && variantImage !== '') {
                    productData.image = variantImage;
                }
            } else {
                // Product tanpa variant atau variant belum dipilih
                @if ($product->hasActiveVariants())
                    alert('Silakan pilih variant terlebih dahulu.');
                    return;
                @else
                    const productPrice = {{ $product->discount_price ?? $product->price }};
                    const productOriginalPrice = {{ $product->price }};
                    const productStock = {{ $product->stock }};
                    const hasDiscount = {{ $product->hasDiscount() ? 'true' : 'false' }};
                    const discountPercentage = {{ $product->discount_percentage ?? 0 }};

                    // Check stock
                    if (productStock <= 0) {
                        alert('Maaf, produk ini sedang habis stok.');
                        return;
                    }

                    if (quantity > productStock) {
                        alert(`Maaf, stok produk ini hanya tersedia ${productStock} item.`);
                        return;
                    }

                    productData.price = productPrice;
                    productData.originalPrice = productOriginalPrice;
                    productData.stock = productStock;
                    productData.hasDiscount = hasDiscount;
                    productData.discountPercentage = discountPercentage;
                @endif
            }

            // Add to cart using CartManager
            const success = CartManager.addToCart(productData);
            
            if (success) {
                CartManager.showNotification('✓ Produk berhasil ditambahkan ke keranjang!', 'success');
                console.log('Product added to cart:', productData);
            } else {
                alert('Gagal menambahkan produk ke keranjang. Silakan coba lagi.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize quantity input handlers
            const quantityInput = document.getElementById('quantity-input');
            const increaseBtn = document.getElementById('increase-btn');
            const decreaseBtn = document.getElementById('decrease-btn');

            // Wire up quantity input
            if (quantityInput) {
                // typing / paste / manual change
                quantityInput.addEventListener('input', function() {
                    updateQuantityForInput(this);
                });

                // loss of focus: ensure min applied
                quantityInput.addEventListener('blur', function() {
                    updateQuantityForInput(this);
                });
            }

            // Increase / decrease buttons
            if (increaseBtn) {
                increaseBtn.addEventListener('click', function() {
                    increaseQuantity();
                });
            }

            if (decreaseBtn) {
                decreaseBtn.addEventListener('click', function() {
                    decreaseQuantity();
                });
            }

            // Initialize variant button handlers
            const variantButtons = document.querySelectorAll('.variant-button');
            console.log('Found variant buttons:', variantButtons.length);
            
            variantButtons.forEach(button => {
                button.addEventListener('click', function() {
                    handleVariantSelection(this);
                });
            });

            // Auto-select first variant if available
            if (variantButtons.length > 0) {
                console.log('Auto-selecting first variant...');
                handleVariantSelection(variantButtons[0]);
            } else {
                console.log('No variant buttons found - product has no variants or no active variants');
            }

            // Tab functionality
            const tabButtons = document.querySelectorAll('[data-tab]');
            const tabContents = document.querySelectorAll('[data-tab-content]');

            function switchTab(targetTab) {
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-pink-600', 'border-pink-600', 'bg-pink-50');
                    btn.classList.add('text-gray-500');
                });

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Add active class to target button
                const activeButton = document.querySelector(`[data-tab="${targetTab}"]`);
                if (activeButton) {
                    activeButton.classList.remove('text-gray-500');
                    activeButton.classList.add('text-pink-600', 'border-pink-600', 'bg-pink-50');
                }

                // Show target content
                const targetContent = document.querySelector(`[data-tab-content="${targetTab}"]`);
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                }
            }

            switchTab('description');

            // Add click event listeners to all tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');
                    switchTab(targetTab);
                });
            });

            // Thumbnail gallery functionality
            const thumbnailImages = document.querySelectorAll('.thumbnail-image');
            const mainMediaContainer = document.getElementById('main-media-container');

            thumbnailImages.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    const mediaSrc = this.getAttribute('data-image');
                    const isVideo = this.getAttribute('data-is-video') === 'true';

                    // Clear existing content and create new element
                    if (mainMediaContainer) {
                        mainMediaContainer.innerHTML = '';
                        
                        if (isVideo) {
                            const videoElement = document.createElement('video');
                            videoElement.src = mediaSrc;
                            videoElement.controls = true;
                            videoElement.className = 'w-full object-contain rounded-lg shadow-lg';
                            videoElement.id = 'main-product-image';
                            mainMediaContainer.appendChild(videoElement);
                        } else {
                            const imgElement = document.createElement('img');
                            imgElement.src = mediaSrc;
                            imgElement.alt = 'Product Image';
                            imgElement.className = 'w-full object-contain rounded-lg shadow-lg';
                            imgElement.id = 'main-product-image';
                            mainMediaContainer.appendChild(imgElement);
                        }
                    }

                    // Update thumbnail borders
                    thumbnailImages.forEach(img => {
                        img.classList.remove('border-pink-600');
                        img.classList.add('border-gray-300');
                    });

                    this.classList.remove('border-gray-300');
                    this.classList.add('border-pink-600');
                });
            });
        });
    </script>
@endsection

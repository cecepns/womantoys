@extends('layouts.app')

@section('title', 'Keranjang - ' . ($storeName ?? 'WomanToys'))

@section('content')
    <div class="container mx-auto px-4 py-6 md:py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6">Keranjang Belanja</h1>

        <div id="cart-container" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart items -->
            <div class="lg:col-span-2">
                <div id="cart-items-container" class="bg-white border border-gray-200 rounded-lg shadow-sm px-4">
                    <!-- Cart items akan di-render oleh JavaScript -->
                    <div class="text-center py-8 text-gray-500" id="empty-cart-message">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-lg font-medium">Keranjang Belanja Kosong</p>
                        <p class="text-sm mt-2">Belum ada produk yang ditambahkan ke keranjang</p>
                        <a href="{{ route('catalog') }}" class="inline-block mt-4 px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div>
                <div id="cart-summary" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4" style="display: none;">
                    <h2 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal (<span id="summary-items-count">0</span> item)</span>
                            <span id="summary-subtotal" class="font-medium">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <div class="flex justify-between text-base font-semibold text-gray-900 mb-4">
                            <span>Total</span>
                            <span id="summary-total" class="text-lg text-pink-600">Rp 0</span>
                        </div>
                        <a href="{{ route('checkout') }}?mode=cart" id="checkout-btn" class="block text-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                            Lanjut ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * Render cart items dari localStorage
         */
        function renderCartItems() {
            const cartItems = CartManager.getCartItems();
            const container = document.getElementById('cart-items-container');
            const emptyMessage = document.getElementById('empty-cart-message');
            const summary = document.getElementById('cart-summary');

            // Jika cart kosong
            if (cartItems.length === 0) {
                emptyMessage.style.display = 'block';
                summary.style.display = 'none';
                // Hapus semua cart items
                const existingItems = container.querySelectorAll('.cart-item-row');
                existingItems.forEach(item => item.remove());
                return;
            }

            // Sembunyikan empty message & tampilkan summary
            emptyMessage.style.display = 'none';
            summary.style.display = 'block';

            // Clear existing items
            const existingItems = container.querySelectorAll('.cart-item-row');
            existingItems.forEach(item => item.remove());

            // Render setiap cart item
            cartItems.forEach((item, index) => {
                const subTotal = item.price * item.quantity;
                const isLastItem = index === cartItems.length - 1;
                
                const itemHTML = `
                    <div class="cart-item-row flex flex-col sm:flex-row items-start sm:items-center gap-4 py-4 border-b border-gray-300 ${isLastItem ? 'last:border-b-0' : ''}" data-cart-item-id="${item.cartItemId}">
                        <a href="/product/${item.slug}" class="flex-shrink-0">
                            <img src="${item.image}" alt="${item.name}" 
                                class="w-20 h-20 aspect-square object-cover rounded-md" 
                                onerror="this.src='/images/default-product.jpg'">
                        </a>

                        <div class="flex-1 min-w-0">
                            <a href="/product/${item.slug}" class="text-gray-900 font-medium hover:text-pink-600 block truncate">
                                ${item.name}
                            </a>
                            ${item.variantName ? `<div class="text-sm text-gray-600 mt-1">Variant: ${item.variantName}</div>` : ''}
                            
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-sm text-gray-600">Harga:</span>
                                <span class="text-sm font-semibold text-gray-900">${CartManager.formatPrice(item.price)}</span>
                                ${item.hasDiscount ? `<span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">-${item.discountPercentage}%</span>` : ''}
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex flex-col items-end gap-3">
                            <button type="button" 
                                class="remove-item text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition-colors" 
                                data-cart-item-id="${item.cartItemId}">
                                Hapus
                            </button>
                            
                            <div class="flex flex-col items-end w-full">
                                
                                <div class="inline-flex items-center">
                                    <button type="button" 
                                        class="decrease-btn px-3 py-2 border border-gray-300 bg-white text-gray-700 rounded-l-md hover:bg-gray-50 transition-colors"
                                        data-cart-item-id="${item.cartItemId}">
                                        -
                                    </button>
                                    <input type="number" 
                                        min="1" 
                                        max="${item.stock}" 
                                        value="${item.quantity}" 
                                        class="quantity-input w-16 sm:w-20 px-2 py-2 border-t border-b border-gray-300 text-center focus:outline-none focus:border-pink-600" 
                                        data-cart-item-id="${item.cartItemId}" 
                                        data-price="${item.price}" />
                                    <button type="button" 
                                        class="increase-btn px-3 py-2 border border-gray-300 bg-white text-gray-700 rounded-r-md hover:bg-gray-50 transition-colors"
                                        data-cart-item-id="${item.cartItemId}">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="text-sm text-gray-700">
                                Subtotal: <span class="font-semibold subtotal">${CartManager.formatPrice(subTotal)}</span>
                            </div>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', itemHTML);
            });

            // Update summary
            updateCartSummary();
            
            // Attach event listeners
            attachCartEventListeners();
        }

        /**
         * Update ringkasan keranjang
         */
        function updateCartSummary() {
            const total = CartManager.getCartTotal();
            const count = CartManager.getCartCount();

            document.getElementById('summary-items-count').textContent = count;
            document.getElementById('summary-subtotal').textContent = CartManager.formatPrice(total);
            document.getElementById('summary-total').textContent = CartManager.formatPrice(total);
        }

        /**
         * Attach event listeners ke cart items
         */
        function attachCartEventListeners() {
            // Quantity input change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartItemId = this.dataset.cartItemId;
                    const quantity = parseInt(this.value) || 1;
                    CartManager.updateQuantity(cartItemId, quantity);
                    renderCartItems();
                });

                input.addEventListener('blur', function() {
                    const quantity = parseInt(this.value) || 1;
                    const max = parseInt(this.getAttribute('max')) || 999;
                    this.value = Math.min(Math.max(1, quantity), max);
                });
            });

            // Increase button
            document.querySelectorAll('.increase-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartItemId = this.dataset.cartItemId;
                    const input = document.querySelector(`.quantity-input[data-cart-item-id="${cartItemId}"]`);
                    if (input) {
                        const max = parseInt(input.getAttribute('max')) || 999;
                        let val = parseInt(input.value) || 1;
                        if (val < max) {
                            val++;
                            input.value = val;
                            CartManager.updateQuantity(cartItemId, val);
                            renderCartItems();
                        }
                    }
                });
            });

            // Decrease button
            document.querySelectorAll('.decrease-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartItemId = this.dataset.cartItemId;
                    const input = document.querySelector(`.quantity-input[data-cart-item-id="${cartItemId}"]`);
                    if (input) {
                        let val = parseInt(input.value) || 1;
                        if (val > 1) {
                            val--;
                            input.value = val;
                            CartManager.updateQuantity(cartItemId, val);
                            renderCartItems();
                        }
                    }
                });
            });

            // Remove button
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartItemId = this.dataset.cartItemId;
                    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                        CartManager.removeFromCart(cartItemId);
                        renderCartItems();
                        CartManager.showNotification('Produk berhasil dihapus dari keranjang', 'success');
                    }
                });
            });
        }

        // Listen to cart update events
        window.addEventListener('cartUpdated', function() {
            renderCartItems();
        });

        // Initial render
        document.addEventListener('DOMContentLoaded', function() {
            renderCartItems();
            
            // Checkout button validation
            document.getElementById('checkout-btn').addEventListener('click', function(e) {
                const cartItems = CartManager.getCartItems();
                if (!cartItems || cartItems.length === 0) {
                    e.preventDefault();
                    alert('Keranjang kosong! Tambahkan produk terlebih dahulu.');
                    return false;
                }
            });
        });
    </script>
@endsection

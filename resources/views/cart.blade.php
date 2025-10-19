@extends('layouts.app')

@section('title', 'Keranjang - ' . ($storeName ?? 'WomanToys'))

@section('content')
    @php
        // Dummy cart data (no DB integration)
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Dollhouse Miniature Set',
                'price' => 120000,
                'quantity' => 2,
                'thumbnail' => '/build/images/sample-product-1.jpg',
                'variant' => 'Pink / Small'
            ],
            [
                'id' => 2,
                'name' => 'Plush Teddy Bear',
                'price' => 85000,
                'quantity' => 1,
                'thumbnail' => '/build/images/sample-product-2.jpg',
                'variant' => null
            ],
        ];

        $grandTotal = 0;
        foreach ($cartItems as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }
    @endphp

    <div class="container mx-auto px-4 py-6 md:py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6">Keranjang Belanja</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart items -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    @foreach ($cartItems as $item)
                        @php $subTotal = $item['price'] * $item['quantity']; @endphp
                        <div class="flex items-center gap-4 py-3 border-b border-gray-300 last:border-b-0">
                            <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 object-cover rounded-md">

                            <div class="flex-1">
                                <a href="#" class="text-gray-900 font-medium hover:text-pink-600">{{ $item['name'] }}</a>
                                @if ($item['variant'])
                                    <div class="text-sm text-gray-600">Variant: {{ $item['variant'] }}</div>
                                @endif
                                <div class="mt-2 flex items-center gap-3">
                                    <div class="text-sm text-gray-600">Harga satuan:</div>
                                    <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div style="width: 150px" class="flex-shrink-0 text-right">
                                <label class="text-xs text-gray-500 block mb-1">Jumlah</label>

                                <div class="inline-flex items-center w-full">
                                    <button type="button" class="decrease-btn px-3 py-1 border border-gray-300 bg-white text-gray-700 rounded-l-md">-</button>
                                    <input type="number" min="1" value="{{ $item['quantity'] }}" class="w-full px-2 py-1 border-t border-b border-gray-300 quantity-input text-center" data-price="{{ $item['price'] }}" />
                                    <button type="button" class="increase-btn px-3 py-1 border border-gray-300 bg-white text-gray-700 rounded-r-md">+</button>
                                </div>

                                <div class="mt-3 text-sm text-gray-700">Subtotal:
                                    <span class="font-semibold subtotal">Rp {{ number_format($subTotal, 0, ',', '.') }}</span>
                                </div>

                                <button type="button" class="mt-3 inline-block text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded remove-item" data-id="{{ $item['id'] }}">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary -->
            <div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h2 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h2>
                    <!-- Total retained per request -->
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <div>Total</div>
                        <div id="summary-total" class="text-lg font-semibold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
                    </div>

                    <div class="pt-3 mt-3">
                        <a href="{{ route('checkout') }}" class="block text-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">Lanjut ke Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Basic frontend-only behavior: update subtotal and total when quantity changes.
        // Helper: recalc total from per-item subtotals
        function recalcTotal() {
            let sum = 0;
            document.querySelectorAll('.subtotal').forEach(function(el) {
                const text = el.textContent.replace(/[^0-9]/g, '');
                if (text) sum += parseInt(text);
            });
            const totalEl = document.getElementById('summary-total');
            if (totalEl) {
                totalEl.textContent = 'Rp ' + sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        }

        // Centralized update when quantity changes (frontend-only)
        function updateQuantityForInput(input, triggerRecalc = true) {
            const qty = Math.max(1, parseInt(input.value) || 1);
            input.value = qty;
            const price = parseInt(input.dataset.price) || 0;
            const subtotalEl = input.closest('.flex').querySelector('.subtotal');
            const newSubtotal = qty * price;
            subtotalEl.textContent = 'Rp ' + newSubtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            if (triggerRecalc) recalcTotal();
        }

        // Wire up quantity inputs
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            // typing / paste / manual change
            input.addEventListener('input', function() {
                updateQuantityForInput(this);
            });

            // loss of focus: ensure min applied
            input.addEventListener('blur', function() {
                updateQuantityForInput(this);
            });
        });

        // Increase / decrease buttons
        document.querySelectorAll('.increase-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (!input) return;
                const max = parseInt(input.getAttribute('max')) || Infinity;
                let val = parseInt(input.value) || 1;
                if (val < max) val++;
                input.value = val;
                updateQuantityForInput(input);
            });
        });

        document.querySelectorAll('.decrease-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (!input) return;
                let val = parseInt(input.value) || 1;
                if (val > 1) val--;
                input.value = val;
                updateQuantityForInput(input);
            });
        });

        // Remove item (frontend only)
        document.querySelectorAll('.remove-item').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const itemRow = this.closest('.flex.items-center');
                if (itemRow) itemRow.remove();

                // recalc total after removal
                recalcTotal();
            });
        });
    </script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Order Detail - Admin Panel')

@section('page-title', 'Detail Pesanan: ' . $order->order_number)
@section('page-description', 'Lihat detail lengkap pesanan pelanggan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between flex-col sm:flex-row gap-4 sm:gap-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan: {{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-2">Lihat detail lengkap pesanan pelanggan</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Order Status Banner -->
@php
    $statusConfig = [
        'menunggu_pembayaran' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'icon_bg' => 'bg-yellow-100',
            'icon_color' => 'text-yellow-600',
            'text_color' => 'text-yellow-800',
            'subtitle_color' => 'text-yellow-700',
            'label' => 'Menunggu Pembayaran'
        ],
        'sudah_dibayar' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'icon_bg' => 'bg-blue-100',
            'icon_color' => 'text-blue-600',
            'text_color' => 'text-blue-800',
            'subtitle_color' => 'text-blue-700',
            'label' => 'Sudah Dibayar'
        ],
        'sedang_diproses' => [
            'bg' => 'bg-indigo-50',
            'border' => 'border-indigo-200',
            'icon_bg' => 'bg-indigo-100',
            'icon_color' => 'text-indigo-600',
            'text_color' => 'text-indigo-800',
            'subtitle_color' => 'text-indigo-700',
            'label' => 'Sedang Diproses'
        ],
        'dikirim' => [
            'bg' => 'bg-purple-50',
            'border' => 'border-purple-200',
            'icon_bg' => 'bg-purple-100',
            'icon_color' => 'text-purple-600',
            'text_color' => 'text-purple-800',
            'subtitle_color' => 'text-purple-700',
            'label' => 'Dikirim'
        ],
        'diterima' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-600',
            'text_color' => 'text-green-800',
            'subtitle_color' => 'text-green-700',
            'label' => 'Diterima'
        ],
        'dibatalkan' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon_bg' => 'bg-red-100',
            'icon_color' => 'text-red-600',
            'text_color' => 'text-red-800',
            'subtitle_color' => 'text-red-700',
            'label' => 'Dibatalkan'
        ]
    ];
    $config = $statusConfig[$order->status] ?? $statusConfig['menunggu_pembayaran'];
@endphp

<div class="mb-6 {{ $config['bg'] }} border {{ $config['border'] }} rounded-lg p-4">
    <div class="flex items-center">
        <div class="w-10 h-10 {{ $config['icon_bg'] }} rounded-lg flex items-center justify-center mr-3">
            <svg class="w-5 h-5 {{ $config['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold {{ $config['text_color'] }}">Status: {{ $config['label'] }}</h3>
            <p class="{{ $config['subtitle_color'] }}">Pesanan dibuat pada {{ $order->created_at->format('d F Y') }} pukul {{ $order->created_at->format('H:i') }} WIB</p>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pelanggan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $order->customer_name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900">{{ $order->customer_email }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                    <p class="text-gray-900">
                        {!! nl2br(e($order->shipping_address)) !!}
                    </p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pengiriman</label>
                    <p class="text-gray-900">{{ $order->shipping_method }}</p>
                </div>
            </div>
        </div>

        <!-- Products Ordered -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Produk yang Dipesan
            </h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Harga
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden mr-3">
                                            @if($item->product && $item->product->main_image)
                                                <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product->name ?? 'Produk tidak ditemukan' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($item->product)
                                                    {{ $item->product->category->name ?? 'Kategori tidak ditemukan' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden sm:table-cell">
                                    {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 hidden md:table-cell">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Voucher Information -->
        @if($order->voucher_id || $order->voucher_code)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 00 2 2h3l2 2h6l2-2h3a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    Informasi Voucher
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($order->voucher)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Voucher</label>
                            <p class="text-gray-900 font-medium">{{ $order->voucher->code }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Voucher</label>
                            <p class="text-gray-900">{{ $order->voucher->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Diskon</label>
                            <p class="text-gray-900">
                                @if($order->voucher->type === 'percentage')
                                    Persentase ({{ $order->voucher->value }}%)
                                @else
                                    Nominal (Rp {{ number_format($order->voucher->value, 0, ',', '.') }})
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Pembelian</label>
                            <p class="text-gray-900">Rp {{ number_format($order->voucher->min_purchase, 0, ',', '.') }}</p>
                        </div>
                    @else
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Voucher</label>
                            <p class="text-gray-900 font-medium">{{ $order->voucher_code }}</p>
                            <p class="text-sm text-gray-500 mt-1">Voucher tidak ditemukan dalam sistem</p>
                        </div>
                    @endif
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Diskon</label>
                        <p class="text-gray-900 font-semibold text-green-600">
                            - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Ringkasan Pesanan
            </h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diskon Voucher</span>
                        <span class="font-medium text-green-600">- {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Ongkos Kirim</span>
                    <span class="font-medium">{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <hr class="border-gray-200">
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span>{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Actions & Transfer Proof -->
    <div class="space-y-6">
        <!-- Status Management -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Ubah Status Pesanan
            </h2>
            
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Baru
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        required
                    >
                        <option value="menunggu_pembayaran" {{ $order->status === 'menunggu_pembayaran' ? 'selected' : '' }}>
                            Menunggu Pembayaran
                        </option>
                        <option value="sudah_dibayar" {{ $order->status === 'sudah_dibayar' ? 'selected' : '' }}>
                            Sudah Dibayar
                        </option>
                        <option value="sedang_diproses" {{ $order->status === 'sedang_diproses' ? 'selected' : '' }}>
                            Sedang Diproses
                        </option>
                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>
                            Dikirim
                        </option>
                        <option value="diterima" {{ $order->status === 'diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>
                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                >
                    Update Status
                </button>
            </form>
        </div>

        <!-- Transfer Proof -->
        @if($order->payment_proof_path)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Bukti Transfer
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <img src="{{ asset('storage/' . $order->payment_proof_path) }}" 
                             alt="Bukti Transfer" 
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

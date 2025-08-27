@extends('admin.layouts.app')

@section('title', 'Order Detail - Admin Panel')

@section('page-title', 'Detail Pesanan: ' . $order->order_number)
@section('page-description', 'Lihat detail lengkap pesanan pelanggan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan: {{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-2">Lihat detail lengkap pesanan pelanggan</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
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
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga Satuan
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 mr-3">
                                        @if($item->product && $item->product->main_image)
                                            <img 
                                                src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                alt="{{ $item->product_name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        @else
                                            <img 
                                                src="{{ asset('images/default-product.jpg') }}" 
                                                alt="{{ $item->product_name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        @if($item->product)
                                            <div class="text-sm text-gray-500">{{ $item->product->category->name ?? 'Kategori tidak tersedia' }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $item->formatted_price }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $item->formatted_subtotal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Rincian Pembayaran
            </h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Subtotal Produk</span>
                    <span class="text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Biaya Pengiriman</span>
                    <span class="text-gray-900">{{ $order->formatted_shipping_cost }}</span>
                </div>
                
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total Pembayaran</span>
                        <span class="text-lg font-bold text-pink-600">{{ $order->formatted_total_amount }}</span>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="text-gray-900 font-medium">Transfer Bank</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mt-1">
                        <span class="text-gray-600">Status Pembayaran</span>
                        @if($order->status === 'menunggu_pembayaran')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                Belum Lunas
                            </span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                Lunas
                            </span>
                        @endif
                    </div>
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
                    <label for="order_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Pesanan Saat Ini
                    </label>
                    <select
                        id="order_status"
                        name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        required
                    >
                        <option value="menunggu_pembayaran" {{ $order->status === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="sudah_dibayar" {{ $order->status === 'sudah_dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="sedang_diproses" {{ $order->status === 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="diterima" {{ $order->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <button
                    type="submit"
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Update Status
                </button>
            </form>
        </div>

        <!-- Transfer Proof -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Bukti Transfer Pelanggan
            </h2>
            
            <div class="space-y-4">
                @if($order->payment_proof_path)
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <img 
                            id="transfer_proof"
                            src="{{ asset('storage/' . $order->payment_proof_path) }}" 
                            alt="Bukti Transfer"
                            class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity duration-200"
                            onclick="openImageModal(this.src)"
                        >
                        <p class="text-sm text-gray-500 mt-2">Klik untuk melihat gambar lebih besar</p>
                    </div>
                    
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Nama Pengirim:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Tanggal Upload:</strong> {{ $order->updated_at->format('d M Y, H:i') }} WIB</p>
                        <p><strong>Jumlah Transfer:</strong> {{ $order->formatted_total_amount }}</p>
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Bukti transfer belum diunggah oleh pelanggan</p>
                    </div>
                @endif
            </div>
        </div>


    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Bukti Transfer" class="max-w-full max-h-full object-contain">
        <button 
            onclick="closeImageModal()" 
            class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
// Image modal functionality
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Keep only the image modal functionality - other interactions are now handled by the backend
</script>
@endsection

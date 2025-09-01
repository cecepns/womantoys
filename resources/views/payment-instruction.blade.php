@extends('layouts.app')

@section('title', 'Instruksi Pembayaran - WomanToys')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Konfirmasi Pembayaran</h1>
            <p class="text-base md:text-lg text-gray-600">Terima kasih. Pesanan Anda sedang diproses.</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm md:text-base text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-red-600 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm md:text-base text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6">
                <div class="flex items-start">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-red-600 mr-2 md:mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm md:text-base text-red-800 font-medium mb-1 md:mb-2">Terjadi kesalahan:</h3>
                        <ul class="text-xs md:text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Order Information -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Informasi Pesanan</h2>
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Nomor Pesanan:</span>
                    <span class="font-semibold text-sm md:text-base text-gray-800 break-all">{{ $order->order_number }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Total Pembayaran:</span>
                    <span class="text-xl md:text-2xl font-bold text-pink-600">{{ $order->formatted_total_amount }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Tanggal Pesanan:</span>
                    <span class="font-semibold text-sm md:text-base text-gray-800">{{ $order->created_at->format('d F Y') }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Status Pembayaran:</span>
                    @if($order->isPendingPayment())
                    <span class="px-2 md:px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Menunggu Pembayaran</span>
                    @elseif($order->isPaid())
                        <span class="px-2 md:px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Sudah Dibayar</span>
                    @elseif($order->isProcessing())
                        <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Sedang Diproses</span>
                    @elseif($order->isShipped())
                        <span class="px-2 md:px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Dikirim</span>
                    @elseif($order->isDelivered())
                        <span class="px-2 md:px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Diterima</span>
                    @elseif($order->isCancelled())
                        <span class="px-2 md:px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs md:text-sm font-medium self-start sm:self-auto">Dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Detail Pesanan</h2>
            <div class="space-y-3 md:space-y-4">
                @foreach($order->orderItems as $item)
                <div class="p-3 md:p-4 bg-gray-100 rounded-lg">
                    <!-- Mobile Layout -->
                    <div class="block sm:hidden">
                        <h3 class="font-medium text-sm text-gray-800 mb-2">{{ $item->product_name }}</h3>
                        <div class="space-y-1 mb-3">
                            <p class="text-xs text-gray-600">Jumlah: {{ $item->quantity }} pcs</p>
                            @if($item->product && $item->product->weight)
                                <p class="text-xs text-gray-600">Berat: {{ $item->product->formatted_weight }} / pcs</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-sm text-gray-800">{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-600">Total: {{ 'Rp ' . number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <!-- Desktop Layout -->
                    <div class="hidden sm:flex justify-between items-center">
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $item->product_name }}</h3>
                            <div class="flex items-center gap-4 mt-1">
                                <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }} pcs</p>
                                @if($item->product && $item->product->weight)
                                    <p class="text-sm text-gray-600">Berat: {{ $item->product->formatted_weight }} / pcs</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">Total: {{ 'Rp ' . number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="pt-3 md:pt-4 border-t border-gray-200">
                    <div class="flex justify-between text-xs md:text-sm text-gray-600 mb-2">
                        <span>Subtotal:</span>
                        <span>{{ $order->subtotal ? $order->formatted_subtotal : 'Rp ' . number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($order->voucher_id && $order->discount_amount > 0)
                    <div class="flex justify-between text-xs md:text-sm text-green-600 mb-2">
                        <span>Diskon Voucher ({{ $order->voucher_code }}):</span>
                        <span>-{{ $order->formatted_discount_amount }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-xs md:text-sm text-gray-600 mb-2">
                        <span>Ongkir ({{ $order->shipping_method }}):</span>
                        <span>
                            @if($order->voucher && $order->voucher->type === 'free_shipping')
                                <span class="line-through text-gray-400">{{ 'Rp ' . number_format($order->discount_amount, 0, ',', '.') }}</span>
                                <span class="text-green-600 ml-1">Gratis</span>
                            @else
                                {{ $order->formatted_shipping_cost }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-base md:text-lg font-bold text-gray-800">
                        <span>Total:</span>
                        <span>{{ $order->formatted_total_amount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Informasi Pengiriman</h2>
            <div class="space-y-2 md:space-y-3">
                <div>
                    <span class="text-gray-600 block text-xs md:text-sm mb-1">Alamat Pengiriman:</span>
                    <span class="font-medium text-sm md:text-base text-gray-800 whitespace-pre-line break-words">{{ $order->shipping_address }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Metode Pengiriman:</span>
                    <span class="font-semibold text-sm md:text-base text-gray-800">{{ $order->shipping_method }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-0">
                    <span class="text-sm md:text-base text-gray-600">Biaya Pengiriman:</span>
                    <span class="font-semibold text-sm md:text-base text-gray-800">{{ $order->formatted_shipping_cost }}</span>
                </div>
            </div>
        </div>

        <!-- Important Warning Box -->
        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
            <div class="flex items-start">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 mt-0.5 mr-2 md:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-base md:text-lg font-semibold text-yellow-800 mb-2">PENTING</h3>
                    <p class="text-sm md:text-base text-yellow-800 mb-3 md:mb-4">
                        Simpan atau salin link halaman ini. Anda akan membutuhkan link ini untuk mengunggah bukti pembayaran nanti.
                    </p>
                    <button 
                        onclick="copyPageLink()" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-3 md:px-4 rounded-lg transition-colors duration-200 text-sm md:text-base"
                    >
                        Salin Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Bank Account Details -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Lakukan Pembayaran Ke</h2>
            <div class="space-y-3 md:space-y-4">
                @php
                    $activeAccounts = App\Models\BankAccount::active()->get();
                @endphp
                
                @forelse($activeAccounts as $account)
                <div class="p-3 md:p-4 bg-gray-50 rounded-lg">
                    <!-- Mobile Layout -->
                    <div class="block sm:hidden">
                        <p class="font-medium text-sm text-gray-800 mb-1">{{ $account->bank_name }}</p>
                        <p class="text-xs text-gray-600 mb-2">Nomor Rekening</p>
                        <p class="font-mono font-semibold text-gray-800 text-base mb-1 break-all">{{ $account->account_number }}</p>
                        <p class="text-xs text-gray-600">a.n. {{ $account->account_holder_name }}</p>
                    </div>
                    
                    <!-- Desktop Layout -->
                    <div class="hidden sm:flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $account->bank_name }}</p>
                            <p class="text-sm text-gray-600">Nomor Rekening</p>
                        </div>
                        <div class="text-right">
                            <p class="font-mono font-semibold text-gray-800 text-lg">{{ $account->account_number }}</p>
                            <p class="text-sm text-gray-600">a.n. {{ $account->account_holder_name }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 md:py-8 text-gray-500">
                    <p class="text-sm md:text-base">Tidak ada rekening bank yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4 md:mt-6 p-3 md:p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600 mt-0.5 mr-2 md:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-xs md:text-sm text-blue-800">
                        <p class="font-medium mb-1 md:mb-2">Instruksi Pembayaran:</p>
                        <ul class="space-y-1">
                            <li>• Transfer dengan jumlah yang tepat: <strong>{{ $order->formatted_total_amount }}</strong></li>
                            <li>• Sertakan nomor pesanan dalam keterangan transfer: <strong class="break-all">{{ $order->order_number }}</strong></li>
                            <li>• Unggah bukti pembayaran dalam 24 jam</li>
                            <li>• Pesanan akan dibatalkan jika pembayaran tidak dikonfirmasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Confirmation Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Konfirmasi Pembayaran Anda</h2>
            
            @if($order->isPaid())
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-green-800">Pembayaran Sudah Dikonfirmasi!</h3>
                            <p class="text-sm md:text-base text-green-700">Bukti pembayaran Anda sudah diterima. Pesanan sedang diproses.</p>
                        </div>
                    </div>
                </div>
                
                @if($order->payment_proof_path)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6">
                        <h3 class="text-base md:text-lg font-semibold text-blue-800 mb-2">Bukti Pembayaran</h3>
                        <div class="flex items-center space-x-3 md:space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-blue-800 font-medium text-sm md:text-base truncate">{{ basename($order->payment_proof_path) }}</p>
                                <p class="text-blue-600 text-xs md:text-sm">File bukti pembayaran</p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-xs md:text-sm">
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <form action="{{ route('payment.confirm') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6" novalidate>
                    @csrf
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                <!-- Upload Payment Proof -->
                <div>
                    <label for="paymentProof" class="block text-sm font-medium text-gray-700 mb-2">
                        Unggah Bukti Pembayaran
                    </label>
                        
                                                <!-- Hidden file input (always available for form validation) -->
                        <input 
                            type="file" 
                            id="paymentProof" 
                            name="payment_proof" 
                            accept=".png,.jpg,.jpeg,.pdf"
                            class="sr-only"
                        >
                        
                        <!-- Upload Area (shown when no file selected) -->
                        <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-lg p-4 md:p-6 text-center hover:border-pink-400 transition-colors duration-200">
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-gray-400 mx-auto mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm md:text-base text-gray-600 mb-2">Klik untuk mengunggah atau seret dan lepas</p>
                            <p class="text-xs md:text-sm text-gray-500">PNG, JPG, PDF hingga 10MB</p>
                        </div>
                        
                        <!-- Preview Area (shown when file is selected) -->
                        <div id="preview-area" class="hidden">
                            <!-- Image Preview -->
                            <div id="image-preview" class="hidden">
                                <div class="relative">
                                    <img id="preview-image" 
                                         alt="Preview Bukti Pembayaran" 
                                         class="w-full h-32 md:h-48 object-contain border border-gray-200 rounded-lg">
                                    <div class="absolute top-2 right-2 flex space-x-2">
                                        <button onclick="deleteFile()" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-1.5 md:p-2 rounded-full shadow-lg transition-colors cursor-pointer">
                                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-3 text-center">
                                    <p id="file-name" class="text-green-600 font-medium text-xs md:text-sm"></p>
                                    <p class="text-xs text-gray-500 mt-1">Hapus file terlebih dahulu untuk mengupload file baru</p>
                                </div>
                            </div>
                            
                            <!-- PDF Preview -->
                            <div id="pdf-preview" class="hidden">
                                <div class="flex items-center justify-center p-4 md:p-8 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-red-500 mx-auto mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-800 font-medium mb-2 text-sm md:text-base">File PDF</p>
                                        <p id="pdf-file-name" class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4"></p>
                                        <button onclick="deleteFile()" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors cursor-pointer">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 inline mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus File
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-3 text-center">
                                    <p class="text-xs text-gray-500">Hapus file terlebih dahulu untuk mengupload file baru</p>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3" 
                        class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none text-sm md:text-base"
                        placeholder="Tambahkan informasi tambahan tentang pembayaran Anda..."
                        >{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                        id="submitBtn"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-lg md:text-xl transition-colors duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="submitText">Konfirmasi Pembayaran</span>
                        <span id="submitLoading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                </button>
            </form>
            @endif
        </div>

        <!-- Contact Information -->
        <div class="mt-6 md:mt-8 text-center">
            <p class="text-sm md:text-base text-gray-600 mb-2">Butuh bantuan? Hubungi layanan pelanggan kami:</p>
            <p class="text-pink-600 font-medium text-sm md:text-base">WhatsApp: +62 812-3456-7890</p>
            <p class="text-pink-600 font-medium text-sm md:text-base">Email: support@womantoys.com</p>
        </div>
    </div>
</div>

<script>
function copyPageLink(event) {
    // Pastikan event diterima dari onclick
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show success message
        const button = event.target || event.currentTarget;
        const originalText = button.textContent;
        button.textContent = 'Link Disalin!';
        button.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
        button.classList.add('bg-green-600', 'hover:bg-green-700');
        
        setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('bg-green-600', 'hover:bg-green-700');
            button.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
        }, 2000);
    });
}

// File upload handling
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('paymentProof');
    
    if (!fileInput) {
        console.log('Payment proof input not found');
        return;
    }
    
    const uploadArea =  document.getElementById('upload-area');
    
    if (!uploadArea) {
        console.log('Upload area not found');
        return;
    }
    
    // Click handler for upload area
    uploadArea.addEventListener('click', function(e) {
        if (e.target !== fileInput) {
            // Check if there's already a file selected
            if (fileInput.files && fileInput.files.length > 0) {
                // Show alert to delete first
                alert('Silakan hapus file yang sudah dipilih terlebih dahulu sebelum mengupload file baru.');
                return;
            }
            fileInput.click();
        }
    });
    
    // Drag and drop handlers
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-pink-400', 'bg-pink-50');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-pink-400', 'bg-pink-50');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-pink-400', 'bg-pink-50');
        
        // Check if there's already a file selected
        if (fileInput.files && fileInput.files.length > 0) {
            alert('Silakan hapus file yang sudah dipilih terlebih dahulu sebelum mengupload file baru.');
            return;
        }
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });
        
    fileInput.addEventListener('change', function(e) {
        // Check if there's already a file selected (prevent multiple files)
        if (fileInput.files && fileInput.files.length > 1) {
            alert('Silakan hapus file yang sudah dipilih terlebih dahulu sebelum mengupload file baru.');
            // Reset to first file only
            const firstFile = fileInput.files[0];
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(firstFile);
            fileInput.files = dataTransfer.files;
            return;
        }
        
    const file = e.target.files[0];
    if (file) {
            handleFileSelect(file);
        }
    });
        
    const form = document.querySelector('form[action*="payment.confirm"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted');
            const fileInput = document.getElementById('paymentProof');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            
            // Validate file selection
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file bukti pembayaran terlebih dahulu.');
                
                // Show upload area if hidden
                const uploadArea = document.getElementById('upload-area');
                const previewArea = document.getElementById('preview-area');
                if (uploadArea.classList.contains('hidden')) {
                    uploadArea.classList.remove('hidden');
                    previewArea.classList.add('hidden');
                }
                
                return false;
            }
            
            // Validate file type and size
            const file = fileInput.files[0];
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                e.preventDefault();
                alert('Format file tidak didukung. Gunakan PNG, JPG, atau PDF.');
                return false;
            }
            

            
            console.log('File selected:', file.name);
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
        });
    }

    function handleFileSelect(file) {
        const uploadArea = document.getElementById('upload-area');
        const previewArea = document.getElementById('preview-area');
        const imagePreview = document.getElementById('image-preview');
        const pdfPreview = document.getElementById('pdf-preview');
        const fileInput = document.getElementById('paymentProof');
        
        // Validate file type
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan PNG, JPG, atau PDF.');
            return;
        }
        

        
        // Create preview URL
        const fileUrl = URL.createObjectURL(file);
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        // Hide upload area and show preview area
        uploadArea.classList.add('hidden');
        previewArea.classList.remove('hidden');
        
        // Update UI with preview
        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            // Show image preview
            imagePreview.classList.remove('hidden');
            pdfPreview.classList.add('hidden');
            
            // Update image and file name
            document.getElementById('preview-image').src = fileUrl;
            document.getElementById('file-name').textContent = file.name;
        } else {
            // Show PDF preview
            imagePreview.classList.add('hidden');
            pdfPreview.classList.remove('hidden');
            
            // Update PDF file name
            document.getElementById('pdf-file-name').textContent = file.name;
        }
    }
    
    // Delete file function
    window.deleteFile = function() {
        const fileInput = document.getElementById('paymentProof');
        const uploadArea = document.getElementById('upload-area');
        const previewArea = document.getElementById('preview-area');
        const imagePreview = document.getElementById('image-preview');
        const pdfPreview = document.getElementById('pdf-preview');
        
        // Clear file input
        fileInput.value = '';
        
        // Hide preview area and show upload area
        previewArea.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        
        // Hide both preview types
        imagePreview.classList.add('hidden');
        pdfPreview.classList.add('hidden');
        
        // Clear preview content
        document.getElementById('preview-image').src = '';
        document.getElementById('file-name').textContent = '';
        document.getElementById('pdf-file-name').textContent = '';
    };
});
</script>
@endsection

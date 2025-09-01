@extends('admin.layouts.app')

@section('title', 'Detail Voucher')

@section('page-title', 'Detail Voucher: ' . $voucher->code)
@section('page-description', 'Lihat detail lengkap voucher')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between flex-col sm:flex-row gap-4 sm:gap-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Voucher: {{ $voucher->code }}</h1>
            <p class="text-gray-600 mt-2">Lihat detail lengkap voucher</p>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Voucher Status Banner -->
@php
    $statusConfig = [
        'active' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-600',
            'text_color' => 'text-green-800',
            'subtitle_color' => 'text-green-700',
            'label' => 'Aktif'
        ],
        'inactive' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon_bg' => 'bg-red-100',
            'icon_color' => 'text-red-600',
            'text_color' => 'text-red-800',
            'subtitle_color' => 'text-red-700',
            'label' => 'Tidak Aktif'
        ]
    ];
    $config = $statusConfig[$voucher->is_active ? 'active' : 'inactive'];
@endphp

<div class="mb-6 {{ $config['bg'] }} border {{ $config['border'] }} rounded-lg p-4">
    <div class="flex items-center">
        <div class="w-10 h-10 {{ $config['icon_bg'] }} rounded-lg flex items-center justify-center mr-3">
            <svg class="w-5 h-5 {{ $config['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold {{ $config['text_color'] }}">Status: {{ $config['label'] }}</h3>
            <p class="{{ $config['subtitle_color'] }}">Voucher dibuat pada {{ $voucher->created_at->format('d F Y') }} pukul {{ $voucher->created_at->format('H:i') }} WIB</p>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Voucher Information -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Informasi Voucher
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Voucher</label>
                            <p class="text-gray-900 font-medium">{{ $voucher->code }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Voucher</label>
                            <p class="text-gray-900">{{ $voucher->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Diskon</label>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $voucher->type_label }}</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Diskon</label>
                            <p class="text-gray-900 font-medium">{{ $voucher->formatted_value }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Minimal Pembelian</label>
                            <p class="text-gray-900">
                                @if($voucher->min_purchase > 0)
                                    Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                @else
                                    <em class="text-gray-500">Tidak ada</em>
                                @endif
                            </p>
                        </div>
                        
                        @if($voucher->type === 'percentage' && $voucher->max_discount)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal Diskon</label>
                            <p class="text-gray-900">Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batas Penggunaan</label>
                            <p class="text-gray-900">
                                @if($voucher->usage_limit)
                                    {{ $voucher->usage_limit }} kali
                                @else
                                    <em class="text-gray-500">Tidak terbatas</em>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sudah Digunakan</label>
                            <p class="text-gray-900">{{ $voucher->used_count }} kali</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Berlaku</label>
                            <p class="text-gray-900">
                                @if($voucher->starts_at)
                                    {{ $voucher->starts_at->format('d F Y H:i') }}
                                @else
                                    <em class="text-gray-500">Segera</em>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Berakhir</label>
                            <p class="text-gray-900">
                                @if($voucher->expires_at)
                                    {{ $voucher->expires_at->format('d F Y H:i') }}
                                @else
                                    <em class="text-gray-500">Tidak pernah</em>
                                @endif
                            </p>
                        </div>
                        

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                            <p class="text-gray-900">{{ $voucher->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($voucher->description)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <p class="text-gray-900">{{ $voucher->description }}</p>
            </div>
            @endif

            <!-- Status Warnings -->
            @if($voucher->expires_at && $voucher->expires_at->lt(now()))
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h6 class="text-sm font-semibold text-red-800">Voucher Expired</h6>
                            <p class="text-sm text-red-700 mt-1">Voucher ini sudah kadaluarsa pada {{ $voucher->expires_at->format('d F Y H:i') }}. Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h6 class="text-sm font-semibold text-yellow-800">Kuota Habis</h6>
                            <p class="text-sm text-yellow-700 mt-1">Voucher ini sudah mencapai batas maksimal penggunaan ({{ $voucher->usage_limit }} kali). Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Usage History -->
        @if($voucher->voucherUsages->count() > 0)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Riwayat Penggunaan
            </h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($voucher->voucherUsages as $usage)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->used_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.orders.show', $usage->order) }}" class="text-pink-600 hover:text-pink-900">
                                    {{ $usage->order->order_number }}
                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->customer_email }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->formatted_discount_amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Statistics & Actions -->
    <div class="space-y-6">
        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistik Voucher
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-2xl font-bold text-blue-600">{{ $statistics['total_used'] }}</h4>
                        <small class="text-gray-500 text-xs">Total Digunakan</small>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <h4 class="text-2xl font-bold text-green-600">{{ $statistics['remaining_usage'] }}</h4>
                        <small class="text-gray-500 text-xs">Sisa Kuota</small>
                    </div>
                </div>
                
                <div class="text-center p-4 bg-pink-50 rounded-lg">
                    <h5 class="text-xl font-bold text-pink-600">{{ $statistics['total_discount_given'] ? 'Rp ' . number_format($statistics['total_discount_given'], 0, ',', '.') : 'Rp 0' }}</h5>
                    <small class="text-gray-500 text-xs">Total Diskon Diberikan</small>
                </div>

                @if($voucher->usage_limit)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progress Penggunaan</label>
                    <div class="space-y-2">
                        @php
                            $percentage = ($voucher->used_count / $voucher->usage_limit) * 100;
                            $progressClass = $percentage < 50 ? 'bg-green-500' : ($percentage < 80 ? 'bg-yellow-500' : 'bg-red-500');
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="{{ $progressClass }} h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="text-center">
                            <span class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Voucher Preview -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Preview Voucher
            </h2>
            
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 text-center">
                <div class="mb-3">
                    <svg class="w-12 h-12 text-pink-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h5 class="font-bold text-lg uppercase text-gray-800 mb-2">{{ $voucher->code }}</h5>
                <p class="text-gray-700 text-sm mb-3">{{ $voucher->name }}</p>
                @if($voucher->description)
                <p class="text-gray-500 text-xs mb-3">{{ Str::limit($voucher->description, 50) }}</p>
                @endif
                <div class="mb-3">
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">{{ $voucher->formatted_value }}</span>
                </div>
                <div>
                    <small class="text-gray-500 text-xs">
                        @php
                            $conditions = [];
                            if($voucher->min_purchase) {
                                $conditions[] = 'Min. belanja Rp ' . number_format($voucher->min_purchase, 0, ',', '.');
                            }
                            if($voucher->type === 'percentage' && $voucher->max_discount) {
                                $conditions[] = 'Maks. diskon Rp ' . number_format($voucher->max_discount, 0, ',', '.');
                            }
                            if($voucher->expires_at) {
                                $conditions[] = 'Berlaku sampai ' . $voucher->expires_at->format('d/m/Y');
                            }
                        @endphp
                        {{ Str::limit(implode(' • ', $conditions) ?: 'Tidak ada syarat khusus', 40) }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    setTimeout(function() {
        alert('{{ session("success") }}');
    }, 100);
</script>
@endif
@endsection

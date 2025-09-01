@extends('admin.layouts.app')

@section('title', 'Detail Voucher')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Voucher: {{ $voucher->code }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                <i class="fas fa-edit text-sm text-white mr-1"></i> Edit
            </a>
            <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                <i class="fas fa-arrow-left text-sm text-white mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Voucher Information Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h6 class="text-lg font-semibold text-blue-600">Informasi Voucher</h6>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ str_replace(['bg-', 'text-'], ['bg-', 'text-'], $voucher->status_badge_class) }}">
                        {{ $voucher->status_label }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <table class="w-full">
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Kode:</td>
                                    <td class="py-2">{{ $voucher->code }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Nama:</td>
                                    <td class="py-2">{{ $voucher->name }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Jenis:</td>
                                    <td class="py-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $voucher->type_label }}</span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Nilai:</td>
                                    <td class="py-2">{{ $voucher->formatted_value }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Min. Pembelian:</td>
                                    <td class="py-2">
                                        @if($voucher->min_purchase > 0)
                                            Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                        @else
                                            <em class="text-gray-500">Tidak ada</em>
                                        @endif
                                    </td>
                                </tr>
                                @if($voucher->type === 'percentage' && $voucher->max_discount)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Maks. Diskon:</td>
                                    <td class="py-2">Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div>
                            <table class="w-full">
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Batas Penggunaan:</td>
                                    <td class="py-2">
                                        @if($voucher->usage_limit)
                                            {{ $voucher->usage_limit }} kali
                                        @else
                                            <em class="text-gray-500">Tidak terbatas</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Sudah Digunakan:</td>
                                    <td class="py-2">{{ $voucher->used_count }} kali</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Mulai Berlaku:</td>
                                    <td class="py-2">
                                        @if($voucher->starts_at)
                                            {{ $voucher->starts_at->format('d/m/Y H:i') }}
                                        @else
                                            <em class="text-gray-500">Segera</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Berakhir:</td>
                                    <td class="py-2">
                                        @if($voucher->expires_at)
                                            {{ $voucher->expires_at->format('d/m/Y H:i') }}
                                        @else
                                            <em class="text-gray-500">Tidak pernah</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Pelanggan Baru:</td>
                                    <td class="py-2">
                                        @if($voucher->first_time_only)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Ya</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-semibold text-gray-700">Dibuat:</td>
                                    <td class="py-2">{{ $voucher->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($voucher->description)
                    <div class="mt-6">
                        <h6 class="font-semibold text-gray-700 mb-2">Deskripsi:</h6>
                        <p class="text-gray-600">{{ $voucher->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Usage History -->
            @if($voucher->voucherUsages->count() > 0)
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Riwayat Penggunaan</h6>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($voucher->voucherUsages as $usage)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->used_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.orders.show', $usage->order) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $usage->order->order_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->customer_email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->formatted_discount_amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Statistics and Actions -->
        <div class="lg:col-span-1">
            <!-- Statistics Card -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Statistik</h6>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <div class="border-r border-gray-200">
                                <h4 class="text-2xl font-bold text-blue-600">{{ $statistics['total_used'] }}</h4>
                                <small class="text-gray-500">Total Digunakan</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="text-2xl font-bold text-green-600">{{ $statistics['remaining_usage'] }}</h4>
                            <small class="text-gray-500">Sisa Kuota</small>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h5 class="text-xl font-bold text-blue-500 mb-0">{{ $statistics['total_discount_given'] ? 'Rp ' . number_format($statistics['total_discount_given'], 0, ',', '.') : 'Rp 0' }}</h5>
                        <small class="text-gray-500">Total Diskon Diberikan</small>
                    </div>

                    @if($voucher->usage_limit)
                    <div class="mt-6">
                        <small class="text-gray-500">Progress Penggunaan:</small>
                        <div class="mt-2">
                            @php
                                $percentage = ($voucher->used_count / $voucher->usage_limit) * 100;
                                $progressClass = $percentage < 50 ? 'bg-green-500' : ($percentage < 80 ? 'bg-yellow-500' : 'bg-red-500');
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $progressClass }} h-2.5 rounded-full transition-all duration-300" 
                                     style="width: {{ $percentage }}%">
                                </div>
                            </div>
                            <div class="text-center mt-1">
                                <span class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Voucher Preview -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Preview Voucher</h6>
                </div>
                <div class="p-6">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 text-center">
                        <div class="mb-3">
                            <i class="fas fa-ticket-alt text-4xl text-blue-600"></i>
                        </div>
                        <h5 class="font-bold text-lg uppercase text-gray-800 mb-2">{{ $voucher->code }}</h5>
                        <p class="text-gray-700 mb-2">{{ $voucher->name }}</p>
                        @if($voucher->description)
                        <p class="text-gray-500 text-sm mb-3">{{ $voucher->description }}</p>
                        @endif
                        <div class="mb-3">
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">{{ $voucher->formatted_value }}</span>
                        </div>
                        <div class="mt-3">
                            <small class="text-gray-500">
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
                                {{ implode(' • ', $conditions) ?: 'Tidak ada syarat khusus' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Aksi</h6>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded font-medium transition duration-200 text-center block">
                            <i class="fas fa-edit mr-2"></i> Edit Voucher
                        </a>
                        
                        <form method="POST" action="{{ route('admin.vouchers.toggle-status', $voucher) }}">
                            @csrf
                            <button type="submit" class="w-full {{ $voucher->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded font-medium transition duration-200">
                                <i class="fas fa-{{ $voucher->is_active ? 'times' : 'check' }} mr-2"></i> 
                                {{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        @if($voucher->voucherUsages->count() === 0)
                        <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded font-medium transition duration-200">
                                <i class="fas fa-trash mr-2"></i> Hapus Voucher
                            </button>
                        </form>
                        @else
                        <button type="button" class="w-full bg-red-300 text-red-800 px-4 py-2 rounded font-medium cursor-not-allowed" disabled title="Voucher sudah pernah digunakan">
                            <i class="fas fa-trash mr-2"></i> Voucher Sudah Digunakan
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($voucher->expires_at && $voucher->expires_at->lt(now()))
            <!-- Expired Warning -->
            <div class="bg-white rounded-lg shadow-md mb-6 border-l-4 border-red-500">
                <div class="px-6 py-4 bg-red-500 rounded-t-lg">
                    <h6 class="text-lg font-semibold text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Voucher Expired
                    </h6>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Voucher ini sudah kadaluarsa pada {{ $voucher->expires_at->format('d/m/Y H:i') }}. 
                    Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                </div>
            </div>
            @endif

            @if($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit)
            <!-- Usage Limit Reached Warning -->
            <div class="bg-white rounded-lg shadow-md mb-6 border-l-4 border-yellow-500">
                <div class="px-6 py-4 bg-yellow-500 rounded-t-lg">
                    <h6 class="text-lg font-semibold text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Kuota Habis
                    </h6>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Voucher ini sudah mencapai batas maksimal penggunaan ({{ $voucher->usage_limit }} kali). 
                    Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<script>
    // Show success message if redirected from edit/toggle action
    setTimeout(function() {
        alert('{{ session("success") }}');
    }, 100);
</script>
@endif
@endsection

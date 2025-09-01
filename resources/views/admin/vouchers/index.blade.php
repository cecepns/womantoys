@extends('admin.layouts.app')

@section('title', 'Manajemen Voucher')

@section('page-title', 'Manajemen Voucher')
@section('page-description', 'Kelola semua voucher dan diskon untuk pelanggan')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8 flex-col sm:flex-row gap-4 sm:gap-0">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Voucher</h1>
        <p class="text-gray-600 mt-2">Kelola semua voucher dan diskon untuk pelanggan</p>
    </div>
    <div class="flex items-center flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.vouchers.index') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari voucher..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent w-full"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <input type="hidden" name="type" value="{{ request('type', 'all') }}">
            <input type="hidden" name="period" value="{{ request('period', 'all') }}">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
                Cari
            </button>
        </form>
        
        <a href="{{ route('admin.vouchers.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Voucher
        </a>
    </div>
    </div>

    <!-- Statistics Cards -->
<div class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                        </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Voucher</p>
                <p class="text-2xl font-bold text-gray-800">{{ $statistics['total'] }}</p>
            </div>
        </div>
                        </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                        </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Voucher Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $statistics['active'] }}</p>
            </div>
        </div>
                        </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Voucher Expired</p>
                <p class="text-2xl font-bold text-gray-800">{{ $statistics['expired'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Diskon</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($statistics['total_discount'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                </div>
            </div>
            
            <!-- Advanced Filters -->
<div class="mb-6 bg-white rounded-lg shadow-md border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Voucher</h3>
    <form method="GET" action="{{ route('admin.vouchers.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
        </div>
                        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Voucher</label>
            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Jenis</option>
                            <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Persentase</option>
                            <option value="fixed_amount" {{ request('type') == 'fixed_amount' ? 'selected' : '' }}>Nominal</option>
                            <option value="free_shipping" {{ request('type') == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                        </select>
        </div>
                        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
            <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Semua Periode</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="expired" {{ request('period') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
        </div>
        
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                Filter
            </button>
            <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Success/Error Messages -->
            @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bulk Actions -->
<form id="bulk-form" method="POST" action="{{ route('admin.vouchers.bulk-action') }}" class="mb-6">
                @csrf
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="flex items-center">
                <input class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 rounded focus:ring-pink-500" type="checkbox" id="select-all">
                <label class="ml-2 text-sm font-medium text-gray-700" for="select-all">Pilih Semua</label>
                            </div>
                            
            <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" required>
                                <option value="">Pilih Aksi</option>
                                <option value="activate">Aktifkan</option>
                                <option value="deactivate">Nonaktifkan</option>
                                <option value="delete">Hapus</option>
                            </select>
                            
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200" onclick="return confirm('Apakah Anda yakin?')">
                                Terapkan
                            </button>
                        </div>
                    </div>
</form>

<!-- Vouchers Table -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" id="select-all-header" class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 rounded focus:ring-pink-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kode
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        Jenis
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                        Nilai
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                        Digunakan
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        Berakhir
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                            </tr>
                        </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($vouchers as $voucher)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="voucher_ids[]" value="{{ $voucher->id }}" class="voucher-checkbox w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 rounded focus:ring-pink-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $voucher->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $voucher->name }}</div>
                                    </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                {{ $voucher->type_label }}
                            </span>
                                    </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                            <div class="text-sm text-gray-900">{{ $voucher->formatted_value }}</div>
                                    </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-red-100 text-red-800',
                                    'expired' => 'bg-gray-100 text-gray-800',
                                ];
                                $statusClass = $statusClasses[$voucher->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                            {{ $voucher->status_label }}
                                        </span>
                                    </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                            <div class="text-sm text-gray-900">
                                        {{ $voucher->used_count }}
                                        @if($voucher->usage_limit)
                                            / {{ $voucher->usage_limit }}
                                        @endif
                            </div>
                                    </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <div class="text-sm text-gray-900">
                                        @if($voucher->expires_at)
                                            {{ $voucher->expires_at->format('d/m/Y H:i') }}
                                @else
                                    <em class="text-gray-500">Tidak terbatas</em>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.vouchers.show', $voucher) }}" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.vouchers.toggle-status', $voucher) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-{{ $voucher->is_active ? 'gray' : 'green' }}-600 hover:text-{{ $voucher->is_active ? 'gray' : 'green' }}-900" title="{{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($voucher->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                                </button>
                                            </form>
                                <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Tidak ada voucher ditemukan.</p>
                                @if(request('search') || request('status', 'all') !== 'all' || request('type', 'all') !== 'all' || request('period', 'all') !== 'all')
                                    <a href="{{ route('admin.vouchers.index') }}" class="mt-2 inline-flex items-center text-sm text-pink-600 hover:text-pink-500">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Hapus filter
                                    </a>
                                @endif
                            </div>
                        </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
</div>

            <!-- Pagination -->
@if($vouchers->hasPages())
<div class="mt-6 flex items-center justify-between flex-col sm:flex-row gap-4 sm:gap-0">
    <div class="text-sm text-gray-700 text-center sm:text-left">
        Menampilkan <span class="font-medium">{{ $vouchers->firstItem() }}</span> sampai <span class="font-medium">{{ $vouchers->lastItem() }}</span> dari <span class="font-medium">{{ $vouchers->total() }}</span> voucher
            </div>

    <div class="flex items-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($vouchers->onFirstPage())
            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                Sebelumnya
            </span>
        @else
            <a href="{{ $vouchers->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Sebelumnya
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($vouchers->getUrlRange(1, $vouchers->lastPage()) as $page => $url)
            @if ($page == $vouchers->currentPage())
                <span class="px-3 py-2 text-sm font-medium text-white bg-pink-600 border border-pink-600 rounded-lg">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($vouchers->hasMorePages())
            <a href="{{ $vouchers->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Berikutnya
            </a>
        @else
            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                Berikutnya
            </span>
        @endif
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkboxes functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const selectAllHeaderCheckbox = document.getElementById('select-all-header');
    const voucherCheckboxes = document.querySelectorAll('.voucher-checkbox');

    function toggleAllCheckboxes(isChecked) {
        voucherCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        selectAllCheckbox.checked = isChecked;
        selectAllHeaderCheckbox.checked = isChecked;
    }

    selectAllCheckbox.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
    });

    selectAllHeaderCheckbox.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
    });

    // Update select all checkbox based on individual checkboxes
    voucherCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.voucher-checkbox:checked').length;
            const allChecked = checkedCount === voucherCheckboxes.length;
            const someChecked = checkedCount > 0;

            selectAllCheckbox.checked = allChecked;
            selectAllHeaderCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            selectAllHeaderCheckbox.indeterminate = someChecked && !allChecked;
        });
    });

    // Auto-submit search form when Enter is pressed
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
});
</script>
@endpush
@endsection

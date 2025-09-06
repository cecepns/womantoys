@extends('admin.layouts.app')

@section('title', 'Manajemen Voucher')

@section('page-title', 'Manajemen Voucher')
@section('page-description', 'Kelola semua voucher dan diskon untuk pelanggan')

@section('content')
    <!-- SECTION: Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <!-- ANCHOR: Page Title -->
        <div class="flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manajemen Voucher</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola semua voucher dan diskon untuk pelanggan</p>
        </div>

        <!-- ANCHOR: Action Buttons -->
        <div class="flex items-center gap-4 w-full sm:w-auto">
            <a href="{{ route('admin.vouchers.create') }}"
                class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center w-full sm:w-auto text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Voucher
            </a>
        </div>
    </div>
    <!-- !SECTION: Header Section -->

    <!-- SECTION: Statistics Cards -->
    <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- ANCHOR: Total Voucher Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Voucher</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800">{{ $statistics['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Active Voucher Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Voucher Aktif</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800">{{ $statistics['active'] }}</p>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Expired Voucher Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Voucher Expired</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800">{{ $statistics['expired'] }}</p>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Total Discount Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Diskon</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800">
                        {{ \App\Helpers\SettingHelper::formatCurrency($statistics['total_discount']) }}</p>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Used Voucher Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Sudah Digunakan</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800">{{ $statistics['used'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- !SECTION: Statistics Cards -->

    <!-- SECTION: Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6 mb-8">
        <!-- ANCHOR: Filter Form -->
        <form method="GET" action="{{ route('admin.vouchers.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- ANCHOR: Search Field -->
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari voucher..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm sm:text-base">
            </div>

            <!-- ANCHOR: Status Filter -->
            <div class="w-full md:w-48">
                <select name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- ANCHOR: Type Filter -->
            <div class="w-full md:w-48">
                <select name="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">Semua Jenis</option>
                    <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Persentase</option>
                    <option value="fixed_amount" {{ request('type') == 'fixed_amount' ? 'selected' : '' }}>Nominal</option>
                    <option value="free_shipping" {{ request('type') == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir
                    </option>
                </select>
            </div>

            <!-- ANCHOR: Period Filter -->
            <div class="w-full md:w-48">
                <select name="period"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">Semua Periode</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="expired" {{ request('period') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <!-- ANCHOR: Usage Filter -->
            <div class="w-full md:w-48">
                <select name="usage"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">Semua Penggunaan</option>
                    <option value="used" {{ request('usage') == 'used' ? 'selected' : '' }}>Sudah Digunakan</option>
                    <option value="unused" {{ request('usage') == 'unused' ? 'selected' : '' }}>Belum Digunakan</option>
                </select>
            </div>

            <!-- ANCHOR: Filter Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-0">
                <button type="submit"
                    class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    Filter
                </button>
                @if (request('search') || request('status') || request('type') || request('period') || request('usage'))
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm sm:text-base">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    <!-- !SECTION: Search and Filter Section -->

    <!-- SECTION: Vouchers Table -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <!-- ANCHOR: Table Header -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kode
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Jenis
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Nilai
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Digunakan
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Berakhir
                        </th>
                        <th
                            class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <!-- ANCHOR: Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vouchers as $voucher)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <!-- ANCHOR: Voucher Code -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $voucher->code }}</div>
                            </td>

                            <!-- ANCHOR: Voucher Name -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $voucher->name }}</div>
                            </td>

                            <!-- ANCHOR: Voucher Type -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ $voucher->type_label }}
                                </span>
                            </td>

                            <!-- ANCHOR: Voucher Value -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm text-gray-900">{{ $voucher->formatted_value }}</div>
                            </td>

                            <!-- ANCHOR: Voucher Status -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                @php
                                    // Status classes untuk styling badge
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

                            <!-- ANCHOR: Usage Count -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm text-gray-900">
                                    {{ $voucher->getUsageCount() }}
                                    @if ($voucher->usage_limit)
                                        / {{ $voucher->usage_limit }}
                                    @endif
                                </div>
                            </td>

                            <!-- ANCHOR: Expiry Date -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-900">
                                    @if ($voucher->expires_at)
                                        {{ $voucher->expires_at->format('d/m/Y') }}
                                    @else
                                        <em class="text-gray-500">Tidak terbatas</em>
                                    @endif
                                </div>
                            </td>

                            <!-- SECTION: Action Buttons -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col sm:flex-row gap-2 sm:space-x-2">
                                    <!-- ANCHOR: Detail Button -->
                                    <a href="{{ route('admin.vouchers.show', $voucher) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors duration-200 text-center">
                                        Detail
                                    </a>

                                    <!-- ANCHOR: Edit Button -->
                                    <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors duration-200 text-center">
                                        Edit
                                    </a>

                                    <!-- ANCHOR: Delete Button -->
                                    @if ($voucher->hasBeenUsed())
                                        <!-- Voucher yang sudah digunakan tidak bisa dihapus -->
                                        <span
                                            class="bg-gray-400 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium cursor-not-allowed text-center"
                                            title="Tidak dapat dihapus karena sudah digunakan">
                                            Hapus
                                        </span>
                                    @else
                                        <!-- Form untuk menghapus voucher -->
                                        <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors duration-200 w-full sm:w-auto">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <!-- !SECTION: Action Buttons -->
                        </tr>
                    @empty
                        <!-- ANCHOR: Empty State -->
                        <tr>
                            <td colspan="8" class="px-4 sm:px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Tidak ada voucher ditemukan.</p>
                                    @if (request('search') || request('status') || request('type') || request('period') || request('usage'))
                                        <a href="{{ route('admin.vouchers.index') }}"
                                            class="mt-2 inline-flex items-center text-sm text-pink-600 hover:text-pink-500">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
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
    <!-- !SECTION: Vouchers Table -->

    <!-- SECTION: Pagination -->
    @if ($vouchers->hasPages())
        <div class="mt-6 flex items-center justify-between flex-col sm:flex-row gap-4 sm:gap-0">
            <!-- ANCHOR: Pagination Info -->
            <div class="text-sm text-gray-700 text-center sm:text-left">
                Menampilkan <span class="font-medium">{{ $vouchers->firstItem() }}</span> sampai <span
                    class="font-medium">{{ $vouchers->lastItem() }}</span> dari <span
                    class="font-medium">{{ $vouchers->total() }}</span> voucher
            </div>

            <!-- ANCHOR: Pagination Controls -->
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($vouchers->onFirstPage())
                    <span
                        class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $vouchers->previousPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Sebelumnya
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($vouchers->getUrlRange(1, $vouchers->lastPage()) as $page => $url)
                    @if ($page == $vouchers->currentPage())
                        <span
                            class="px-3 py-2 text-sm font-medium text-white bg-pink-600 border border-pink-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($vouchers->hasMorePages())
                    <a href="{{ $vouchers->nextPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Berikutnya
                    </a>
                @else
                    <span
                        class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                        Berikutnya
                    </span>
                @endif
            </div>
        </div>
    @endif
    <!-- !SECTION: Pagination -->

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ANCHOR: Auto-submit search form when Enter is pressed
                document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        this.closest('form').submit();
                    }
                });
            });
        </script>
    @endpush
@endsection

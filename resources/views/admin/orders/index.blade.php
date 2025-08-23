@extends('admin.layouts.app')

@section('title', 'Order Management - Admin Panel')

@section('page-title', 'Manajemen Pesanan')
@section('page-description', 'Kelola semua pesanan masuk dari pelanggan')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pesanan</h1>
        <p class="text-gray-600 mt-2">Kelola semua pesanan masuk dari pelanggan</p>
    </div>
    <div class="flex items-center space-x-4">
        <!-- Search Bar -->
        <div class="relative">
            <input
                type="text"
                placeholder="Cari pesanan..."
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
            >
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        
        <!-- Export Button -->
        <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">12</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Menunggu Konfirmasi</p>
                <p class="text-2xl font-bold text-gray-800">2</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Diproses</p>
                <p class="text-2xl font-bold text-gray-800">1</p>
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
                <p class="text-sm font-medium text-gray-600">Selesai</p>
                <p class="text-2xl font-bold text-gray-800">8</p>
            </div>
        </div>
    </div>
</div>

<!-- Status Filter Section -->
<div class="mb-6">
    <div class="flex flex-wrap gap-2">
        <button class="px-4 py-2 bg-pink-600 text-white rounded-lg font-medium transition-colors duration-200">
            Semua
        </button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">
            Menunggu Konfirmasi
        </button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">
            Diproses
        </button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">
            Selesai
        </button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors duration-200">
            Dibatalkan
        </button>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No. Pesanan
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Pelanggan
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Pesanan
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total Pembayaran
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Order 1 -->
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2025-0001</div>
                        <div class="text-sm text-gray-500">2 item</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-pink-600">S</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Sarah Johnson</div>
                                <div class="text-sm text-gray-500">sarah@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">23 Jan 2025</div>
                        <div class="text-sm text-gray-500">14:30 WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp 1.850.000</div>
                        <div class="text-sm text-gray-500">Transfer Bank</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                            Menunggu Konfirmasi
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/1" class="text-pink-600 hover:text-pink-900 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                </tr>

                <!-- Order 2 -->
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2025-0002</div>
                        <div class="text-sm text-gray-500">1 item</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-blue-600">M</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Michael Chen</div>
                                <div class="text-sm text-gray-500">michael@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">22 Jan 2025</div>
                        <div class="text-sm text-gray-500">09:15 WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp 750.000</div>
                        <div class="text-sm text-gray-500">Transfer Bank</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                            Diproses
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/2" class="text-pink-600 hover:text-pink-900 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                </tr>

                <!-- Order 3 -->
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2025-0003</div>
                        <div class="text-sm text-gray-500">3 item</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-green-600">L</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Lisa Rodriguez</div>
                                <div class="text-sm text-gray-500">lisa@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">21 Jan 2025</div>
                        <div class="text-sm text-gray-500">16:45 WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp 2.150.000</div>
                        <div class="text-sm text-gray-500">Transfer Bank</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Selesai
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/3" class="text-pink-600 hover:text-pink-900 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                </tr>

                <!-- Order 4 -->
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2025-0004</div>
                        <div class="text-sm text-gray-500">1 item</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-purple-600">D</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">David Kim</div>
                                <div class="text-sm text-gray-500">david@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">20 Jan 2025</div>
                        <div class="text-sm text-gray-500">11:20 WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp 950.000</div>
                        <div class="text-sm text-gray-500">Transfer Bank</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            Dibatalkan
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/4" class="text-pink-600 hover:text-pink-900 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                </tr>

                <!-- Order 5 -->
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2025-0005</div>
                        <div class="text-sm text-gray-500">2 item</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-orange-600">A</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Amanda Wilson</div>
                                <div class="text-sm text-gray-500">amanda@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">19 Jan 2025</div>
                        <div class="text-sm text-gray-500">13:10 WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp 1.200.000</div>
                        <div class="text-sm text-gray-500">Transfer Bank</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                            Menunggu Konfirmasi
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/orders/5" class="text-pink-600 hover:text-pink-900 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6 flex items-center justify-between">
    <div class="text-sm text-gray-700">
        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">12</span> pesanan
    </div>
    
    <div class="flex items-center space-x-2">
        <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Sebelumnya
        </button>
        
        <button class="px-3 py-2 text-sm font-medium text-white bg-pink-600 border border-pink-600 rounded-lg">
            1
        </button>
        
        <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            2
        </button>
        
        <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            3
        </button>
        
        <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            Berikutnya
        </button>
    </div>
</div>

<script>
// Status filter functionality
document.querySelectorAll('.mb-6 button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all buttons
        document.querySelectorAll('.mb-6 button').forEach(btn => {
            btn.classList.remove('bg-pink-600', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        // Add active state to clicked button
        this.classList.remove('bg-gray-200', 'text-gray-700');
        this.classList.add('bg-pink-600', 'text-white');
        
        // In real app, this would filter the table
        const status = this.textContent.trim();
        alert(`Filtering orders by status: ${status}`);
    });
});

// Search functionality
document.querySelector('input[placeholder="Cari pesanan..."]').addEventListener('input', function(e) {
    const searchTerm = e.target.value.trim();
    if (searchTerm.length > 2) {
        // In real app, this would search the table
        console.log('Searching for:', searchTerm);
    }
});

// Export functionality
document.querySelector('button:contains("Export")').addEventListener('click', function() {
    alert('Exporting orders data...');
});
</script>
@endsection

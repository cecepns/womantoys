@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')

@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your store performance')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-lg text-gray-600">Selamat Datang Kembali, Admin!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Orders Card -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800">1,234</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-green-600 font-medium">+12%</span>
            <span class="text-sm text-gray-600">dari bulan lalu</span>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Produk</p>
                <p class="text-3xl font-bold text-gray-800">89</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-green-600 font-medium">+5</span>
            <span class="text-sm text-gray-600">produk baru</span>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pendapatan</p>
                <p class="text-3xl font-bold text-gray-800">Rp 45.2M</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-green-600 font-medium">+8.2%</span>
            <span class="text-sm text-gray-600">dari bulan lalu</span>
        </div>
    </div>

    <!-- Pending Orders Card -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pesanan Pending</p>
                <p class="text-3xl font-bold text-gray-800">23</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-red-600 font-medium">-3</span>
            <span class="text-sm text-gray-600">dari kemarin</span>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">INV-2025-0001</p>
                        <p class="text-sm text-gray-600">Lelo Sona Cruise 2</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-800">Rp 1.520.000</p>
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">INV-2025-0002</p>
                        <p class="text-sm text-gray-600">Premium Vibrator Deluxe</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-800">Rp 850.000</p>
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Paid</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">INV-2025-0003</p>
                        <p class="text-sm text-gray-600">Couples Massager Set</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-800">Rp 2.100.000</p>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Processing</span>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="/admin/orders" class="text-pink-600 hover:text-pink-700 font-medium">Lihat Semua Pesanan →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <a href="/admin/products" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Tambah Produk Baru</p>
                        <p class="text-sm text-gray-600">Tambah produk baru ke katalog</p>
                    </div>
                </a>
                <a href="/admin/carousel" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Kelola Carousel</p>
                        <p class="text-sm text-gray-600">Update gambar carousel homepage</p>
                    </div>
                </a>
                <a href="/admin/orders" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Kelola Pesanan</p>
                        <p class="text-sm text-gray-600">Lihat dan update status pesanan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

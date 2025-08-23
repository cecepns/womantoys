@extends('admin.layouts.app')

@section('title', 'Product Management - Admin Panel')

@section('page-title', 'Manajemen Produk')
@section('page-description', 'Kelola semua produk di toko Anda')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Produk</h1>
        <p class="text-gray-600 mt-2">Kelola semua produk yang tersedia di toko</p>
    </div>
    <a href="/admin/products/create" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Produk Baru
    </a>
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-8">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input 
                type="text" 
                placeholder="Cari produk..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
            >
        </div>
        <div class="md:w-48">
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <option value="">Semua Kategori</option>
                <option value="women">Untuk Wanita</option>
                <option value="men">Untuk Pria</option>
                <option value="couples">Untuk Pasangan</option>
                <option value="bdsm">BDSM</option>
            </select>
        </div>
        <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
            Filter
        </button>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gambar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Harga
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Product Row 1 -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img 
                            src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                            alt="Lelo Sona Cruise 2" 
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Lelo Sona Cruise 2</div>
                            <div class="text-sm text-gray-500">Premium sonic wave massager</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-pink-100 text-pink-800 rounded-full">
                            Untuk Wanita
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Rp 1.500.000
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="/admin/products/1/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Edit
                        </a>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Hapus
                        </button>
                    </td>
                </tr>

                <!-- Product Row 2 -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img 
                            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                            alt="Premium Vibrator Deluxe" 
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Premium Vibrator Deluxe</div>
                            <div class="text-sm text-gray-500">High-quality vibrator with multiple settings</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-pink-100 text-pink-800 rounded-full">
                            Untuk Wanita
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Rp 850.000
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="/admin/products/2/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Edit
                        </a>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Hapus
                        </button>
                    </td>
                </tr>

                <!-- Product Row 3 -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img 
                            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                            alt="Couples Massager Set" 
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Couples Massager Set</div>
                            <div class="text-sm text-gray-500">Complete set for intimate couples play</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                            Untuk Pasangan
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Rp 2.100.000
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                            Draft
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="/admin/products/3/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Edit
                        </a>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Hapus
                        </button>
                    </td>
                </tr>

                <!-- Product Row 4 -->
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img 
                            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                            alt="Executive Power Ring" 
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Executive Power Ring</div>
                            <div class="text-sm text-gray-500">Premium ring with enhanced features</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                            Untuk Pria
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Rp 650.000
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            Stok Habis
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="/admin/products/4/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Edit
                        </a>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors duration-200">
                            Hapus
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-8 flex items-center justify-between">
    <div class="text-sm text-gray-700">
        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">4</span> dari <span class="font-medium">4</span> produk
    </div>
    <div class="flex items-center space-x-2">
        <button class="px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" disabled>
            « Previous
        </button>
        <button class="px-3 py-2 text-white bg-pink-600 border border-pink-600 rounded-lg font-medium">
            1
        </button>
        <button class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" disabled>
            Next »
        </button>
    </div>
</div>
@endsection

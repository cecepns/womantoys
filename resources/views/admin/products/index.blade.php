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
    <a href="{{ route('admin.products.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
        Tambah Produk Baru
    </a>
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-8">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
            >
        </div>
        <div class="md:w-48">
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:w-48">
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
            Filter
        </button>
        @if(request('search') || request('category') || request('status'))
            <a href="{{ route('admin.products.index') }}" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                Reset
            </a>
        @endif
    </form>
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
                        Sisa Stok
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-16 rounded-lg overflow-hidden relative">
                            @if($product->hasValidMainImage())
                                <img 
                                    src="{{ $product->main_image_url }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <!-- Fallback placeholder when image fails to load -->
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center hidden">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="absolute top-1 right-1">
                                        <span class="bg-red-100 text-red-800 text-xs px-1 py-0.5 rounded-full">
                                            Error
                                        </span>
                                    </div>
                                </div>
                            @else
                                <!-- No image placeholder -->
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="absolute top-1 right-1">
                                        <span class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                                            No Image
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->short_description }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium 
                            @if($product->category->name == 'Untuk Wanita') bg-pink-100 text-pink-800
                            @elseif($product->category->name == 'Untuk Pria') bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800
                            @endif rounded-full">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $product->formatted_price }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium {{ $product->status_badge_class }} rounded-full">
                            {{ $product->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $product->stock }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada produk yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="mt-8">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif

<script>
// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    const productImages = document.querySelectorAll('img[src*="storage"]');
    
    productImages.forEach(function(img) {
        img.addEventListener('error', function() {
            // Hide the failed image
            this.style.display = 'none';
            
            // Show the fallback placeholder
            const fallback = this.nextElementSibling;
            if (fallback && fallback.classList.contains('hidden')) {
                fallback.classList.remove('hidden');
                fallback.style.display = 'flex';
            }
        });
    });
});
</script>
@endsection

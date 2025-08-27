@extends('layouts.app')

@section('title', 'Katalog - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Header Katalog -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Koleksi Kami</h1>
        
        <!-- Search Results Info -->
        @if(request('search'))
            <div class="mb-6 p-4 bg-pink-50 border border-pink-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-pink-800">Hasil Pencarian</h2>
                        <p class="text-pink-700">
                            Menampilkan {{ $products->total() }} hasil untuk "<strong>{{ request('search') }}</strong>"
                        </p>
                    </div>
                    <a href="{{ route('catalog') }}" class="text-pink-600 hover:text-pink-800 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Control Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <!-- Filter Kategori -->
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('catalog') }}{{ request('search') ? '?search=' . request('search') : '' }}" class="px-4 py-2 {{ request('category') === null || request('category') === 'all' ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg font-medium hover:bg-pink-700 hover:text-white transition-colors duration-200">Semua</a>
                @foreach($categories as $category)
                    <a href="{{ route('catalog', array_merge(request()->query(), ['category' => $category->slug])) }}" class="px-4 py-2 {{ request('category') === $category->slug ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg font-medium hover:bg-pink-700 hover:text-white transition-colors duration-200">
                        {{ $category->name }}
                        <span class="ml-1 text-xs">({{ $category->products_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Grid Produk -->
    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12" style="grid-auto-rows: 1fr;">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-lg mb-4">
                @if(request('search'))
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                @else
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                @endif
            </div>
            @if(request('search'))
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-500 mb-4">Tidak ada produk yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>"</p>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Coba:</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Periksa ejaan kata kunci</li>
                        <li>• Gunakan kata kunci yang lebih umum</li>
                        <li>• Coba kata kunci yang berbeda</li>
                    </ul>
                    <a href="{{ route('catalog') }}" class="inline-block mt-4 px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors duration-200">
                        Lihat Semua Produk
                    </a>
                </div>
            @else
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-500">Coba sesuaikan pencarian atau kriteria filter Anda.</p>
            @endif
        </div>
    @endif
    
    <!-- Paginasi -->
    @if($products->hasPages())
        {{ $products->links() }}
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Katalog - ' . ($storeName ?? 'WomanToys'))

@section('content')
    <div class="container mx-auto px-4 py-6 md:py-10">
        <!-- Header Katalog -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4 text-gray-800">Koleksi Kami</h1>

            <!-- Breadcrumb -->
            @if ((request('main') && request('main') !== 'all') || (request('category') && request('category') !== 'all'))
                @php
                    $currentMainCategory = null;
                    $currentCategory = null;

                    if (request('main') && request('main') !== 'all') {
                        $currentMainCategory = $mainCategories->where('slug', request('main'))->first();
                    }

                    if (request('category') && request('category') !== 'all') {
                        $currentCategory = $categories->where('slug', request('category'))->first();
                        // Jika ada category tapi tidak ada main, ambil main category dari category tersebut
                        if (!$currentMainCategory && $currentCategory && $currentCategory->mainCategory) {
                            $currentMainCategory = $currentCategory->mainCategory;
                        }
                    }
                @endphp

                @if ($currentMainCategory || $currentCategory)
                    <nav class="flex items-center space-x-2 text-sm md:text-base text-gray-600 mb-4">
                        <a href="{{ route('catalog') }}" class="hover:text-pink-600 transition-colors duration-200">
                            Semua
                        </a>
                        <span class="text-gray-400">></span>

                        @if ($currentCategory)
                            <!-- Jika ada sub kategori, kategori utama bisa diklik -->
                            <a href="{{ route('catalog', ['main' => $currentMainCategory->slug]) }}"
                                class="hover:text-pink-600 transition-colors duration-200">
                                {{ $currentMainCategory->name }}
                            </a>
                            <span class="text-gray-400">></span>
                            <!-- Sub kategori adalah item terakhir, tidak bisa diklik -->
                            <span class="text-gray-800 font-medium">{{ $currentCategory->name }}</span>
                        @else
                            <!-- Jika hanya ada kategori utama, tidak bisa diklik karena item terakhir -->
                            <span class="text-gray-800 font-medium">{{ $currentMainCategory->name }}</span>
                        @endif
                    </nav>
                @endif
            @endif

            <!-- Search Results Info -->
            @if (request('search'))
                <div class="mb-4 md:mb-6 p-3 md:p-4 bg-pink-50 border border-pink-200 rounded-lg">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex-1">
                            <h2 class="text-base md:text-lg font-semibold text-pink-800">Hasil Pencarian</h2>
                            <p class="text-sm md:text-base text-pink-700">
                                Menampilkan {{ $products->total() }} hasil untuk "<strong>{{ request('search') }}</strong>"
                            </p>
                        </div>
                        <a href="{{ route('catalog') }}"
                            class="text-pink-600 hover:text-pink-800 font-medium self-start sm:self-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sorting Options -->
        <div class="mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row justify-end gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm md:text-base text-gray-600">Urutkan berdasarkan:</span>
                </div>
                <div class="flex items-center w-full sm:w-auto gap-2">
                    <select id="sortSelect"
                        class="px-3 py-2 border border-gray-300  w-full sm:w-auto rounded-lg text-sm md:text-base focus:ring-2 focus:ring-pink-500 focus:border-pink-500 bg-white">
                        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>
                            Terbaru</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grid Produk -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-8 md:mb-12"
                style="grid-auto-rows: 1fr;">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-8 md:py-12 px-4">
                <div class="text-gray-500 text-lg mb-4">
                    @if (request('search'))
                        <svg class="mx-auto h-10 w-10 md:h-12 md:w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    @else
                        <svg class="mx-auto h-10 w-10 md:h-12 md:w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    @endif
                </div>
                @if (request('search'))
                    <h3 class="text-base md:text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-sm md:text-base text-gray-500 mb-4 px-4">Tidak ada produk yang cocok dengan pencarian
                        "<strong>{{ request('search') }}</strong>"</p>
                    <div class="space-y-2 max-w-md mx-auto">
                        <p class="text-xs md:text-sm text-gray-600">Coba:</p>
                        <ul class="text-xs md:text-sm text-gray-600 space-y-1 text-left">
                            <li>• Periksa ejaan kata kunci</li>
                            <li>• Gunakan kata kunci yang lebih umum</li>
                            <li>• Coba kata kunci yang berbeda</li>
                        </ul>
                        <a href="{{ route('catalog') }}"
                            class="inline-block mt-4 px-4 md:px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors duration-200 text-sm md:text-base">
                            Lihat Semua Produk
                        </a>
                    </div>
                @else
                    <h3 class="text-base md:text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-sm md:text-base text-gray-500 px-4">Coba sesuaikan pencarian atau kriteria filter Anda.
                    </p>
                @endif
            </div>
        @endif

        <!-- Paginasi -->
        @if ($products->hasPages())
            {{ $products->links() }}
        @endif
    </div>

    <script>
        document.getElementById('sortSelect').addEventListener('change', function() {
            const sortValue = this.value;
            const url = new URL(window.location);

            if (sortValue === 'newest') {
                url.searchParams.delete('sort');
            } else {
                url.searchParams.set('sort', sortValue);
            }

            window.location.href = url.toString();
        });
    </script>
@endsection

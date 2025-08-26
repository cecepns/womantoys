@extends('layouts.app')

@section('title', $product->name . ' - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="/" class="hover:text-pink-600 transition-colors duration-200">Beranda</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('catalog') }}" class="hover:text-pink-600 transition-colors duration-200">Koleksi</a></li>
            @if($product->category)
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-pink-600 transition-colors duration-200">{{ $product->category->name }}</a></li>
            @endif
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800 font-medium">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Main Product Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Left Column - Image Gallery -->
        <div>
            <!-- Main Image -->
            <div class="mb-6">
                @if($product->main_image_url)
                    <img 
                        src="{{ $product->main_image_url }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-96 lg:h-[500px] object-cover rounded-lg shadow-lg"
                        id="main-product-image"
                    >
                @else
                    <div class="w-full h-96 lg:h-[500px] bg-gray-200 flex items-center justify-center rounded-lg shadow-lg">
                        <div class="text-center">
                            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Tidak Ada Gambar</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Thumbnail Gallery -->
            @if($product->images->count() > 0)
                <div class="flex space-x-4">
                    @foreach($product->images as $image)
                        <img 
                            src="{{ asset('storage/' . $image->image_path) }}" 
                            alt="{{ $product->name }} - Gambar {{ $loop->iteration }}" 
                            class="w-20 h-20 object-cover rounded-lg border-2 border-gray-300 cursor-pointer hover:border-pink-600 transition-colors duration-200 thumbnail-image"
                            data-image="{{ asset('storage/' . $image->image_path) }}"
                        >
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column - Product Information -->
        <div>
            <!-- Product Name -->
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                {{ $product->name }}
            </h1>
            
            <!-- Product Price -->
            <p class="text-3xl font-bold text-pink-600 mb-6">
                {{ $product->formatted_price }}
            </p>
            
            <!-- Product Description -->
            <div class="mb-8">
                <p class="text-gray-600 text-lg leading-relaxed">
                    {{ $product->short_description }}
                </p>
            </div>
            
            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->stock > 0)
                    <p class="text-green-600 font-medium">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Tersedia ({{ $product->stock }} stok)
                    </p>
                @else
                    <p class="text-red-600 font-medium">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Habis Stok
                    </p>
                @endif
            </div>
            
            <!-- Buy Now Button -->
            @if($product->stock > 0)
                <a href="{{ route('checkout') }}?product={{ $product->id }}" class="block">
                    <button class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                        Beli Sekarang
                    </button>
                </a>
            @else
                <button class="w-full bg-gray-400 text-white font-bold py-4 px-8 rounded-lg text-xl cursor-not-allowed" disabled>
                    Habis Stok
                </button>
            @endif
        </div>
    </div>

    <!-- Detailed Information Tabs -->
    <div class="pt-8">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 mb-8">
            <button class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200" data-tab="description" id="tab-description">
                Deskripsi Lengkap
            </button>
            <button class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200" data-tab="specifications" id="tab-specifications">
                Spesifikasi
            </button>
            <button class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium rounded-t-lg transition-all duration-200" data-tab="care" id="tab-care">
                Petunjuk Perawatan
            </button>
        </div>

        <!-- Tab Content -->
        <div class="space-y-6">
            <!-- Complete Description Tab (Active) -->
            <div data-tab-content="description">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Lengkap</h3>
                <div class="prose prose-lg text-gray-600 space-y-4">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            
            <!-- Specifications Tab -->
            <div class="hidden" data-tab-content="specifications">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Spesifikasi</h3>
                <div class="prose prose-lg text-gray-600 space-y-4">
                    {!! nl2br(e($product->specifications)) !!}
                </div>
            </div>
            
            <!-- Care Instructions Tab -->
            <div class="hidden" data-tab-content="care">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Petunjuk Perawatan</h3>
                <div class="prose prose-lg text-gray-600 space-y-4">
                    {!! nl2br(e($product->care_instructions)) !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="border-t border-gray-200 pt-12 mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('[data-tab]');
    const tabContents = document.querySelectorAll('[data-tab-content]');
    
    function switchTab(targetTab) {
        // Remove active class from all buttons
        tabButtons.forEach(btn => {
            btn.classList.remove('text-pink-600', 'border-pink-600', 'bg-pink-50');
            btn.classList.add('text-gray-500');
        });
        
        // Hide all tab contents
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Add active class to target button
        const activeButton = document.querySelector(`[data-tab="${targetTab}"]`);
        if (activeButton) {
            activeButton.classList.remove('text-gray-500');
            activeButton.classList.add('text-pink-600', 'border-pink-600', 'bg-pink-50');
        }
        
        // Show target content
        const targetContent = document.querySelector(`[data-tab-content="${targetTab}"]`);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }
    }

    switchTab('description');
    
    // Add click event listeners to all tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetTab = this.getAttribute('data-tab');
            switchTab(targetTab);
        });
    });
    
    // Thumbnail gallery functionality
    const thumbnailImages = document.querySelectorAll('.thumbnail-image');
    const mainImage = document.getElementById('main-product-image');
    
    thumbnailImages.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            
            // Update main image
            if (mainImage) {
                mainImage.src = imageSrc;
            }
            
            // Update thumbnail borders
            thumbnailImages.forEach(img => {
                img.classList.remove('border-pink-600');
                img.classList.add('border-gray-300');
            });
            
            this.classList.remove('border-gray-300');
            this.classList.add('border-pink-600');
        });
    });
});
</script>
@endsection

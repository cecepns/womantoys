@extends('admin.layouts.app')

@section('title', 'Manajemen Carousel - Panel Admin')

@section('page-title', 'Manajemen Carousel')
@section('page-description', 'Kelola slide carousel untuk homepage')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Carousel</h1>
        <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Kelola slide carousel yang ditampilkan di homepage</p>
    </div>
    <a href="{{ route('admin.carousel.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start text-sm md:text-base w-full sm:w-auto">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Slide Baru
    </a>
</div>

<!-- Carousel Slides List -->
@if($slides->count() > 0)
    <div class="space-y-4 md:space-y-6">
        @foreach($slides as $slide)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
                <!-- Mobile Layout -->
                <div class="block lg:hidden">
                    <!-- Thumbnail Image -->
                    <div class="w-full h-32 md:h-40 rounded-lg overflow-hidden mb-4">
                        @if($slide->hasValidImage())
                            <img 
                                src="{{ $slide->image_url }}" 
                                alt="Carousel Slide {{ $slide->id }}" 
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='{{ asset('images/default-carousel.jpg') }}'; this.classList.add('opacity-50');"
                            >
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center relative">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                @if($slide->image_path)
                                    <div class="absolute top-2 right-2">
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                            Rusak
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Slide Information -->
                    <div class="mb-4">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2">
                            {{ $slide->title ?: 'Tanpa Judul' }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ $slide->description ? $slide->getTruncatedDescription(100) : 'Tanpa deskripsi' }}
                        </p>
                        <div class="space-y-2 text-xs md:text-sm text-gray-500">
                            @if($slide->hasCta())
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    <span class="truncate">CTA: {{ $slide->cta_text }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Updated: {{ $slide->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Mobile -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <!-- Order Controls -->
                        <div class="flex justify-center sm:justify-start">
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('admin.carousel.move-up', $slide) }}" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 {{ $slide->isFirst() ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                        title="Move Up"
                                        {{ $slide->isFirst() ? 'disabled' : '' }}
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.carousel.move-down', $slide) }}" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 {{ $slide->isLast() ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                        title="Move Down"
                                        {{ $slide->isLast() ? 'disabled' : '' }}
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Edit and Delete Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.carousel.edit', $slide) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 text-center">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.carousel.destroy', $slide) }}" class="flex-1 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Desktop Layout -->
                <div class="hidden lg:flex items-center justify-between">
                    <!-- Slide Content -->
                    <div class="flex items-center space-x-6 flex-1">
                        <!-- Thumbnail Image -->
                        <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                            @if($slide->hasValidImage())
                                <img 
                                    src="{{ $slide->image_url }}" 
                                    alt="Carousel Slide {{ $slide->id }}" 
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='{{ asset('images/default-carousel.jpg') }}'; this.classList.add('opacity-50');"
                                >
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center relative">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    @if($slide->image_path)
                                        <div class="absolute top-1 right-1">
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                Rusak
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Slide Information -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                {{ $slide->title ?: 'Tanpa Judul' }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ $slide->description ? $slide->getTruncatedDescription(80) : 'Tanpa deskripsi' }}
                            </p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                @if($slide->hasCta())
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        CTA: {{ $slide->cta_text }}
                                    </span>
                                @endif
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Updated: {{ $slide->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3 ml-6">
                        <!-- Order Controls -->
                        <div class="flex flex-col space-y-1">
                            <form method="POST" action="{{ route('admin.carousel.move-up', $slide) }}" class="inline">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200 {{ $slide->isFirst() ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                    title="Move Up"
                                    {{ $slide->isFirst() ? 'disabled' : '' }}
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.carousel.move-down', $slide) }}" class="inline">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200 {{ $slide->isLast() ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                    title="Move Down"
                                    {{ $slide->isLast() ? 'disabled' : '' }}
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Edit Button -->
                        <a href="{{ route('admin.carousel.edit', $slide) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.carousel.destroy', $slide) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8 md:p-12 text-center">
        <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-base md:text-lg font-medium text-gray-900 mb-2">Belum ada slide carousel</h3>
        <p class="text-sm md:text-base text-gray-500 mb-4 md:mb-6">Mulai dengan menambahkan slide pertama untuk homepage Anda</p>
        <a href="{{ route('admin.carousel.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm md:text-base">
            Tambah Slide Pertama
        </a>
    </div>
@endif

<script>
// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[src*="carousel"]');
    
    images.forEach(function(img) {
        img.addEventListener('error', function() {
            // Add error styling
            this.classList.add('opacity-50');
            this.style.border = '2px solid #ef4444';
            
            // Show error indicator
            const container = this.closest('.w-32');
            if (container) {
                const errorBadge = document.createElement('div');
                errorBadge.className = 'absolute top-1 right-1 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full';
                errorBadge.textContent = 'Error';
                container.style.position = 'relative';
                container.appendChild(errorBadge);
            }
        });
    });
});
</script>
@endsection

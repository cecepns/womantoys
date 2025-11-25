@extends('admin.layouts.app')

@section('title', 'Manajemen Promotion - Panel Admin')

@section('page-title', 'Manajemen Promotion')
@section('page-description', 'Kelola promotion banner/video untuk homepage')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Promotion</h1>
        <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Kelola promotion banner/video yang ditampilkan di homepage</p>
    </div>
    <a href="{{ route('admin.promotions.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start text-sm md:text-base w-full sm:w-auto">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Promotion Baru
    </a>
</div>

<!-- Promotions List -->
@if($promotions->count() > 0)
    <div class="space-y-4 md:space-y-6">
        @foreach($promotions as $promotion)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
                <!-- Mobile Layout -->
                <div class="block lg:hidden">
                    <!-- Thumbnail File -->
                    <div class="w-full h-32 md:h-40 rounded-lg overflow-hidden mb-4">
                        @if($promotion->hasValidFile())
                            @if($promotion->isVideo())
                                <video src="{{ $promotion->file_url }}" class="w-full h-full object-cover" muted loop></video>
                            @else
                                <img 
                                    src="{{ $promotion->file_url }}" 
                                    alt="Promotion {{ $promotion->id }}" 
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.classList.add('opacity-50');"
                                >
                            @endif
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center relative">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                @if($promotion->file_path)
                                    <div class="absolute top-2 right-2">
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                            Rusak
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Promotion Information -->
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs px-2 py-1 rounded-full {{ $promotion->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $promotion->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                {{ $promotion->isVideo() ? 'Video' : 'Gambar' }}
                            </span>
                        </div>
                        <div class="space-y-2 text-xs md:text-sm text-gray-500">
                            @if($promotion->cta_link)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    <span class="truncate">CTA: {{ $promotion->cta_link }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Updated: {{ $promotion->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Mobile -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <!-- Edit and Delete Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 text-center">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="flex-1 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promotion ini? Tindakan ini tidak dapat dibatalkan.')">
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
                    <!-- Promotion Content -->
                    <div class="flex items-center space-x-6 flex-1">
                        <!-- Thumbnail File -->
                        <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                            @if($promotion->hasValidFile())
                                @if($promotion->isVideo())
                                    <video src="{{ $promotion->file_url }}" class="w-full h-full object-cover" muted loop></video>
                                @else
                                    <img 
                                        src="{{ $promotion->file_url }}" 
                                        alt="Promotion {{ $promotion->id }}" 
                                        class="w-full h-full object-cover"
                                        onerror="this.onerror=null; this.classList.add('opacity-50');"
                                    >
                                @endif
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center relative">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    @if($promotion->file_path)
                                        <div class="absolute top-1 right-1">
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                Rusak
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Promotion Information -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs px-2 py-1 rounded-full {{ $promotion->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $promotion->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                    {{ $promotion->isVideo() ? 'Video' : 'Gambar' }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                @if($promotion->cta_link)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        CTA: {{ Str::limit($promotion->cta_link, 40) }}
                                    </span>
                                @endif
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Updated: {{ $promotion->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3 ml-6">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.promotions.edit', $promotion) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promotion ini? Tindakan ini tidak dapat dibatalkan.')">
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
        <h3 class="text-base md:text-lg font-medium text-gray-900 mb-2">Belum ada promotion</h3>
        <p class="text-sm md:text-base text-gray-500 mb-4 md:mb-6">Mulai dengan menambahkan promotion pertama untuk homepage Anda</p>
        <a href="{{ route('admin.promotions.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm md:text-base">
            Tambah Promotion Pertama
        </a>
    </div>
@endif
@endsection


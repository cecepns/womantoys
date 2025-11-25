@extends('admin.layouts.app')

@section('title', 'Edit Promotion - Admin Panel')

@section('page-title', 'Edit Promotion')
@section('page-description', 'Edit promotion yang sudah ada')

@section('content')
<!-- Header Section -->
<div class="mb-4 md:mb-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 md:p-4">
        <div class="flex items-start md:items-center">
            <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5 md:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="min-w-0 flex-1">
                <h3 class="text-xs md:text-sm font-medium text-blue-800">Informasi Promotion</h3>
                <p class="text-xs md:text-sm text-blue-600 break-words">
                    ID: {{ $promotion->id }} | 
                    Dibuat: {{ $promotion->created_at ? $promotion->created_at->format('d M Y H:i') : 'N/A' }} | 
                    Terakhir Update: {{ $promotion->updated_at ? $promotion->updated_at->format('d M Y H:i') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Header Section -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Promotion</h1>
            <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Edit promotion yang sudah ada</p>
        </div>
        <a href="{{ route('admin.promotions.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start text-sm md:text-base w-full sm:w-auto">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Promotion Form -->
<form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
    @csrf
    @method('PUT')
    
    <!-- File Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">File Promotion</h2>
        
        <div class="space-y-4">
            <!-- Current File Preview -->
            @if($promotion->file_path)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">File Saat Ini:</p>
                    <div class="w-full max-w-sm md:max-w-md">
                        @if($promotion->hasValidFile())
                            @if($promotion->isVideo())
                                <video src="{{ $promotion->file_url }}" class="w-full h-32 md:h-48 object-cover rounded-lg border border-gray-300" controls></video>
                            @else
                                <img src="{{ $promotion->file_url }}" alt="Current File" class="w-full h-32 md:h-48 object-cover rounded-lg border border-gray-300">
                            @endif
                        @else
                            <div class="w-full h-32 md:h-48 bg-gray-200 rounded-lg border-2 border-red-300 flex items-center justify-center relative">
                                <div class="text-center p-2">
                                    <svg class="w-8 h-8 md:w-12 md:h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-xs md:text-sm text-gray-600">File tidak ditemukan</p>
                                    <p class="text-xs text-gray-500 break-all">Path: {{ $promotion->file_path }}</p>
                                </div>
                                <div class="absolute top-2 right-2">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                        Rusak
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- File Preview Area -->
            <div id="file_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview File Baru:</p>
                <div class="relative w-full max-w-sm md:max-w-md">
                    <img id="image_preview" src="" alt="Preview" class="w-full h-32 md:h-48 object-cover rounded-lg border border-gray-300 hidden">
                    <video id="video_preview" src="" class="w-full h-32 md:h-48 object-cover rounded-lg border border-gray-300 hidden" controls></video>
                    <!-- Remove Preview Button -->
                    <button type="button" id="remove_preview_btn" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-1.5 md:p-1 rounded-full transition-colors duration-200">
                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- File Input -->
            <div>
                <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Upload File Baru (Opsional)
                </label>
                <input
                    type="file"
                    id="file_path"
                    name="file_path"
                    accept=".png,.jpg,.jpeg,.mp4"
                    class="w-full px-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('file_path') border-red-500 @enderror text-sm md:text-base"
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">PNG, JPG, JPEG (max 5MB) atau MP4 (max 50MB)</p>
            </div>
            @error('file_path')
                <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- CTA Link Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">Call-to-Action Link</h2>
        
        <div>
            <label for="cta_link" class="block text-sm font-medium text-gray-700 mb-2">
                Link CTA
            </label>
            <input
                type="text"
                id="cta_link"
                name="cta_link"
                value="{{ old('cta_link', $promotion->cta_link) }}"
                class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_link') border-red-500 @enderror text-sm md:text-base"
                placeholder="Contoh: /catalog atau https://example.com"
            >
            <p class="text-xs md:text-sm text-gray-500 mt-1">URL tujuan ketika promotion diklik (opsional)</p>
            @error('cta_link')
                <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Status Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">Status</h2>
        
        <div>
            <label class="flex items-center">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                >
                <span class="ml-2 text-sm text-gray-700">Aktifkan promotion ini</span>
            </label>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Promotion yang tidak aktif tidak akan ditampilkan di homepage</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
        <a href="{{ route('admin.promotions.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 md:py-3 px-4 md:px-6 rounded-lg transition-colors duration-200 text-center text-sm md:text-base w-full sm:w-auto">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 md:py-3 px-6 md:px-8 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base w-full sm:w-auto"
        >
            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Update Promotion
        </button>
    </div>
</form>

<script>
// File preview functionality
document.getElementById('file_path').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const previewContainer = document.getElementById('file_preview_container');
        const imagePreview = document.getElementById('image_preview');
        const videoPreview = document.getElementById('video_preview');
        
        previewContainer.classList.remove('hidden');
        
        if (file.type.startsWith('video/')) {
            // Video preview
            imagePreview.classList.add('hidden');
            videoPreview.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = function(e) {
                videoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            // Image preview
            videoPreview.classList.add('hidden');
            imagePreview.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
});

// Remove preview functionality
document.getElementById('remove_preview_btn').addEventListener('click', function() {
    document.getElementById('file_preview_container').classList.add('hidden');
    document.getElementById('file_path').value = '';
    document.getElementById('image_preview').src = '';
    document.getElementById('video_preview').src = '';
});
</script>
@endsection


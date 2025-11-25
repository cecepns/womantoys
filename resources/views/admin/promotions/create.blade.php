@extends('admin.layouts.app')

@section('title', 'Add Promotion - Admin Panel')

@section('page-title', 'Tambah Promotion Baru')
@section('page-description', 'Buat promotion banner/video baru untuk homepage')

@section('content')
<!-- Header Section -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Promotion Baru</h1>
            <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Buat promotion banner/video baru untuk ditampilkan di homepage</p>
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
<form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
    @csrf
    <!-- File Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4">File Promotion</h2>
        
        <div class="space-y-4">
            <!-- File Preview Area -->
            <div id="file_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview File:</p>
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
                    Pilih File (Gambar/Video) <span class="text-red-500">*</span>
                </label>
                <input
                    type="file"
                    id="file_path"
                    name="file_path"
                    accept=".png,.jpg,.jpeg,.mp4"
                    class="w-full px-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('file_path') border-red-500 @enderror text-sm md:text-base"
                    required
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">PNG, JPG, JPEG (max 5MB) atau MP4 (max 50MB)</p>
                @error('file_path')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
                @enderror
            </div>
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
                value="{{ old('cta_link') }}"
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
                    {{ old('is_active', true) ? 'checked' : '' }}
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
            Simpan Promotion
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


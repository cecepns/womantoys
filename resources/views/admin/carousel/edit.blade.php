@extends('admin.layouts.app')

@section('title', 'Edit Carousel Slide - Admin Panel')

@section('page-title', 'Edit Slide')
@section('page-description', 'Edit slide carousel yang sudah ada')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Slide</h1>
            <p class="text-gray-600 mt-2">Edit slide carousel yang sudah ada</p>
        </div>
        <a href="{{ route('admin.carousel.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Carousel Slide Form -->
<form action="{{ route('admin.carousel.update', $carouselSlide) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    
    <!-- Image Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Gambar Slide</h2>
        
        <div class="space-y-4">
            <!-- Current Image Preview -->
            @if($carouselSlide->image_path)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                    <div class="w-full max-w-md relative">
                        @if($carouselSlide->hasValidImage())
                            <img src="{{ $carouselSlide->image_url }}" alt="Current Image" class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg border-2 border-red-300 flex items-center justify-center relative">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600">Gambar tidak ditemukan</p>
                                    <p class="text-xs text-gray-500">Path: {{ $carouselSlide->image_path }}</p>
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

            <!-- Image Preview Area -->
            <div id="image_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview Gambar Baru:</p>
                <div class="w-full max-w-md">
                    <img id="image_preview" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                </div>
            </div>

            <!-- File Upload Area -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-pink-400 transition-colors duration-200">
                <div id="upload_area">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-gray-600 mb-2">Klik untuk upload gambar baru (opsional)</p>
                    <p class="text-sm text-gray-500 mb-4">PNG, JPG, JPEG up to 5MB</p>
                    <p class="text-xs text-gray-400">Rekomendasi ukuran: 1920x600px untuk hasil terbaik</p>
                </div>
                <input
                    type="file"
                    id="image_path"
                    name="image_path"
                    accept=".png,.jpg,.jpeg"
                    class="hidden"
                >
            </div>
            @error('image_path')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Konten Slide</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul / Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $carouselSlide->title) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul slide"
                    >
                    <p class="text-sm text-gray-500 mt-1">Judul utama yang akan ditampilkan di slide</p>
                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi / Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi slide (opsional)"
                    >{{ old('description', $carouselSlide->description) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Deskripsi singkat di bawah judul</p>
                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Display Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampil <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="order"
                        name="order"
                        min="1"
                        value="{{ old('order', $carouselSlide->order) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('order') border-red-500 @enderror"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Urutan tampilan slide (1 = pertama)</p>
                    @error('order')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Button Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Tombol Call-to-Action</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- CTA Button Text -->
            <div>
                <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Teks Tombol CTA
                </label>
                <input
                    type="text"
                    id="cta_text"
                    name="cta_text"
                    value="{{ old('cta_text', $carouselSlide->cta_text) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_text') border-red-500 @enderror"
                    placeholder="Contoh: Lihat Koleksi"
                >
                <p class="text-sm text-gray-500 mt-1">Teks yang akan ditampilkan di tombol (kosongkan jika tidak ingin ada tombol)</p>
                @error('cta_text')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- CTA Button Link -->
            <div>
                <label for="cta_link" class="block text-sm font-medium text-gray-700 mb-2">
                    Link Tombol CTA
                </label>
                <input
                    type="text"
                    id="cta_link"
                    name="cta_link"
                    value="{{ old('cta_link', $carouselSlide->cta_link) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_link') border-red-500 @enderror"
                    placeholder="Contoh: /catalog atau https://example.com"
                >
                <p class="text-sm text-gray-500 mt-1">URL tujuan ketika tombol diklik</p>
                @error('cta_link')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- CTA Button Preview -->
        <div id="cta_preview" class="hidden mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Preview Tombol:</p>
            <button type="button" id="preview_button" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                Lihat Koleksi
            </button>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.carousel.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Update Slide
        </button>
    </div>
</form>

<script>
// Image preview functionality
document.getElementById('image_path').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image_preview').src = e.target.result;
            document.getElementById('image_preview_container').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// CTA button preview functionality
function updateCTAPreview() {
    const ctaText = document.getElementById('cta_text').value.trim();
    const ctaLink = document.getElementById('cta_link').value.trim();
    const previewContainer = document.getElementById('cta_preview');
    const previewButton = document.getElementById('preview_button');
    
    if (ctaText) {
        previewButton.textContent = ctaText;
        previewContainer.classList.remove('hidden');
        
        if (ctaLink) {
            previewButton.onclick = function() {
                alert(`Link akan mengarah ke: ${ctaLink}`);
            };
        } else {
            previewButton.onclick = function() {
                alert('Link belum diisi');
            };
        }
    } else {
        previewContainer.classList.add('hidden');
    }
}

document.getElementById('cta_text').addEventListener('input', updateCTAPreview);
document.getElementById('cta_link').addEventListener('input', updateCTAPreview);

// Click to upload functionality
document.querySelector('.border-dashed').addEventListener('click', function() {
    document.getElementById('image_path').click();
});

// Initialize CTA preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCTAPreview();
});
</script>
@endsection

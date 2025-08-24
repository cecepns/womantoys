@extends('admin.layouts.app')

@section('title', 'Edit Carousel Slide - Admin Panel')

@section('page-title', 'Edit Slide')
@section('page-description', 'Edit slide carousel yang sudah ada')

@section('content')
<!-- Header Section -->
<div class="mb-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800">Informasi Slide</h3>
                <p class="text-sm text-blue-600">
                    ID: {{ $carousel->id }} | 
                    Dibuat: {{ $carousel->created_at ? $carousel->created_at->format('d M Y H:i') : 'N/A' }} | 
                    Terakhir Update: {{ $carousel->updated_at ? $carousel->updated_at->format('d M Y H:i') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Slide</h1>
            <p class="text-gray-600 mt-2">Edit slide carousel yang sudah ada</p>
        </div>
        <a href="{{ route('admin.carousel.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Carousel Slide Form -->
<form action="{{ route('admin.carousel.update', $carousel) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    
    <!-- Image Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Gambar Slide</h2>
        
        <div class="space-y-4">
            <!-- Current Image Preview -->
            @if($carousel->image_path)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                    <div class="w-full max-w-md">
                        @if($carousel->hasValidImage())
                            <img src="{{ $carousel->image_url }}" alt="Current Image" class="w-full object-cover rounded-lg border border-gray-300">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg border-2 border-red-300 flex items-center justify-center relative">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600">Gambar tidak ditemukan</p>
                                    <p class="text-xs text-gray-500">Path: {{ $carousel->image_path }}</p>
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
                <div class="relative w-full max-w-md">
                    <img id="image_preview" src="" alt="Preview" class="w-full object-cover rounded-lg border border-gray-300">
                    <!-- Remove Preview Button -->
                    <button type="button" id="remove_preview_btn" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-1 rounded-full transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Simple File Input -->
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Gambar Baru (Opsional)
                </label>
                <input
                    type="file"
                    id="image_path"
                    name="image_path"
                    accept=".png,.jpg,.jpeg"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('image_path') border-red-500 @enderror"
                >
                <p class="text-sm text-gray-500 mt-1">PNG, JPG, JPEG (max 5MB) - Rekomendasi: 1920x600px</p>
            </div>
            @error('image_path')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Konten Slide</h2>
        
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
                    value="{{ old('title', $carousel->title) }}"
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
                >{{ old('description', $carousel->description) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Deskripsi singkat di bawah judul</p>
                @error('description')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
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
                                            value="{{ old('cta_text', $carousel->cta_text) }}"
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
                                            value="{{ old('cta_link', $carousel->cta_link) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_link') border-red-500 @enderror"
                    placeholder="Contoh: /catalog atau https://example.com"
                >
                <p class="text-sm text-gray-500 mt-1">URL tujuan ketika tombol diklik</p>
                @error('cta_link')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
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





// Remove preview functionality
document.getElementById('remove_preview_btn').addEventListener('click', function() {
    document.getElementById('image_preview_container').classList.add('hidden');
    document.getElementById('image_path').value = '';
});




</script>
@endsection

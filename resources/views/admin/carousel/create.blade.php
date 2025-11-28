@extends('admin.layouts.app')

@section('title', 'Add Carousel Slide - Admin Panel')

@section('page-title', 'Tambah Slide Baru')
@section('page-description', 'Buat slide carousel baru untuk homepage')

@section('content')
<!-- Header Section -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Slide Baru</h1>
            <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Buat slide carousel baru untuk ditampilkan di homepage</p>
        </div>
        <a href="/admin/carousel" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start text-sm md:text-base w-full sm:w-auto">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Carousel Slide Form -->
<form action="{{ route('admin.carousel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8" id="carouselForm">
    @csrf
    <!-- Image Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4">Gambar Slide</h2>
        
        <div class="space-y-4">
            <!-- Image Preview Area -->
            <div id="image_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
                <div class="relative w-full max-w-sm md:max-w-md">
                    <img id="image_preview" src="" alt="Preview" class="w-full h-32 md:h-48 object-cover rounded-lg border border-gray-300">
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
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Desktop <span class="text-red-500">*</span>
                </label>
                <input
                    type="file"
                    id="image_path"
                    name="image_path"
                    accept=".png,.jpg,.jpeg,.webp"
                    class="w-full px-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('image_path') border-red-500 @enderror text-sm md:text-base"
                    required
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">Format: JPEG, PNG, WebP (maks 5MB) — Rekomendasi: 1920x600px</p>
                @error('image_path')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile Image Preview Area -->
            <div id="image_mobile_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview Gambar Mobile:</p>
                <div class="relative w-full max-w-xs md:max-w-sm">
                    <img id="image_mobile_preview" src="" alt="Preview Mobile" class="w-full h-24 md:h-32 object-cover rounded-lg border border-gray-300">
                    <button type="button" id="remove_mobile_preview_btn" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-1.5 md:p-1 rounded-full transition-colors duration-200">
                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- File Input (Mobile - Optional) -->
            <div>
                <label for="image_mobile_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Mobile (Opsional)
                </label>
                <input
                    type="file"
                    id="image_mobile_path"
                    name="image_mobile_path"
                    accept=".png,.jpg,.jpeg,.webp"
                    class="w-full px-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('image_mobile_path') border-red-500 @enderror text-sm md:text-base"
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">Jika tidak diupload, sistem menggunakan gambar desktop untuk mobile.</p>
                <p id="image_mobile_error" class="text-red-500 text-xs md:text-sm hidden">File harus berupa gambar.</p>
                @error('image_mobile_path')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">Konten Slide</h2>
        
        <div class="space-y-4 md:space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul / Title
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('title') border-red-500 @enderror text-sm md:text-base"
                    placeholder="Masukkan judul slide"
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">Judul utama yang akan ditampilkan di slide</p>
                @error('title')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
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
                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror text-sm md:text-base"
                    placeholder="Masukkan deskripsi slide (opsional)"
                >{{ old('description') }}</textarea>
                <p class="text-xs md:text-sm text-gray-500 mt-1">Deskripsi singkat di bawah judul</p>
                @error('description')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

    </div>

    <!-- CTA Button Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">Tombol Call-to-Action</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- CTA Button Text -->
            <div>
                <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Teks Tombol CTA
                </label>
                <input
                    type="text"
                    id="cta_text"
                    name="cta_text"
                    value="{{ old('cta_text') }}"
                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_text') border-red-500 @enderror text-sm md:text-base"
                    placeholder="Contoh: Lihat Koleksi"
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">Teks yang akan ditampilkan di tombol (kosongkan jika tidak ingin ada tombol)</p>
                @error('cta_text')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
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
                    value="{{ old('cta_link') }}"
                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('cta_link') border-red-500 @enderror text-sm md:text-base"
                    placeholder="Contoh: /catalog atau https://example.com"
                >
                <p class="text-xs md:text-sm text-gray-500 mt-1">URL tujuan ketika tombol diklik</p>
                @error('cta_link')
                    <p class="text-red-500 text-xs md:text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>


    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
        <a href="/admin/carousel" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 md:py-3 px-4 md:px-6 rounded-lg transition-colors duration-200 text-center text-sm md:text-base w-full sm:w-auto">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 md:py-3 px-6 md:px-8 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base w-full sm:w-auto"
            id="submit_btn"
        >
            <svg id="btn_icon" class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg id="btn_spinner" class="hidden animate-spin h-5 w-5 mr-2 text-white" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"></circle>
                <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" fill="none" opacity="0.75"></path>
            </svg>
            Simpan Slide
        </button>
    </div>
</form>

<script>
// Image preview functionality (desktop)
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

document.getElementById('image_mobile_path').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const errorEl = document.getElementById('image_mobile_error');
    errorEl.classList.add('hidden');
    if (!file || !file.type || !file.type.startsWith('image/')) {
        errorEl.classList.remove('hidden');
        document.getElementById('image_mobile_path').value = '';
        document.getElementById('image_mobile_preview_container').classList.add('hidden');
        return;
    }
    const reader = new FileReader();
    reader.onload = function(evt) {
        const img = new Image();
        img.onload = function() {
            const maxW = 800;
            const maxH = 800;
            let w = img.width;
            let h = img.height;
            const ratio = Math.min(maxW / w, maxH / h, 1);
            w = Math.round(w * ratio);
            h = Math.round(h * ratio);
            const canvas = document.createElement('canvas');
            canvas.width = w;
            canvas.height = h;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, w, h);
            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            document.getElementById('image_mobile_preview').src = dataUrl;
            document.getElementById('image_mobile_preview_container').classList.remove('hidden');
        };
        img.src = evt.target.result;
    };
    reader.readAsDataURL(file);
});

document.getElementById('remove_mobile_preview_btn').addEventListener('click', function() {
    document.getElementById('image_mobile_preview_container').classList.add('hidden');
    document.getElementById('image_mobile_path').value = '';
});

document.getElementById('carouselForm').addEventListener('submit', function() {
    const btn = document.getElementById('submit_btn');
    const icon = document.getElementById('btn_icon');
    const spinner = document.getElementById('btn_spinner');
    btn.setAttribute('disabled', 'disabled');
    icon.classList.add('hidden');
    spinner.classList.remove('hidden');
});

</script>
@endsection

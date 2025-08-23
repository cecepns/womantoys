@extends('admin.layouts.app')

@section('title', 'Add Carousel Slide - Admin Panel')

@section('page-title', 'Tambah Slide Baru')
@section('page-description', 'Buat slide carousel baru untuk homepage')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Slide Baru</h1>
            <p class="text-gray-600 mt-2">Buat slide carousel baru untuk ditampilkan di homepage</p>
        </div>
        <a href="/admin/carousel" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Carousel Slide Form -->
<form class="space-y-8">
    <!-- Image Upload Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Gambar Slide</h2>
        
        <div class="space-y-4">
            <!-- Image Preview Area -->
            <div id="image_preview_container" class="hidden">
                <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
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
                    <p class="text-gray-600 mb-2">Klik untuk upload gambar slide</p>
                    <p class="text-sm text-gray-500 mb-4">PNG, JPG, JPEG up to 5MB</p>
                    <p class="text-xs text-gray-400">Rekomendasi ukuran: 1920x600px untuk hasil terbaik</p>
                </div>
                <input
                    type="file"
                    id="slide_image"
                    name="slide_image"
                    accept=".png,.jpg,.jpeg"
                    class="hidden"
                    required
                >
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Konten Slide</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Headline -->
                <div>
                    <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul / Headline <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="headline"
                        name="headline"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Masukkan judul slide"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Judul utama yang akan ditampilkan di slide</p>
                </div>

                <!-- Subtitle/Description -->
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi / Subtitle
                    </label>
                    <textarea
                        id="subtitle"
                        name="subtitle"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Masukkan deskripsi slide (opsional)"
                    ></textarea>
                    <p class="text-sm text-gray-500 mt-1">Deskripsi singkat di bawah judul</p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampil <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="display_order"
                        name="display_order"
                        min="1"
                        value="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Urutan tampilan slide (1 = pertama)</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Slide
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    >
                        <option value="active">Aktif (Tampilkan)</option>
                        <option value="draft">Draft (Simpan Saja)</option>
                        <option value="inactive">Nonaktif (Sembunyikan)</option>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Status tampilan slide</p>
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Contoh: Lihat Koleksi"
                >
                <p class="text-sm text-gray-500 mt-1">Teks yang akan ditampilkan di tombol (kosongkan jika tidak ingin ada tombol)</p>
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Contoh: /catalog atau https://example.com"
                >
                <p class="text-sm text-gray-500 mt-1">URL tujuan ketika tombol diklik</p>
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
        <a href="/admin/carousel" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Slide
        </button>
    </div>
</form>

<script>
// Image preview functionality
document.getElementById('slide_image').addEventListener('change', function(e) {
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

// Form submission handling
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Basic validation
    const requiredFields = ['slide_image', 'headline', 'display_order'];
    let isValid = true;
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    // Check if CTA text is provided but link is missing
    const ctaText = document.getElementById('cta_text').value.trim();
    const ctaLink = document.getElementById('cta_link').value.trim();
    
    if (ctaText && !ctaLink) {
        document.getElementById('cta_link').classList.add('border-red-500');
        alert('Jika mengisi teks tombol CTA, link tujuan juga harus diisi.');
        isValid = false;
    } else {
        document.getElementById('cta_link').classList.remove('border-red-500');
    }
    
    if (isValid) {
        // Show success message (in real app, this would submit to server)
        alert('Slide carousel berhasil disimpan!');
        // Redirect to carousel list
        window.location.href = '/admin/carousel';
    } else {
        alert('Mohon lengkapi semua field yang wajib diisi.');
    }
});

// Click to upload functionality
document.querySelector('.border-dashed').addEventListener('click', function() {
    document.getElementById('slide_image').click();
});
</script>
@endsection

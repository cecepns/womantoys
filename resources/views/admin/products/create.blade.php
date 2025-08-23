@extends('admin.layouts.app')

@section('title', 'Add New Product - Admin Panel')

@section('page-title', 'Tambah Produk Baru')
@section('page-description', 'Tambah produk baru ke katalog toko')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
            <p class="text-gray-600 mt-2">Isi semua detail produk yang diperlukan</p>
        </div>
        <a href="/admin/products" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Product Form -->
<form class="space-y-8">
    <!-- Basic Information Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Dasar Produk</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Text Inputs -->
            <div class="space-y-6">
                <!-- Product Name -->
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="product_name"
                        name="product_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Masukkan nama produk"
                        required
                    >
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        name="category"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        required
                    >
                        <option value="">Pilih kategori</option>
                        <option value="women">Untuk Wanita</option>
                        <option value="men">Untuk Pria</option>
                        <option value="couples">Untuk Pasangan</option>
                        <option value="bdsm">BDSM</option>
                        <option value="lubricants">Pelumas</option>
                        <option value="accessories">Aksesoris</option>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="0"
                            min="0"
                            step="1000"
                            required
                        >
                    </div>
                </div>

                <!-- Short Description -->
                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Singkat <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Deskripsi singkat produk (akan ditampilkan di katalog)"
                        required
                    ></textarea>
                </div>
            </div>

            <!-- Right Column - Image Uploads -->
            <div class="space-y-6">
                <!-- Main Image -->
                <div>
                    <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Utama <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition-colors duration-200">
                        <div id="main_image_preview" class="hidden mb-4">
                            <img id="main_preview_img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg mx-auto">
                        </div>
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-gray-600 mb-2">Klik untuk upload atau drag and drop</p>
                        <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                        <input
                            type="file"
                            id="main_image"
                            name="main_image"
                            accept=".png,.jpg,.jpeg"
                            class="hidden"
                            required
                        >
                    </div>
                </div>

                <!-- Gallery Images -->
                <div>
                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Galeri Tambahan
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition-colors duration-200">
                        <div id="gallery_preview" class="hidden mb-4">
                            <div id="gallery_images_container" class="grid grid-cols-3 gap-2"></div>
                        </div>
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-600 mb-2">Klik untuk upload atau drag and drop</p>
                        <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 5MB (maksimal 5 gambar)</p>
                        <input
                            type="file"
                            id="gallery_images"
                            name="gallery_images[]"
                            accept=".png,.jpg,.jpeg"
                            multiple
                            class="hidden"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Detail Produk</h2>
        
        <div class="space-y-6">
            <!-- Full Description -->
            <div>
                <label for="full_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="full_description"
                    name="full_description"
                    rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                    placeholder="Deskripsi lengkap produk dengan detail fitur dan manfaat"
                    required
                ></textarea>
                <p class="text-sm text-gray-500 mt-1">Gunakan HTML tags untuk formatting jika diperlukan</p>
            </div>

            <!-- Specifications -->
            <div>
                <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">
                    Spesifikasi Teknis
                </label>
                <textarea
                    id="specifications"
                    name="specifications"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                    placeholder="Spesifikasi teknis produk (bahan, ukuran, daya, dll)"
                ></textarea>
            </div>

            <!-- Care Instructions -->
            <div>
                <label for="care_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                    Instruksi Perawatan
                </label>
                <textarea
                    id="care_instructions"
                    name="care_instructions"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                    placeholder="Cara merawat dan membersihkan produk"
                ></textarea>
            </div>
        </div>
    </div>

    <!-- Additional Settings Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Pengaturan Tambahan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Stock Status -->
            <div>
                <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Stok
                </label>
                <select
                    id="stock_status"
                    name="stock_status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                >
                    <option value="in_stock">Tersedia</option>
                    <option value="low_stock">Stok Terbatas</option>
                    <option value="out_of_stock">Stok Habis</option>
                    <option value="pre_order">Pre-Order</option>
                </select>
            </div>

            <!-- Product Status -->
            <div>
                <label for="product_status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Produk
                </label>
                <select
                    id="product_status"
                    name="product_status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                >
                    <option value="active">Aktif (Tampilkan di Katalog)</option>
                    <option value="draft">Draft (Simpan Saja)</option>
                    <option value="inactive">Nonaktif (Sembunyikan)</option>
                </select>
            </div>

            <!-- Featured Product -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="featured"
                    name="featured"
                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                >
                <label for="featured" class="ml-2 text-sm text-gray-700">
                    Tampilkan sebagai Produk Unggulan
                </label>
            </div>

            <!-- Discreet Packaging -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="discreet_packaging"
                    name="discreet_packaging"
                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                    checked
                >
                <label for="discreet_packaging" class="ml-2 text-sm text-gray-700">
                    Kemasan Rahasia (Default)
                </label>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="/admin/products" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Produk
        </button>
    </div>
</form>

<script>
// Main image preview
document.getElementById('main_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('main_preview_img').src = e.target.result;
            document.getElementById('main_image_preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Gallery images preview
document.getElementById('gallery_images').addEventListener('change', function(e) {
    const files = e.target.files;
    const container = document.getElementById('gallery_images_container');
    const preview = document.getElementById('gallery_preview');
    
    container.innerHTML = '';
    
    if (files.length > 0) {
        preview.classList.remove('hidden');
        
        for (let i = 0; i < Math.min(files.length, 5); i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Gallery Preview';
                img.className = 'w-full h-20 object-cover rounded-lg';
                container.appendChild(img);
            };
            
            reader.readAsDataURL(file);
        }
    } else {
        preview.classList.add('hidden');
    }
});

// Form submission handling
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Basic validation
    const requiredFields = ['product_name', 'category', 'price', 'short_description', 'full_description', 'main_image'];
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
    
    if (isValid) {
        // Show success message (in real app, this would submit to server)
        alert('Produk berhasil disimpan!');
        // Redirect to products list
        window.location.href = '/admin/products';
    } else {
        alert('Mohon lengkapi semua field yang wajib diisi.');
    }
});
</script>
@endsection

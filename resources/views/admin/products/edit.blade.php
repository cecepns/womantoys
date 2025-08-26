@extends('admin.layouts.app')

@section('title', 'Edit Product - Admin Panel')

@section('page-title', 'Edit Produk')
@section('page-description', 'Edit detail produk yang sudah ada')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h1>
            <p class="text-gray-600 mt-2">Ubah detail produk sesuai kebutuhan</p>
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
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    <input type="hidden" id="remove_main_image" name="remove_main_image" value="0">
    
    <!-- Basic Information Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Dasar Produk</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Text Inputs -->
            <div class="space-y-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama produk"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih kategori</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                            value="{{ old('price', $product->price) }}"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('price') border-red-500 @enderror"
                            placeholder="0"
                            min="0"
                            step="1000"
                            required
                        >
                    </div>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('short_description') border-red-500 @enderror"
                        placeholder="Deskripsi singkat produk (akan ditampilkan di katalog)"
                        required
                    >{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Image Uploads -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div>
                    <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Utama <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- File Input -->
                    <div class="mb-3">
                        <input
                            type="file"
                            id="main_image"
                            name="main_image"
                            accept=".png,.jpg,.jpeg"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100"
                        >
                    </div>
                    
                    <!-- Image Preview Container -->
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
                        <div id="main_image_container" class="relative inline-block">
                            @if($product->hasValidMainImage())
                                <img 
                                    id="main_preview_img"
                                    src="{{ $product->main_image_url }}" 
                                    alt="Current Main Image" 
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-300"
                                    onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                            @else
                                <!-- No image placeholder -->
                                <div class="w-32 h-32 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="absolute top-1 right-1">
                                        <span class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                                            No Image
                                        </span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Remove button (only show when there's an image) -->
                            <button 
                                id="remove_main_image_btn"
                                type="button" 
                                onclick="removeMainImage()" 
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors {{ $product->hasValidMainImage() ? '' : 'hidden' }}"
                                title="Hapus gambar"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @error('main_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Images -->
                <div>
                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Galeri (Maksimal 5 gambar)
                    </label>
                    
                    <!-- File Input -->
                    <div class="mb-3">
                        <input
                            type="file"
                            id="gallery_images"
                            name="gallery_images[]"
                            accept=".png,.jpg,.jpeg"
                            multiple
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100"
                        >
                    </div>
                    
                    <!-- Gallery Images Container -->
                    <div class="mb-3">
                        <p id="gallery_count" class="text-sm text-gray-600 mb-2">Gambar galeri ({{ $product->images->count() }}/5):</p>
                        <div id="gallery_container" class="grid grid-cols-3 gap-3">
                            @if(isset($product) && $product->images->count() > 0)
                                @foreach($product->images as $index => $image)
                                    <div class="relative gallery-item" data-image-id="{{ $image->id }}">
                                        @if($image->hasValidImage())
                                            <img 
                                                src="{{ $image->image_url }}" 
                                                alt="Gallery Image" 
                                                class="w-full h-24 object-cover rounded-lg border border-gray-300"
                                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            >
                                            <!-- Fallback placeholder when image fails to load -->
                                            <div class="w-full h-24 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300 hidden">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <div class="absolute top-1 right-1">
                                                    <span class="bg-red-100 text-red-800 text-xs px-1 py-0.5 rounded-full">
                                                        Error
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <!-- No image placeholder -->
                                            <div class="w-full h-24 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <div class="absolute top-1 right-1">
                                                    <span class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                                                        No Image
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Remove button for existing images -->
                                        <button 
                                            type="button" 
                                            onclick="removeExistingGalleryImage({{ $image->id }})" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                                            title="Hapus gambar"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <!-- Info box: Deletion applies on submit -->
                    <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded">
                        Catatan: Gambar yang Anda hapus akan benar-benar dihapus dari sistem setelah Anda menekan tombol "Update Produk".
                    </div>
                    

                    
                    @error('gallery_images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi lengkap produk dengan detail fitur dan manfaat"
                    required
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('specifications') border-red-500 @enderror"
                    placeholder="Spesifikasi teknis produk (bahan, ukuran, daya, dll)"
                >{{ old('specifications', $product->specifications) }}</textarea>
                @error('specifications')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('care_instructions') border-red-500 @enderror"
                    placeholder="Cara merawat dan membersihkan produk"
                >{{ old('care_instructions', $product->care_instructions) }}</textarea>
                @error('care_instructions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Additional Settings Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Pengaturan Tambahan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Stock Quantity -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Stok
                </label>
                <input
                    type="number"
                    id="stock"
                    name="stock"
                    value="{{ old('stock', $product->stock) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                    placeholder="0"
                    min="0"
                >
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Produk
                </label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('status') border-red-500 @enderror"
                >
                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif (Tampilkan di Katalog)</option>
                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Saja)</option>
                    <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="/admin/products" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
            Batal
        </a>
        <button
            type="submit"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            Update Produk
        </button>
    </div>
</form>

<script>
// Helpers and constants
const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);
const MAIN_IMAGE_INPUT_ID = 'main_image';
const GALLERY_INPUT_ID = 'gallery_images';
const GALLERY_CONTAINER_ID = 'gallery_container';
const GALLERY_COUNT_ID = 'gallery_count';

function rebuildGalleryInputFiles() {
    const input = document.getElementById(GALLERY_INPUT_ID);
    const dt = new DataTransfer();
    selectedGalleryFiles.forEach(file => dt.items.add(file));
    input.files = dt.files;
}

function addHiddenRemovedInput(imageId) {
    const existingInput = document.querySelector(`input[name="removed_gallery_images[]"][value="${imageId}"]`);
    if (!existingInput) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'removed_gallery_images[]';
        hiddenInput.value = imageId;
        document.querySelector('form').appendChild(hiddenInput);
    }
}

function countVisibleGalleryItems() {
    let visibleCount = 0;
    document.querySelectorAll('.gallery-item').forEach(item => {
        if (item.style.display !== 'none') visibleCount++;
    });
    return visibleCount;
}

function setGalleryCounterText(count) {
    const counterElement = document.getElementById(GALLERY_COUNT_ID);
    if (counterElement) {
        counterElement.textContent = `Gambar galeri (${count}/5):`;
    }
}

function updateGalleryCounter() {
    setGalleryCounterText(countVisibleGalleryItems());
}

// Simple image preview - replace existing image
document.getElementById('main_image').addEventListener('change', function(e) {
    const removeFlag = document.getElementById('remove_main_image');
    if (removeFlag) removeFlag.value = '0';
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('main_image_container');
            const removeBtn = document.getElementById('remove_main_image_btn');
            
            // Remove any existing placeholder or error div
            const existingPlaceholder = container.querySelector('.bg-gray-200');
            if (existingPlaceholder) {
                existingPlaceholder.remove();
            }
            
            // Update or create the image element
            let img = container.querySelector('#main_preview_img');
            if (!img) {
                img = document.createElement('img');
                img.id = 'main_preview_img';
                img.className = 'w-32 h-32 object-cover rounded-lg border border-gray-300';
                img.alt = 'Preview';
                container.insertBefore(img, removeBtn);
            }
            
            img.src = e.target.result;
            removeBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Remove main image function
function removeMainImage() {
    const container = document.getElementById('main_image_container');
    const removeBtn = document.getElementById('remove_main_image_btn');
    
    // Clear file input
    document.getElementById('main_image').value = '';
    const removeFlag = document.getElementById('remove_main_image');
    if (removeFlag) removeFlag.value = '1';
    
    // Remove the image
    const img = container.querySelector('#main_preview_img');
    if (img) {
        img.remove();
    }
    
    // Hide remove button
    removeBtn.classList.add('hidden');
    
    // Show placeholder
    const placeholder = document.createElement('div');
    placeholder.className = 'w-32 h-32 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300';
    placeholder.innerHTML = `
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <div class="absolute top-1 right-1">
            <span class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                No Image
            </span>
        </div>
    `;
    
    container.insertBefore(placeholder, removeBtn);
}

// Gallery management with 5 image limit
let selectedGalleryFiles = [];
let removedExistingImages = [];

document.getElementById('gallery_images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const maxFiles = 5;
    const currentImages = document.querySelectorAll('.gallery-item:not(.new-image)').length;
    const availableSlots = maxFiles - currentImages + removedExistingImages.length;
    
    // Check if adding new files would exceed limit
    if (files.length > availableSlots) {
        alert(`Maksimal ${maxFiles} gambar. Anda hanya bisa menambahkan ${availableSlots} gambar lagi. Hapus beberapa gambar yang ada terlebih dahulu.`);
        // Reset file input
        e.target.value = '';
        return;
    }
    
    // Add new files to selected files
    selectedGalleryFiles = selectedGalleryFiles.concat(files);
    
    // Update the file input
    rebuildGalleryInputFiles();
    
    // Update preview
    updateGalleryPreview();
});

function updateGalleryPreview() {
    const container = document.getElementById(GALLERY_CONTAINER_ID);
    
    // Remove existing new-image previews first
    const existingNewImages = container.querySelectorAll('.gallery-item.new-image');
    existingNewImages.forEach(el => el.remove());
    
    // Add new preview images
    selectedGalleryFiles.forEach((file, index) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative gallery-item new-image';
            wrapper.setAttribute('data-file-index', index);
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Gallery Preview';
            img.className = 'w-full h-24 object-cover rounded-lg border border-gray-300';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
            removeBtn.title = 'Hapus gambar';
            removeBtn.onclick = () => removeNewGalleryImage(index);
            
            removeBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
            
            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            container.appendChild(wrapper);
        };
        
        reader.readAsDataURL(file);
    });
    
    // Update counter
    updateGalleryCounter();
}

function removeNewGalleryImage(index) {
    selectedGalleryFiles.splice(index, 1);
    
    // Update the file input
    rebuildGalleryInputFiles();
    
    // Remove the preview element
    const previewElement = document.querySelector(`[data-file-index="${index}"]`);
    if (previewElement) {
        previewElement.remove();
    }
    
    // Update counter
    updateGalleryCounter();
    
    // Re-index remaining previews
    const remainingPreviews = document.querySelectorAll('.gallery-item.new-image');
    remainingPreviews.forEach((preview, newIndex) => {
        preview.setAttribute('data-file-index', newIndex);
        const removeBtn = preview.querySelector('button');
        if (removeBtn) {
            removeBtn.onclick = () => removeNewGalleryImage(newIndex);
        }
    });
}

function removeExistingGalleryImage(imageId) {
    // Add to removed images list if not already added
    if (!removedExistingImages.includes(imageId)) {
        removedExistingImages.push(imageId);
    }
    
    // Hide the image element
    const selector = `[data-image-id="${imageId}"]`;
    const imageElement = document.querySelector(selector);

    if (imageElement) {
        imageElement.style.display = 'none';
    }

    // Check if hidden input already exists for this image
    addHiddenRemovedInput(imageId);

    // Update counter
    updateGalleryCounter();
    
    // Verify hidden inputs after creation
    const allHiddenInputs = document.querySelectorAll('input[name="removed_gallery_images[]"]');
    const hiddenValues = Array.from(allHiddenInputs).map(input => input.value);
}

// updateGalleryCounter moved above with helpers

document.addEventListener('DOMContentLoaded', () => {
    $$('img[src*="storage"]').forEach(img => {
        img.addEventListener('error', () => {
            img.style.display = 'none';
            const fallback = img.nextElementSibling;
            if (fallback && fallback.classList.contains('hidden')) {
                fallback.classList.remove('hidden');
                fallback.style.display = 'flex';
            }
        });
    });

    updateGalleryCounter();

    [MAIN_IMAGE_INPUT_ID, GALLERY_INPUT_ID].forEach(id => {
        const input = document.getElementById(id);
        if (input && !input.hasAttribute('data-initialized')) {
            input.setAttribute('data-initialized', 'true');
        }
    });
});

// Simple form validation
document.querySelector('form').addEventListener('submit', function(e) {
    console.log('=== FORM SUBMISSION START ===');
    
    // Debug form data BEFORE validation
    const formData = new FormData(this);
    console.log('FormData entries:');
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: ${value}`);
    }
    
    // Check file inputs specifically
    const mainImageInput = document.getElementById('main_image');
    const galleryInput = document.getElementById('gallery_images');
    
    console.log('Main image input files:', mainImageInput.files.length);
    console.log('Gallery images input files:', galleryInput.files.length);
    
    if (mainImageInput.files.length > 0) {
        console.log('Main image file name:', mainImageInput.files[0].name);
    }
    
    if (galleryInput.files.length > 0) {
        console.log('Gallery files:');
        for (let i = 0; i < galleryInput.files.length; i++) {
            console.log(`  File ${i + 1}: ${galleryInput.files[i].name}`);
        }
    }
    
    // Check removed gallery images
    const removedImages = formData.getAll('removed_gallery_images[]');
    console.log('Removed gallery images from FormData:', removedImages);
    
    // Also check hidden inputs directly
    const hiddenInputs = document.querySelectorAll('input[name="removed_gallery_images[]"]');
    console.log('Hidden inputs for removed images:', hiddenInputs.length);
    const hiddenValues = Array.from(hiddenInputs).map(input => input.value);
    console.log('Hidden input values:', hiddenValues);
    
    // Check if there's a mismatch
    if (removedImages.length !== hiddenValues.length) {
        console.log('⚠️ Mismatch: FormData has', removedImages.length, 'but hidden inputs has', hiddenValues.length);
    }
    
    const requiredFields = ['name', 'category_id', 'price', 'short_description', 'description'];
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
    
    // Check if main image is required (only if no existing image)
    const hasExistingImage = document.querySelector('#main_preview_img') && 
                            document.querySelector('#main_preview_img').src && 
                            !document.querySelector('#main_preview_img').src.includes('data:image');
    
    console.log('Has existing image:', hasExistingImage);
    console.log('Main image files:', mainImageInput.files.length);
    
    // Only require main image if there's no existing image
    if (!hasExistingImage && (!mainImageInput.files || mainImageInput.files.length === 0)) {
        console.log('Main image is required but not provided');
        mainImageInput.classList.add('border-red-500');
        isValid = false;
    } else {
        console.log('Main image requirement satisfied');
        mainImageInput.classList.remove('border-red-500');
    }
    
    console.log('Form validation result:', isValid);
    console.log('=== FORM SUBMISSION END ===');
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi.');
        return;
    }
    
    // If valid, let the form submit normally
    console.log('Form is valid, proceeding with submission...');
    
    // Add a small delay to ensure all logs are printed
    setTimeout(() => {
        console.log('Form submission will proceed in 1 second...');
    }, 1000);
    
    // Additional verification before submission
    const finalFormData = new FormData(this);
    console.log('Final FormData before submission:');
    for (let [key, value] of finalFormData.entries()) {
        console.log(`  ${key}: ${value}`);
    }
    
    // Check if files are included
    const mainImageFile = finalFormData.get('main_image');
    const galleryFiles = finalFormData.getAll('gallery_images[]');
    
    console.log('Main image file in FormData:', mainImageFile ? 'Present' : 'Not present');
    console.log('Gallery files in FormData:', galleryFiles.length);
    
    if (mainImageFile && mainImageFile instanceof File) {
        console.log('Main image file name:', mainImageFile.name);
        console.log('Main image file size:', mainImageFile.size);
    }
    
    if (galleryFiles.length > 0) {
        galleryFiles.forEach((file, index) => {
            if (file instanceof File) {
                console.log(`Gallery file ${index + 1}: ${file.name} (${file.size} bytes)`);
            }
        });
    }
});
</script>
@endsection


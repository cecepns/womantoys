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
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf
    
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
                        value="{{ old('name') }}"
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            value="{{ old('price') }}"
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
                    >{{ old('short_description') }}</textarea>
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
                            required
                        >
                    </div>
                    
                    <!-- Preview Section -->
                    <div id="main_image_preview" class="hidden">
                        <div class="relative inline-block">
                            <img id="main_preview_img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            <button 
                                type="button" 
                                onclick="removeMainImage()" 
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
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
                    
                    <!-- Preview Section -->
                    <div id="gallery_preview" class="hidden">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600 mb-2">Gambar yang dipilih:</p>
                        </div>
                        <div id="gallery_images_container" class="grid grid-cols-3 gap-3"></div>
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
                    rows="10"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi lengkap produk dengan detail fitur dan manfaat"
                    required
                >{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Gunakan HTML tags untuk formatting jika diperlukan</p>
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
                    rows="10"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('specifications') border-red-500 @enderror"
                    placeholder="Spesifikasi teknis produk (bahan, ukuran, daya, dll)"
                >{{ old('specifications') }}</textarea>
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
                    rows="10"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('care_instructions') border-red-500 @enderror"
                    placeholder="Cara merawat dan membersihkan produk"
                >{{ old('care_instructions') }}</textarea>
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
                    value="{{ old('stock', 0) }}"
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
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif (Tampilkan di Katalog)</option>
                    <option value="draft" {{ old('status', 'active') == 'draft' ? 'selected' : '' }}>Draft (Simpan Saja)</option>
                    <option value="out_of_stock" {{ old('status', 'active') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
// Simple image preview
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

// Remove main image function
function removeMainImage() {
    document.getElementById('main_image').value = '';
    document.getElementById('main_image_preview').classList.add('hidden');
}

// Gallery preview with individual remove
let selectedGalleryFiles = [];

document.getElementById('gallery_images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const maxFiles = 5;
    
    // Check if adding new files would exceed limit
    if (selectedGalleryFiles.length + files.length > maxFiles) {
        alert(`Maksimal ${maxFiles} gambar. Anda sudah memilih ${selectedGalleryFiles.length} gambar.`);
        return;
    }
    
    // Add new files to selected files
    selectedGalleryFiles = selectedGalleryFiles.concat(files);
    
    // Update the file input
    const dt = new DataTransfer();
    selectedGalleryFiles.forEach(file => dt.items.add(file));
    e.target.files = dt.files;
    
    // Update preview
    updateGalleryPreview();
});

function updateGalleryPreview() {
    const container = document.getElementById('gallery_images_container');
    const preview = document.getElementById('gallery_preview');
    
    container.innerHTML = '';
    
    if (selectedGalleryFiles.length > 0) {
        preview.classList.remove('hidden');
        
        selectedGalleryFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Gallery Preview';
                img.className = 'w-full h-24 object-cover rounded-lg border border-gray-300';
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
                removeBtn.title = 'Hapus gambar';
                removeBtn.onclick = () => removeGalleryImage(index);
                
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
    } else {
        preview.classList.add('hidden');
    }
}

function removeGalleryImage(index) {
    selectedGalleryFiles.splice(index, 1);
    
    // Update the file input
    const input = document.getElementById('gallery_images');
    const dt = new DataTransfer();
    selectedGalleryFiles.forEach(file => dt.items.add(file));
    input.files = dt.files;
    
    // Update preview
    updateGalleryPreview();
}

// Simple form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'category_id', 'price', 'short_description', 'description', 'main_image'];
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
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi.');
    }
});
</script>
@endsection

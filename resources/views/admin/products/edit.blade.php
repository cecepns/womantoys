@extends('admin.layouts.app')

@section('title', 'Edit Product - Admin Panel')

@section('page-title', 'Edit Produk')
@section('page-description', 'Edit detail produk yang sudah ada')

@section('content')
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h1>
                <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">Ubah detail produk sesuai kebutuhan</p>
            </div>
            <a href="/admin/products"
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-3 md:px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                <span class="text-sm md:text-base">Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Product Form -->
    <form id="product_form" method="POST" action="{{ route('admin.products.update', $product) }}"
        enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        <input type="hidden" id="remove_main_image" name="remove_main_image" value="0">

        <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Dasar Produk</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Text Inputs -->
                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama produk" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                placeholder="0" min="0" required>
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Price -->
                    <div>
                        <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Diskon
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" id="discount_price" name="discount_price"
                                value="{{ old('discount_price', $product->discount_price) }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('discount_price') border-red-500 @enderror"
                                placeholder="0" min="0">
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ada diskon. Harga diskon harus lebih
                            kecil dari harga normal.</p>
                        @error('discount_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat (gram)
                        </label>
                        <div class="relative">
                            <input type="number" id="weight" name="weight"
                                value="{{ old('weight', $product->weight) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('weight') border-red-500 @enderror"
                                placeholder="0" min="0" step="0.01">
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">gram</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Kosongkan jika berat tidak diketahui</p>
                        @error('weight')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Singkat <span class="text-red-500">*</span>
                        </label>
                        <textarea id="short_description" name="short_description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('short_description') border-red-500 @enderror"
                            placeholder="Deskripsi singkat produk (akan ditampilkan di katalog)" required>{{ old('short_description', $product->short_description) }}</textarea>
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
                            <input type="file" id="main_image" name="main_image" accept=".png,.jpg,.jpeg"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        </div>

                        <!-- Image Preview Container -->
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
                            <div id="main_image_container" class="relative inline-block">
                                @if ($product->hasValidMainImage())
                                    <img id="main_preview_img" src="{{ $product->main_image_url }}"
                                        alt="Current Main Image"
                                        class="w-32 h-32 object-cover rounded-lg border border-gray-300"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @else
                                    <!-- No image placeholder -->
                                    <div
                                        class="w-32 h-32 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div class="absolute top-1 right-1">
                                            <span class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                                                No Image
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Remove button (only show when there's an image) -->
                                <button id="remove_main_image_btn" type="button" onclick="removeMainImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors {{ $product->hasValidMainImage() ? '' : 'hidden' }}"
                                    title="Hapus gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
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
                            Gambar Galeri
                        </label>

                        <!-- File Input -->
                        <div class="mb-3">
                            <input type="file" id="gallery_images" name="gallery_images[]" accept=".png,.jpg,.jpeg,.mp4"
                                multiple
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        </div>

                        <!-- Gallery Images Container -->
                        <div class="mb-3">

                            <div id="gallery_container" class="grid grid-cols-3 gap-3">
                                @if (isset($product) && $product->images->count() > 0)
                                    @foreach ($product->images as $index => $image)
                                        <div class="relative gallery-item" data-image-id="{{ $image->id }}">
                                            @if ($image->hasValidImage())
                                                @if ($image->isVideo())
                                                    <video src="{{ $image->image_url }}" controls muted
                                                        class="w-full h-24 object-cover rounded-lg border border-gray-300">
                                                    </video>
                                                @else
                                                    <img src="{{ $image->image_url }}" alt="Gallery Image"
                                                        class="w-full h-24 object-cover rounded-lg border border-gray-300"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <!-- Fallback placeholder when image fails to load -->
                                                    <div
                                                        class="w-full h-24 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300 hidden">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        <div class="absolute top-1 right-1">
                                                            <span
                                                                class="bg-red-100 text-red-800 text-xs px-1 py-0.5 rounded-full">
                                                                Error
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <!-- No image placeholder -->
                                                <div
                                                    class="w-full h-24 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <div class="absolute top-1 right-1">
                                                        <span
                                                            class="bg-gray-100 text-gray-600 text-xs px-1 py-0.5 rounded-full">
                                                            No File
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Remove button for existing images -->
                                            <button type="button"
                                                onclick="removeExistingGalleryImage({{ $image->id }})"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                                                title="Hapus {{ $image->isVideo() ? 'video' : 'gambar' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Info box: Deletion applies on submit -->
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded">
                            Catatan: Gambar yang Anda hapus akan benar-benar dihapus dari sistem setelah Anda menekan tombol
                            "Update Produk".
                        </div>



                        @error('gallery_images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Detail Produk</h2>

            <div class="space-y-6">
                <!-- Full Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi lengkap produk dengan detail fitur dan manfaat" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specifications -->
                <div>
                    <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesifikasi Teknis
                    </label>
                    <textarea id="specifications" name="specifications" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('specifications') border-red-500 @enderror"
                        placeholder="Spesifikasi teknis produk (bahan, ukuran, daya, dll)">{{ old('specifications', $product->specifications) }}</textarea>
                    @error('specifications')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Care Instructions -->
                <div>
                    <label for="care_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Instruksi Perawatan
                    </label>
                    <textarea id="care_instructions" name="care_instructions" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('care_instructions') border-red-500 @enderror"
                        placeholder="Cara merawat dan membersihkan produk">{{ old('care_instructions', $product->care_instructions) }}</textarea>
                    @error('care_instructions')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Settings Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Pengaturan Tambahan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stock Quantity -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Stok
                    </label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                        placeholder="0" min="0">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Produk
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif
                            (Tampilkan di Katalog)</option>
                        <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft
                            (Simpan Saja)</option>
                        <option value="out_of_stock"
                            {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Featured Product Setting -->
            <div class="mt-6">
                <div class="flex items-center">
                    <!-- Hidden input to ensure the field is always sent -->
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                        {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="is_featured" class="ml-3 block text-sm font-medium text-gray-700">
                        Atur Sebagai Produk Unggulan
                    </label>
                </div>
                <p class="text-gray-500 text-xs mt-1 ml-7">Produk unggulan akan ditampilkan di halaman utama website</p>
                @error('is_featured')
                    <p class="text-red-500 text-sm mt-1 ml-7">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
            <a href="/admin/products"
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 md:py-2 px-4 rounded-lg transition-colors duration-200 text-center text-sm md:text-base order-2 sm:order-1">
                Batal
            </a>
            <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2.5 md:py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base order-1 sm:order-2">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                <span>Update Produk</span>
            </button>
        </div>
    </form>

    <!-- Product Variants Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6 mt-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Kelola Variant Produk</h2>
                <p class="text-gray-600 text-sm mt-1">Tambahkan variant seperti ukuran, warna, atau tipe (Opsional)</p>
            </div>
            <button type="button" onclick="openVariantModal()"
                class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Variant
            </button>
        </div>

        @if ($product->variants->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Variant</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th style="width: 150px" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($product->variants as $variant)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($variant->image_url)
                                        <img src="{{ $variant->image_url }}" alt="{{ $variant->name }}" class="h-12 w-12 object-cover rounded">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $variant->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($variant->hasDiscount())
                                        <div class="flex flex-col">
                                            <span class="text-red-600 font-medium">{{ $variant->formatted_final_price }}</span>
                                            <span class="text-gray-400 line-through text-xs">{{ $variant->formatted_price }}</span>
                                        </div>
                                    @else
                                        {{ $variant->formatted_price }}
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $variant->stock }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.products.variants.toggle-active', [$product, $variant]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs px-2 py-1 rounded {{ $variant->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $variant->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" onclick='openVariantModal({{ json_encode($variant) }})'
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus variant ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="mt-2">Belum ada variant. Produk ini tidak memiliki variant.</p>
            </div>
        @endif
    </div>

    <!-- Variant Modal -->
    <div id="variantModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Tambah Variant</h3>
                <button type="button" onclick="closeVariantModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="variantForm" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <input type="hidden" id="variantId" name="variant_id">
                <input type="hidden" id="variantMethod" name="_method" value="POST">
                <input type="hidden" id="remove_variant_image" name="remove_image" value="0">

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="variant_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Variant <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="variant_name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                placeholder="contoh: Ukuran S, Warna Merah">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="variant_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="variant_price" name="price" required min="0"
                                    class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label for="variant_discount_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Diskon
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="variant_discount_price" name="discount_price" min="0"
                                    class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="variant_stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="variant_stock" name="stock" required min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="0">
                    </div>

                    <div>
                        <label for="variant_image" class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Variant
                        </label>
                        <input type="file" id="variant_image" name="image" accept=".png,.jpg,.jpeg"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        
                        <div id="variant_image_preview" class="mt-2 hidden">
                            <div class="relative inline-block">
                                <img id="variant_preview_img" src="" alt="Preview" class="h-24 w-24 object-cover rounded border">
                                <button type="button" onclick="removeVariantImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="variant_is_active" name="is_active" value="1" checked
                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                        <label for="variant_is_active" class="ml-2 block text-sm text-gray-700">
                            Aktifkan variant ini
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeVariantModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        Simpan Variant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variant Modal Functions
        function openVariantModal(variant = null) {
            const modal = document.getElementById('variantModal');
            const form = document.getElementById('variantForm');
            const modalTitle = document.getElementById('modalTitle');
            
            if (variant) {
                // Edit mode
                modalTitle.textContent = 'Edit Variant';
                form.action = `/admin/products/{{ $product->slug }}/variants/${variant.id}`;
                document.getElementById('variantMethod').value = 'PUT';
                document.getElementById('variantId').value = variant.id;
                document.getElementById('variant_name').value = variant.name;
                document.getElementById('variant_price').value = variant.price;
                document.getElementById('variant_discount_price').value = variant.discount_price || '';
                document.getElementById('variant_stock').value = variant.stock;
                document.getElementById('variant_is_active').checked = variant.is_active;
                
                if (variant.image_url) {
                    document.getElementById('variant_preview_img').src = variant.image_url;
                    document.getElementById('variant_image_preview').classList.remove('hidden');
                }
            } else {
                // Add mode
                modalTitle.textContent = 'Tambah Variant';
                form.action = `/admin/products/{{ $product->slug }}/variants`;
                document.getElementById('variantMethod').value = 'POST';
                form.reset();
                document.getElementById('variant_is_active').checked = true;
                document.getElementById('variant_image_preview').classList.add('hidden');
            }
            
            modal.classList.remove('hidden');
        }

        function closeVariantModal() {
            document.getElementById('variantModal').classList.add('hidden');
            document.getElementById('variantForm').reset();
            document.getElementById('variant_image_preview').classList.add('hidden');
            document.getElementById('remove_variant_image').value = '0';
        }

        function removeVariantImage() {
            document.getElementById('variant_image').value = '';
            document.getElementById('variant_image_preview').classList.add('hidden');
            document.getElementById('remove_variant_image').value = '1';
        }

        // Preview variant image on change
        document.getElementById('variant_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('variant_preview_img').src = e.target.result;
                    document.getElementById('variant_image_preview').classList.remove('hidden');
                    document.getElementById('remove_variant_image').value = '0';
                };
                reader.readAsDataURL(file);
            }
        });

        // Close modal when clicking outside
        document.getElementById('variantModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeVariantModal();
            }
        });
    </script>

    <script>
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => document.querySelectorAll(selector);
        const MAIN_IMAGE_INPUT_ID = 'main_image';
        const GALLERY_INPUT_ID = 'gallery_images';
        const GALLERY_CONTAINER_ID = 'gallery_container';

        // Numeric normalization helpers (remove leading zeros on input)
        const getElement = (id) => document.getElementById(id);

        const normalizeNumberInputValue = (value, allowDecimal = false) => {
            if (value === undefined || value === null) return '';
            value = String(value);
            if (value === '') return '';

            if (value === '.') return '0.';

            if (allowDecimal && value.includes('.')) {
                const parts = value.split('.');
                const intPart = parts.shift();
                const fracPart = parts.join('.');

                let normalizedInt = intPart.replace(/^0+/, '');
                if (normalizedInt === '') normalizedInt = '0';
                return fracPart.length > 0 ? `${normalizedInt}.${fracPart}` : `${normalizedInt}.`;
            }

            const intOnly = value.split('.')[0];
            let normalized = intOnly.replace(/^0+/, '');
            if (normalized === '') normalized = '0';
            return normalized;
        };

        const attachNormalizeListener = (id, allowDecimal = false) => {
            const el = getElement(id);
            if (!el) return;
            el.addEventListener('input', (e) => {
                const before = el.value;
                const normalized = normalizeNumberInputValue(before, allowDecimal);
                if (normalized !== before) {
                    const prevSelectionStart = el.selectionStart ?? null;
                    el.value = normalized;
                    if (prevSelectionStart !== null) {
                        const delta = normalized.length - before.length;
                        try { el.setSelectionRange(prevSelectionStart + delta, prevSelectionStart + delta); } catch (err) {}
                    }
                }
            });
        };


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
                const form = document.getElementById('product_form') || document.querySelector('form');
                form.appendChild(hiddenInput);
            }
        }



        document.getElementById('main_image').addEventListener('change', function(e) {
            const removeFlag = document.getElementById('remove_main_image');
            if (removeFlag) removeFlag.value = '0';
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.getElementById('main_image_container');
                    const removeBtn = document.getElementById('remove_main_image_btn');
                    const existingPlaceholder = container.querySelector('.bg-gray-200');
                    if (existingPlaceholder) {
                        existingPlaceholder.remove();
                    }
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

        function removeMainImage() {
            const container = document.getElementById('main_image_container');
            const removeBtn = document.getElementById('remove_main_image_btn');
            document.getElementById('main_image').value = '';
            const removeFlag = document.getElementById('remove_main_image');
            if (removeFlag) removeFlag.value = '1';
            const img = container.querySelector('#main_preview_img');
            if (img) {
                img.remove();
            }
            removeBtn.classList.add('hidden');
            const placeholder = document.createElement('div');
            placeholder.className =
                'w-32 h-32 bg-gray-200 flex items-center justify-center rounded-lg border border-gray-300';
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

        let selectedGalleryFiles = [];
        let removedExistingImages = [];

        document.getElementById('gallery_images').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);

            selectedGalleryFiles = selectedGalleryFiles.concat(files);
            rebuildGalleryInputFiles();
            updateGalleryPreview();
        });

        function updateGalleryPreview() {
            const container = document.getElementById(GALLERY_CONTAINER_ID);
            const existingNewImages = container.querySelectorAll('.gallery-item.new-image');
            existingNewImages.forEach(el => el.remove());
            selectedGalleryFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative gallery-item new-image';
                    wrapper.setAttribute('data-file-index', index);
                    
                    const isVideo = file.type.startsWith('video/');
                    const mediaElement = isVideo ? document.createElement('video') : document.createElement('img');
                    
                    mediaElement.src = e.target.result;
                    mediaElement.className = 'w-full h-24 object-cover rounded-lg border border-gray-300';
                    
                    if (isVideo) {
                        mediaElement.controls = true;
                        mediaElement.muted = true;
                    } else {
                        mediaElement.alt = 'Gallery Preview';
                    }
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className =
                        'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
                    removeBtn.title = 'Hapus ' + (isVideo ? 'video' : 'gambar');
                    removeBtn.onclick = () => removeNewGalleryImage(index);
                    removeBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
                    wrapper.appendChild(mediaElement);
                    wrapper.appendChild(removeBtn);
                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeNewGalleryImage(index) {
            selectedGalleryFiles.splice(index, 1);
            rebuildGalleryInputFiles();
            const previewElement = document.querySelector(`[data-file-index="${index}"]`);
            if (previewElement) {
                previewElement.remove();
            }
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
            if (!removedExistingImages.includes(imageId)) {
                removedExistingImages.push(imageId);
            }
            const selector = `[data-image-id="${imageId}"]`;
            const imageElement = document.querySelector(selector);
            if (imageElement) {
                imageElement.style.display = 'none';
            }
            addHiddenRemovedInput(imageId);
        }

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
            [MAIN_IMAGE_INPUT_ID, GALLERY_INPUT_ID].forEach(id => {
                const input = document.getElementById(id);
                if (input && !input.hasAttribute('data-initialized')) {
                    input.setAttribute('data-initialized', 'true');
                }
            });
            // attach numeric normalization listeners
            attachNormalizeListener('price', false);
            attachNormalizeListener('discount_price', false);
            attachNormalizeListener('weight', true);
            attachNormalizeListener('stock', false);
            attachNormalizeListener('variant_price', false);
            attachNormalizeListener('variant_discount_price', false);
            attachNormalizeListener('variant_stock', false);
        });

        document.getElementById('product_form').addEventListener('submit', function(e) {
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
            const mainImageInput = document.getElementById('main_image');
            const hasExistingImage = document.querySelector('#main_preview_img') &&
                document.querySelector('#main_preview_img').src &&
                !document.querySelector('#main_preview_img').src.includes('data:image');
            if (!hasExistingImage && (!mainImageInput.files || mainImageInput.files.length === 0)) {
                mainImageInput.classList.add('border-red-500');
                isValid = false;
            } else {
                mainImageInput.classList.remove('border-red-500');
            }
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
                return;
            }
        });
    </script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Add New Product - Admin Panel')

@section('page-title', 'Tambah Produk Baru')
@section('page-description', 'Tambah produk baru ke katalog toko')

@section('content')
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
                <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">Isi semua detail produk yang diperlukan</p>
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
    <form id="product-create-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

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
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <input type="number" id="price" name="price" value="{{ old('price') }}"
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
                                value="{{ old('discount_price') }}"
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
                            <input type="number" id="weight" name="weight" value="{{ old('weight') }}"
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
                            placeholder="Deskripsi singkat produk (akan ditampilkan di katalog)" required>{{ old('short_description') }}</textarea>
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
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100"
                                required>
                        </div>

                        <!-- Preview Section -->
                        <div id="main_image_preview" class="hidden">
                            <div class="relative inline-block">
                                <img id="main_preview_img" src="" alt="Preview"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                <button type="button" onclick="removeMainImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
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
                            Gambar/Video Galeri
                        </label>

                        <!-- File Input -->
                        <div class="mb-3">
                            <input type="file" id="gallery_images" name="gallery_images[]" accept=".png,.jpg,.jpeg,.mp4"
                                multiple
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
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
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Detail Produk</h2>

            <div class="space-y-6">
                <!-- Full Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="10"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi lengkap produk dengan detail fitur dan manfaat" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specifications -->
                <div>
                    <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesifikasi Teknis
                    </label>
                    <textarea id="specifications" name="specifications" rows="10"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('specifications') border-red-500 @enderror"
                        placeholder="Spesifikasi teknis produk (bahan, ukuran, daya, dll)">{{ old('specifications') }}</textarea>
                    @error('specifications')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Care Instructions -->
                <div>
                    <label for="care_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Instruksi Perawatan
                    </label>
                    <textarea id="care_instructions" name="care_instructions" rows="10"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('care_instructions') border-red-500 @enderror"
                        placeholder="Cara merawat dan membersihkan produk">{{ old('care_instructions') }}</textarea>
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
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
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
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif
                            (Tampilkan di Katalog)</option>
                        <option value="draft" {{ old('status', 'active') == 'draft' ? 'selected' : '' }}>Draft (Simpan
                            Saja)</option>
                        <option value="out_of_stock" {{ old('status', 'active') == 'out_of_stock' ? 'selected' : '' }}>
                            Stok Habis</option>
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
                        {{ old('is_featured') ? 'checked' : '' }}
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

        <!-- Product Variants Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
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

            <div id="variants-container">
                <div id="variants-list" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Variant</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="variants-tbody" class="bg-white divide-y divide-gray-200">
                                <!-- Variants will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="no-variants-message" class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="mt-2">Belum ada variant. Klik "Tambah Variant" untuk menambahkan.</p>
                </div>
            </div>

            <!-- Hidden input to store variants JSON -->
            <input type="hidden" name="variants_json" id="variants_json" value="">
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
            <a href="/admin/products"
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-colors duration-200 text-center text-sm md:text-base order-2 sm:order-1">
                Batal
            </a>
            <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-8 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base order-1 sm:order-2">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan Produk</span>
            </button>
        </div>
    </form>

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
            
            <div class="mt-4">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="variant_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Variant <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="variant_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                placeholder="contoh: Ukuran S, Warna Merah">
                        </div>

                        <div>
                            <label for="variant_sku" class="block text-sm font-medium text-gray-700 mb-1">
                                SKU (Opsional)
                            </label>
                            <input type="text" id="variant_sku"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                placeholder="contoh: PROD-VAR-001">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="variant_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="variant_price" required min="0"
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
                                <input type="number" id="variant_discount_price" min="0"
                                    class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="variant_stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="variant_stock" required min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="0">
                    </div>

                    <div>
                        <label for="variant_image" class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Variant
                        </label>
                        <input type="file" id="variant_image" accept=".png,.jpg,.jpeg"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        
                        <div id="variant_image_preview" class="mt-2 hidden">
                            <div class="relative inline-block">
                                <img id="variant_preview_img" src="" alt="Preview" class="h-24 w-24 object-cover rounded border">
                                <button type="button" onclick="removeVariantImagePreview()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="variant_is_active" checked
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
                    <button type="button" onclick="saveVariant()"
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        Simpan Variant
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ANCHOR: State Management
        const state = {
            variants: [],
            editingVariantIndex: null,
            selectedGalleryFiles: [],
            isSubmitting: false
        };

        const ELEMENTS = {
            form: document.getElementById('product-create-form'),
            submitButton: null,
            variantModal: document.getElementById('variantModal'),
            modalTitle: document.getElementById('modalTitle'),
            variantsList: document.getElementById('variants-list'),
            variantsTbody: document.getElementById('variants-tbody'),
            noVariantsMessage: document.getElementById('no-variants-message'),
            variantsJson: document.getElementById('variants_json')
        };

        ELEMENTS.submitButton = ELEMENTS.form?.querySelector('button[type="submit"]');
        const ORIGINAL_BUTTON_TEXT = ELEMENTS.submitButton?.innerHTML || '';

        // ANCHOR: Element Validation
        if (!ELEMENTS.form) {
            alert('Error: Form tidak ditemukan. Silakan refresh halaman.');
        }

        const REQUIRED_FIELDS = ['name', 'category_id', 'price', 'short_description', 'description', 'main_image'];
        const SUBMIT_TIMEOUT = 180000; // 3 minutes

        // ANCHOR: Utility Functions
        const getElement = (id) => document.getElementById(id);
        
        const toggleVisibility = (element, show) => {
            element?.classList[show ? 'remove' : 'add']('hidden');
        };

        const formatPrice = (price) => price.toLocaleString('id-ID');

        const validateDiscountPrice = (price, discountPrice) => {
            if (!discountPrice) return true;
            return parseFloat(discountPrice) < parseFloat(price);
        };

        const createImagePreview = (src, alt = 'Preview') => {
            if (!src) return '';
            return `<img src="${src}" alt="${alt}" class="h-12 w-12 object-cover rounded">`;
        };

        const createPlaceholderImage = () => `
            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>`;

        const createRemoveButton = () => `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>`;

        // ANCHOR: Image Preview Handlers
        const handleImagePreview = (file, previewImgId, previewContainerId) => {
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                const previewImg = getElement(previewImgId);
                const previewContainer = getElement(previewContainerId);
                
                if (previewImg) previewImg.src = e.target.result;
                toggleVisibility(previewContainer, true);
            };
            reader.readAsDataURL(file);
        };

        const handleMainImageChange = (e) => {
            handleImagePreview(e.target.files[0], 'main_preview_img', 'main_image_preview');
        };

        const removeMainImage = () => {
            const mainImage = getElement('main_image');
            const previewContainer = getElement('main_image_preview');
            
            if (mainImage) mainImage.value = '';
            toggleVisibility(previewContainer, false);
        };

        const handleVariantImageChange = (e) => {
            handleImagePreview(e.target.files[0], 'variant_preview_img', 'variant_image_preview');
        };

        const removeVariantImagePreview = () => {
            const variantImage = getElement('variant_image');
            const previewContainer = getElement('variant_image_preview');
            
            if (variantImage) variantImage.value = '';
            toggleVisibility(previewContainer, false);
        };

        // ANCHOR: Gallery Image Handlers
        const updateGalleryFileInput = (files) => {
            const input = getElement('gallery_images');
            if (!input) return;
            
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        };

        const createGalleryImageElement = (file, index) => {
            const reader = new FileReader();
            
            reader.onload = (e) => {
                const container = getElement('gallery_images_container');
                if (!container) return;

                const wrapper = document.createElement('div');
                wrapper.className = 'relative';

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
                removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
                removeBtn.title = 'Hapus ' + (isVideo ? 'video' : 'gambar');
                removeBtn.onclick = () => removeGalleryImage(index);
                removeBtn.innerHTML = createRemoveButton();

                wrapper.appendChild(mediaElement);
                wrapper.appendChild(removeBtn);
                container.appendChild(wrapper);
            };
            
            reader.readAsDataURL(file);
        };

        const updateGalleryPreview = () => {
            const container = getElement('gallery_images_container');
            const preview = getElement('gallery_preview');
            
            if (!container || !preview) return;
            
            container.innerHTML = '';
            
            const hasFiles = state.selectedGalleryFiles.length > 0;
            toggleVisibility(preview, hasFiles);
            
            if (hasFiles) {
                state.selectedGalleryFiles.forEach((file, index) => {
                    createGalleryImageElement(file, index);
                });
            }
        };

        const handleGalleryImagesChange = (e) => {
            const newFiles = Array.from(e.target.files);
            state.selectedGalleryFiles = [...state.selectedGalleryFiles, ...newFiles];
            updateGalleryFileInput(state.selectedGalleryFiles);
            updateGalleryPreview();
        };

        const removeGalleryImage = (index) => {
            state.selectedGalleryFiles.splice(index, 1);
            updateGalleryFileInput(state.selectedGalleryFiles);
            updateGalleryPreview();
        };

        // ANCHOR: Variant Management
        const getVariantFormData = () => ({
            name: getElement('variant_name')?.value.trim(),
            sku: getElement('variant_sku')?.value.trim(),
            price: getElement('variant_price')?.value,
            discount_price: getElement('variant_discount_price')?.value,
            stock: getElement('variant_stock')?.value,
            is_active: getElement('variant_is_active')?.checked,
            imageFile: getElement('variant_image')?.files[0]
        });

        const setVariantFormData = (variant) => {
            const elements = {
                name: getElement('variant_name'),
                sku: getElement('variant_sku'),
                price: getElement('variant_price'),
                discount_price: getElement('variant_discount_price'),
                stock: getElement('variant_stock'),
                is_active: getElement('variant_is_active')
            };

            if (elements.name) elements.name.value = variant.name;
            if (elements.sku) elements.sku.value = variant.sku || '';
            if (elements.price) elements.price.value = variant.price;
            if (elements.discount_price) elements.discount_price.value = variant.discount_price || '';
            if (elements.stock) elements.stock.value = variant.stock;
            if (elements.is_active) elements.is_active.checked = variant.is_active;
                
                if (variant.image_preview) {
                const previewImg = getElement('variant_preview_img');
                const previewContainer = getElement('variant_image_preview');
                if (previewImg) previewImg.src = variant.image_preview;
                toggleVisibility(previewContainer, true);
            }
        };

        const clearVariantForm = () => {
            const fields = ['variant_name', 'variant_sku', 'variant_price', 'variant_discount_price', 'variant_stock', 'variant_image'];
            fields.forEach(id => {
                const element = getElement(id);
                if (element) element.value = '';
            });

            const isActiveCheckbox = getElement('variant_is_active');
            if (isActiveCheckbox) isActiveCheckbox.checked = true;
            
            toggleVisibility(getElement('variant_image_preview'), false);
        };

        const openVariantModal = (index = null) => {
            const isEditMode = index !== null;
            state.editingVariantIndex = isEditMode ? index : null;

            if (ELEMENTS.modalTitle) {
                ELEMENTS.modalTitle.textContent = isEditMode ? 'Edit Variant' : 'Tambah Variant';
            }

            if (isEditMode) {
                setVariantFormData(state.variants[index]);
            } else {
                clearVariantForm();
            }

            toggleVisibility(ELEMENTS.variantModal, true);
        };

        const closeVariantModal = () => {
            toggleVisibility(ELEMENTS.variantModal, false);
            clearVariantForm();
            state.editingVariantIndex = null;
        };

        const validateVariantData = (data) => {
            if (!data.name || !data.price || !data.stock) {
                alert('Nama, Harga, dan Stok wajib diisi!');
                return false;
            }

            if (!validateDiscountPrice(data.price, data.discount_price)) {
                alert('Harga diskon harus lebih kecil dari harga normal!');
                return false;
            }

            return true;
        };

        const createVariantData = (formData) => ({
            name: formData.name,
            sku: formData.sku,
            price: parseFloat(formData.price),
            discount_price: formData.discount_price ? parseFloat(formData.discount_price) : null,
            stock: parseInt(formData.stock),
            is_active: formData.is_active,
            image_file: formData.imageFile || null,
            image_preview: formData.imageFile ? getElement('variant_preview_img')?.src : null
        });

        const saveVariant = () => {
            
            const formData = getVariantFormData();
            
            if (!validateVariantData(formData)) {
                return;
            }

            const variantData = createVariantData(formData);

            if (state.editingVariantIndex !== null) {
                state.variants[state.editingVariantIndex] = variantData;
            } else {
                state.variants.push(variantData);
            }
            updateVariantsDisplay();
            closeVariantModal();
        };

        const deleteVariant = (index) => {
            if (!confirm('Yakin ingin menghapus variant ini?')) return;
            
            state.variants.splice(index, 1);
                updateVariantsDisplay();
        };

        const toggleVariantActive = (index) => {
            state.variants[index].is_active = !state.variants[index].is_active;
            updateVariantsDisplay();
        };

        const createVariantPriceDisplay = (variant) => {
            const hasDiscount = variant.discount_price && variant.discount_price < variant.price;
            const finalPrice = hasDiscount ? variant.discount_price : variant.price;

            if (!hasDiscount) return `Rp ${formatPrice(variant.price)}`;

            return `
                <div class="flex flex-col">
                    <span class="text-red-600 font-medium">Rp ${formatPrice(finalPrice)}</span>
                    <span class="text-gray-400 line-through text-xs">Rp ${formatPrice(variant.price)}</span>
                </div>`;
        };

        const createVariantRow = (variant, index) => {
            const imageDisplay = variant.image_preview ? 
                createImagePreview(variant.image_preview, variant.name) : 
                createPlaceholderImage();

            const activeClass = variant.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
            const activeText = variant.is_active ? 'Aktif' : 'Nonaktif';

                return `
                    <tr>
                    <td class="px-4 py-4 whitespace-nowrap">${imageDisplay}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${variant.name}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">${variant.sku || '-'}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">${createVariantPriceDisplay(variant)}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">${variant.stock}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <button type="button" onclick="toggleVariantActive(${index})" 
                            class="text-xs px-2 py-1 rounded ${activeClass}">
                            ${activeText}
                            </button>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" onclick="openVariantModal(${index})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Edit</button>
                            <button type="button" onclick="deleteVariant(${index})"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Hapus</button>
                        </td>
                </tr>`;
        };

        const updateVariantsDisplay = () => {
            const hasVariants = state.variants.length > 0;
            
            toggleVisibility(ELEMENTS.variantsList, hasVariants);
            toggleVisibility(ELEMENTS.noVariantsMessage, !hasVariants);

            if (hasVariants && ELEMENTS.variantsTbody) {
                ELEMENTS.variantsTbody.innerHTML = state.variants
                    .map((variant, index) => createVariantRow(variant, index))
                    .join('');
            }
        };

        // ANCHOR: Form Submission
        const prepareVariantsForSubmission = () => {
            return state.variants.map(v => ({
                name: v.name,
                sku: v.sku,
                price: v.price,
                discount_price: v.discount_price,
                stock: v.stock,
                is_active: v.is_active,
                has_image: v.image_file !== null
            }));
        };
            
        const removeOldVariantImageInputs = () => {
            document.querySelectorAll('input[name^="variant_images"]').forEach(input => input.remove());
        };

        const createVariantImageInputs = (form) => {
            return state.variants.reduce((count, variant, index) => {
                if (!variant.image_file) return count;

                try {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(variant.image_file);
                    
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `variant_images[${index}]`;
                    fileInput.files = dataTransfer.files;
                    fileInput.style.display = 'none';
                    
                    form.appendChild(fileInput);
                    return count + 1;
                } catch (error) {
                    return count;
                }
            }, 0);
        };

        const validateRequiredFields = () => {
            return REQUIRED_FIELDS.every(fieldId => {
                const field = getElement(fieldId);
                if (!field) return true;

                const isValid = field.value.trim() !== '';
                field.classList[isValid ? 'remove' : 'add']('border-red-500');
                return isValid;
            });
        };

        const disableSubmitButton = () => {
            if (!ELEMENTS.submitButton) return;

            ELEMENTS.submitButton.disabled = true;
            ELEMENTS.submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            ELEMENTS.submitButton.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...`;
        };

        const enableSubmitButton = () => {
            if (!ELEMENTS.submitButton) return;
            ELEMENTS.submitButton.disabled = false;
            ELEMENTS.submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            ELEMENTS.submitButton.innerHTML = ORIGINAL_BUTTON_TEXT;
        };

        const handleFormSubmit = function(e) {   
            if (state.isSubmitting) {
                e.preventDefault();
                return false;
            }
            
            if (ELEMENTS.variantsJson && state.variants.length > 0) {
                const variantsData = prepareVariantsForSubmission();
                const jsonString = JSON.stringify(variantsData);
                ELEMENTS.variantsJson.value = jsonString;
            }
            removeOldVariantImageInputs();
            createVariantImageInputs(this);

            if (!validateRequiredFields()) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
                return false;
            }

            state.isSubmitting = true;
            disableSubmitButton();

            setTimeout(() => {
                if (state.isSubmitting) {
                    state.isSubmitting = false;
                    enableSubmitButton();
                }
            }, SUBMIT_TIMEOUT);

            return true;
        };

        const handlePageShow = (event) => {
            if (event.persisted) {
                state.isSubmitting = false;
                enableSubmitButton();
            }
        };

        const handleModalOutsideClick = (e) => {
            if (e.target === ELEMENTS.variantModal) {
                closeVariantModal();
            }
        };

        // ANCHOR: Event Listeners
        getElement('main_image')?.addEventListener('change', handleMainImageChange);
        getElement('gallery_images')?.addEventListener('change', handleGalleryImagesChange);
        getElement('variant_image')?.addEventListener('change', handleVariantImageChange);
        ELEMENTS.variantModal?.addEventListener('click', handleModalOutsideClick);
        
        // Form submit event listener with validation
        if (ELEMENTS.form) {
            ELEMENTS.form.addEventListener('submit', handleFormSubmit);
        }
        
        window.addEventListener('pageshow', handlePageShow);
    </script>
@endsection

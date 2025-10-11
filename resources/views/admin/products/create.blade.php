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
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8">
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
                            Gambar Galeri
                        </label>

                        <!-- File Input -->
                        <div class="mb-3">
                            <input type="file" id="gallery_images" name="gallery_images[]" accept=".png,.jpg,.jpeg"
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
        // ANCHOR: Variant Management
        let variants = [];
        let editingVariantIndex = null;

        function openVariantModal(index = null) {
            const modal = document.getElementById('variantModal');
            const modalTitle = document.getElementById('modalTitle');
            
            if (index !== null) {
                // Edit mode
                editingVariantIndex = index;
                const variant = variants[index];
                modalTitle.textContent = 'Edit Variant';
                
                document.getElementById('variant_name').value = variant.name;
                document.getElementById('variant_sku').value = variant.sku || '';
                document.getElementById('variant_price').value = variant.price;
                document.getElementById('variant_discount_price').value = variant.discount_price || '';
                document.getElementById('variant_stock').value = variant.stock;
                document.getElementById('variant_is_active').checked = variant.is_active;
                
                if (variant.image_preview) {
                    document.getElementById('variant_preview_img').src = variant.image_preview;
                    document.getElementById('variant_image_preview').classList.remove('hidden');
                }
            } else {
                // Add mode
                editingVariantIndex = null;
                modalTitle.textContent = 'Tambah Variant';
                clearVariantForm();
            }
            
            modal.classList.remove('hidden');
        }

        function closeVariantModal() {
            document.getElementById('variantModal').classList.add('hidden');
            clearVariantForm();
            editingVariantIndex = null;
        }

        function clearVariantForm() {
            document.getElementById('variant_name').value = '';
            document.getElementById('variant_sku').value = '';
            document.getElementById('variant_price').value = '';
            document.getElementById('variant_discount_price').value = '';
            document.getElementById('variant_stock').value = '';
            document.getElementById('variant_image').value = '';
            document.getElementById('variant_is_active').checked = true;
            document.getElementById('variant_image_preview').classList.add('hidden');
        }

        function saveVariant() {
            const name = document.getElementById('variant_name').value.trim();
            const sku = document.getElementById('variant_sku').value.trim();
            const price = document.getElementById('variant_price').value;
            const discount_price = document.getElementById('variant_discount_price').value;
            const stock = document.getElementById('variant_stock').value;
            const is_active = document.getElementById('variant_is_active').checked;
            const imageFile = document.getElementById('variant_image').files[0];
            
            if (!name || !price || !stock) {
                alert('Nama, Harga, dan Stok wajib diisi!');
                return;
            }

            if (discount_price && parseFloat(discount_price) >= parseFloat(price)) {
                alert('Harga diskon harus lebih kecil dari harga normal!');
                return;
            }

            const variantData = {
                name,
                sku,
                price: parseFloat(price),
                discount_price: discount_price ? parseFloat(discount_price) : null,
                stock: parseInt(stock),
                is_active,
                image_file: imageFile || null,
                image_preview: imageFile ? document.getElementById('variant_preview_img').src : null
            };

            if (editingVariantIndex !== null) {
                // Update existing variant
                variants[editingVariantIndex] = variantData;
            } else {
                // Add new variant
                variants.push(variantData);
            }

            updateVariantsDisplay();
            closeVariantModal();
        }

        function deleteVariant(index) {
            if (confirm('Yakin ingin menghapus variant ini?')) {
                variants.splice(index, 1);
                updateVariantsDisplay();
            }
        }

        function toggleVariantActive(index) {
            variants[index].is_active = !variants[index].is_active;
            updateVariantsDisplay();
        }

        function updateVariantsDisplay() {
            const tbody = document.getElementById('variants-tbody');
            const variantsList = document.getElementById('variants-list');
            const noVariantsMessage = document.getElementById('no-variants-message');
            
            if (variants.length === 0) {
                variantsList.classList.add('hidden');
                noVariantsMessage.classList.remove('hidden');
                return;
            }

            variantsList.classList.remove('hidden');
            noVariantsMessage.classList.add('hidden');

            tbody.innerHTML = variants.map((variant, index) => {
                const hasDiscount = variant.discount_price && variant.discount_price < variant.price;
                const finalPrice = hasDiscount ? variant.discount_price : variant.price;
                const discountPercentage = hasDiscount ? Math.round(((variant.price - variant.discount_price) / variant.price) * 100) : 0;

                return `
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap">
                            ${variant.image_preview ? 
                                `<img src="${variant.image_preview}" alt="${variant.name}" class="h-12 w-12 object-cover rounded">` :
                                `<div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>`
                            }
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${variant.name}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">${variant.sku || '-'}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${hasDiscount ? `
                                <div class="flex flex-col">
                                    <span class="text-red-600 font-medium">Rp ${finalPrice.toLocaleString('id-ID')}</span>
                                    <span class="text-gray-400 line-through text-xs">Rp ${variant.price.toLocaleString('id-ID')}</span>
                                </div>
                            ` : `Rp ${variant.price.toLocaleString('id-ID')}`}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">${variant.stock}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <button type="button" onclick="toggleVariantActive(${index})" 
                                class="text-xs px-2 py-1 rounded ${variant.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                ${variant.is_active ? 'Aktif' : 'Nonaktif'}
                            </button>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" onclick="openVariantModal(${index})"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button type="button" onclick="deleteVariant(${index})"
                                class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Preview variant image on change
        document.getElementById('variant_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('variant_preview_img').src = e.target.result;
                    document.getElementById('variant_image_preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function removeVariantImagePreview() {
            document.getElementById('variant_image').value = '';
            document.getElementById('variant_image_preview').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('variantModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeVariantModal();
            }
        });

        // Before form submit, convert variants to JSON and handle file uploads
        document.querySelector('form').addEventListener('submit', function(e) {
            // Prepare variants data (without image files for JSON)
            const variantsForJson = variants.map(v => ({
                name: v.name,
                sku: v.sku,
                price: v.price,
                discount_price: v.discount_price,
                stock: v.stock,
                is_active: v.is_active,
                has_image: v.image_file !== null
            }));
            
            document.getElementById('variants_json').value = JSON.stringify(variantsForJson);
            
            // Remove old variant image inputs
            document.querySelectorAll('input[name^="variant_images"]').forEach(input => input.remove());
            
            // Create file inputs for variant images and append to form
            variants.forEach((variant, index) => {
                if (variant.image_file) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(variant.image_file);
                    
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `variant_images[${index}]`;
                    fileInput.files = dataTransfer.files;
                    fileInput.style.display = 'none';
                    
                    this.appendChild(fileInput);
                }
            });
        });
    </script>

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
                        removeBtn.className =
                            'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
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
            const requiredFields = ['name', 'category_id', 'price', 'short_description', 'description',
                'main_image'
            ];
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

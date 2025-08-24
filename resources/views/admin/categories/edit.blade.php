@extends('admin.layouts.app')

@section('title', 'Edit Kategori - Admin Panel')

@section('page-title', 'Edit Kategori')
@section('page-description', 'Edit kategori produk')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Kategori</h1>
        <p class="text-gray-600">Edit kategori: {{ $category->name }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<!-- Form Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200">
    <div class="p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm">
            @csrf
            @method('PUT')
            
            <!-- Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama kategori"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nama kategori akan otomatis diubah menjadi slug untuk URL.</p>
            </div>

            <!-- Current Slug -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug Saat Ini
                </label>
                <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    {{ $category->slug }}
                </div>
                <p class="mt-1 text-sm text-gray-500">Slug akan otomatis diperbarui jika nama kategori diubah.</p>
            </div>

            <!-- Preview New Slug -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preview Slug Baru
                </label>
                <div class="w-full px-3 py-2 bg-blue-50 border border-blue-300 rounded-lg text-blue-600" id="slugPreview">
                    {{ $category->slug }}
                </div>
                <p class="mt-1 text-sm text-gray-500">Slug baru akan muncul di sini jika nama kategori diubah.</p>
            </div>

            <!-- Category Info -->
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Informasi Kategori</h4>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p><strong>Jumlah Produk:</strong> {{ $category->products->count() }} produk</p>
                            <p><strong>Dibuat pada:</strong> {{ $category->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $category->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slugPreview');
    const form = document.getElementById('categoryForm');
    const originalName = '{{ $category->name }}';

    // Update slug preview when name changes
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-'); // Remove leading/trailing hyphens
        
        slugPreview.textContent = slug || 'slug-akan-muncul-disini';
        
        // Change background color if slug is different from original
        if (name !== originalName) {
            slugPreview.className = 'w-full px-3 py-2 bg-green-50 border border-green-300 rounded-lg text-green-600';
        } else {
            slugPreview.className = 'w-full px-3 py-2 bg-blue-50 border border-blue-300 rounded-lg text-blue-600';
        }
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Nama kategori harus diisi!');
            nameInput.focus();
            return false;
        }
    });
});
</script>
@endsection

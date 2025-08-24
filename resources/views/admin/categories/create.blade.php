@extends('admin.layouts.app')

@section('title', 'Tambah Kategori - Admin Panel')

@section('page-title', 'Tambah Kategori')
@section('page-description', 'Buat kategori produk baru')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori</h1>
        <p class="text-gray-600">Buat kategori produk baru</p>
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
        <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
            @csrf
            
            <!-- Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama kategori"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nama kategori akan otomatis diubah menjadi slug untuk URL.</p>
            </div>

            <!-- Preview Slug -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preview Slug
                </label>
                <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600" id="slugPreview">
                    slug-akan-muncul-disini
                </div>
                <p class="mt-1 text-sm text-gray-500">Slug akan otomatis dibuat dari nama kategori.</p>
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
                    Simpan Kategori
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

    // Update slug preview when name changes
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-'); // Remove leading/trailing hyphens
        
        slugPreview.textContent = slug || 'slug-akan-muncul-disini';
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

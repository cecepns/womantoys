@extends('admin.layouts.app')

@section('title', 'Edit Kategori Utama - Admin Panel')

@section('page-title', 'Edit Kategori Utama')
@section('page-description', 'Edit kategori utama')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-6 flex-col sm:flex-row gap-4 sm:gap-0">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Kategori Utama</h1>
        <p class="text-gray-600">Edit kategori utama: {{ $mainCategory->name }}</p>
    </div>
    <a href="{{ route('admin.main-categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto text-center">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<!-- Form Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200">
    <div class="p-6">
        <form action="{{ route('admin.main-categories.update', $mainCategory) }}" method="POST" id="mainCategoryForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Main Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori Utama <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $mainCategory->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama kategori utama"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nama kategori utama akan otomatis diubah menjadi slug untuk URL.</p>
            </div>

            <!-- Current Slug -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug Saat Ini
                </label>
                <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    {{ $mainCategory->slug }}
                </div>
                <p class="mt-1 text-sm text-gray-500">Slug akan otomatis diperbarui jika nama kategori utama diubah.</p>
            </div>

            <!-- Preview New Slug -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preview Slug Baru
                </label>
                <div class="w-full px-3 py-2 bg-blue-50 border border-blue-300 rounded-lg text-blue-600" id="slugPreview">
                    {{ $mainCategory->slug }}
                </div>
                <p class="mt-1 text-sm text-gray-500">Slug baru akan muncul di sini jika nama kategori utama diubah.</p>
            </div>

            <!-- Cover Image (optional) -->
            <div class="mb-6">
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Cover (opsional)
                </label>
                <div id="coverPreview" class="mb-3">
                    <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
                    <div class="relative w-full max-w-md">
                        @if($mainCategory->cover_image)
                            <img id="coverPreviewImg" src="{{ asset('storage/' . $mainCategory->cover_image) }}" alt="Cover Kategori Utama" class="w-full object-cover rounded-lg border border-gray-300">
                        @else
                            <div class="w-full h-32 bg-gray-100 rounded-lg border border-gray-300 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                        <!-- Remove Preview Button -->
                        <button type="button" id="removeCoverPreviewBtn" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-1 rounded-full transition-colors duration-200 {{ !$mainCategory->cover_image ? 'hidden' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <input type="file"
                       id="cover_image"
                       name="cover_image"
                       accept="image/jpeg,image/png,image/webp"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah. Maks 2MB.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('admin.main-categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Kategori Utama
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slugPreview');
    const form = document.getElementById('mainCategoryForm');
    const originalName = '{{ $mainCategory->name }}';

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
            alert('Nama kategori utama harus diisi!');
            nameInput.focus();
            return false;
        }
    });

    // Cover image preview
    const coverInput = document.getElementById('cover_image');
    const coverPreviewContainer = document.getElementById('coverPreview');
    let removeCoverPreviewBtn = document.getElementById('removeCoverPreviewBtn');

    coverInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Replace the preview area with new image
                const previewArea = coverPreviewContainer.querySelector('.relative');
                previewArea.innerHTML = `
                    <img id="coverPreviewImg" src="${e.target.result}" alt="Preview Cover" class="w-full object-cover rounded-lg border border-gray-300">
                    <button type="button" id="removeCoverPreviewBtn" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-1 rounded-full transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                // Re-attach event listener to new remove button
                removeCoverPreviewBtn = document.getElementById('removeCoverPreviewBtn');
                removeCoverPreviewBtn.addEventListener('click', removeCoverPreviewHandler);
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove cover preview functionality
    function removeCoverPreviewHandler() {
        const previewArea = coverPreviewContainer.querySelector('.relative');
        previewArea.innerHTML = `
            <div class="w-full h-32 bg-gray-100 rounded-lg border border-gray-300 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm">Tidak ada gambar</p>
                </div>
            </div>
        `;
        coverInput.value = '';
        removeCoverPreviewBtn = null;
    }

    // Attach event listener to initial remove button if it exists
    if (removeCoverPreviewBtn) {
        removeCoverPreviewBtn.addEventListener('click', removeCoverPreviewHandler);
    }
});
</script>
@endsection

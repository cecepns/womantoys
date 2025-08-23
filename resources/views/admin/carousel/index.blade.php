@extends('admin.layouts.app')

@section('title', 'Carousel Management - Admin Panel')

@section('page-title', 'Manajemen Carousel')
@section('page-description', 'Kelola slide carousel untuk homepage')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Carousel</h1>
        <p class="text-gray-600 mt-2">Kelola slide carousel yang ditampilkan di homepage</p>
    </div>
    <a href="/admin/carousel/create" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Slide Baru
    </a>
</div>

<!-- Carousel Slides List -->
<div class="space-y-6">
    <!-- Slide 1 -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <!-- Slide Content -->
            <div class="flex items-center space-x-6 flex-1">
                <!-- Thumbnail Image -->
                <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                    <img 
                        src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                        alt="Carousel Slide 1" 
                        class="w-full h-full object-cover"
                    >
                </div>

                <!-- Slide Information -->
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-2">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Aktif
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            Urutan: 1
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Discover Your Pleasure</h3>
                    <p class="text-gray-600 text-sm mb-2">Premium collection of adult toys for enhanced intimacy</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            CTA Link: /catalog
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Updated: 2 hours ago
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 ml-6">
                <!-- Order Controls -->
                <div class="flex flex-col space-y-1">
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Up">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Down">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Edit Button -->
                <a href="/admin/carousel/1/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Edit
                </a>

                <!-- Delete Button -->
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <!-- Slide Content -->
            <div class="flex items-center space-x-6 flex-1">
                <!-- Thumbnail Image -->
                <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                    <img 
                        src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                        alt="Carousel Slide 2" 
                        class="w-full h-full object-cover"
                    >
                </div>

                <!-- Slide Information -->
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-2">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Aktif
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            Urutan: 2
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Premium Quality Products</h3>
                    <p class="text-gray-600 text-sm mb-2">Curated selection of high-quality intimate products</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            CTA Link: /catalog?category=premium
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Updated: 1 day ago
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 ml-6">
                <!-- Order Controls -->
                <div class="flex flex-col space-y-1">
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Up">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Down">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Edit Button -->
                <a href="/admin/carousel/2/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Edit
                </a>

                <!-- Delete Button -->
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <!-- Slide Content -->
            <div class="flex items-center space-x-6 flex-1">
                <!-- Thumbnail Image -->
                <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                    <img 
                        src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                        alt="Carousel Slide 3" 
                        class="w-full h-full object-cover"
                    >
                </div>

                <!-- Slide Information -->
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-2">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                            Draft
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            Urutan: 3
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Special Offers & Discounts</h3>
                    <p class="text-gray-600 text-sm mb-2">Limited time offers on selected products</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            CTA Link: /catalog?sale=true
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Updated: 3 days ago
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 ml-6">
                <!-- Order Controls -->
                <div class="flex flex-col space-y-1">
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Up">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <button class="p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200" title="Move Down">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Edit Button -->
                <a href="/admin/carousel/3/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Edit
                </a>

                <!-- Delete Button -->
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Empty State (Hidden by default) -->
<div class="hidden bg-white rounded-lg shadow-md border border-gray-200 p-12 text-center">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada slide carousel</h3>
    <p class="text-gray-500 mb-6">Mulai dengan menambahkan slide pertama untuk homepage Anda</p>
    <a href="/admin/carousel/create" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
        Tambah Slide Pertama
    </a>
</div>

<!-- Statistics Section -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Slides</p>
                <p class="text-2xl font-bold text-gray-800">3</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Aktif</p>
                <p class="text-2xl font-bold text-gray-800">2</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Draft</p>
                <p class="text-2xl font-bold text-gray-800">1</p>
            </div>
        </div>
    </div>
</div>

<script>
// Delete confirmation
document.querySelectorAll('button').forEach(button => {
    if (button.textContent.trim() === 'Hapus') {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus slide ini? Tindakan ini tidak dapat dibatalkan.')) {
                // In real app, this would send delete request
                alert('Slide berhasil dihapus!');
                // Remove the slide element from DOM
                this.closest('.bg-white').remove();
            }
        });
    }
});

// Order controls (visual feedback only for demo)
document.querySelectorAll('button[title="Move Up"], button[title="Move Down"]').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const action = this.getAttribute('title') === 'Move Up' ? 'naik' : 'turun';
        alert(`Slide akan dipindahkan ke ${action}`);
    });
});
</script>
@endsection

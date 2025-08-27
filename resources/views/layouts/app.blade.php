<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WomanToys - Mainan Dewasa Premium & Produk Intim')</title>
    @vite('resources/css/app.css')
    
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- Custom Responsive Styles -->
    <style>
        /* Hide scrollbar for category navigation */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Smooth transitions for mobile menu */
        .mobile-menu-transition {
            transition: all 0.3s ease-in-out;
        }
        
        /* Better touch targets for mobile */
        @media (max-width: 768px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-4 py-3 md:py-4">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
                <!-- Logo -->
                <div class="flex items-center w-full md:w-auto justify-between">
                    <a href="/" class="text-xl md:text-2xl font-bold text-pink-600 flex items-center">
                        WomanToys
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="w-full md:flex-1 md:max-w-md md:mx-8">
                    <form action="/catalog" method="GET" class="relative">
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk..." 
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm md:text-base">
                        <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-auto">
                            <svg class="h-4 w-4 text-gray-400 hover:text-pink-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sub Header - Categories -->
    <div class="bg-white border-b border-gray-200 shadow">
        <div class="container mx-auto px-4 py-2 md:py-3">
            <div class="flex overflow-x-auto space-x-4 py-2 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        <a href="/catalog?category={{ $category->slug }}" 
                            class="text-xs text-gray-700 hover:text-pink-600 transition-colors duration-200 whitespace-nowrap font-medium px-3">
                            {{ $category->name }}
                        </a>
                    @endforeach
                @else
                    <span class="text-xs text-gray-500">Tidak ada kategori tersedia</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>



    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-6 md:py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Company Info -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4">WomanToys</h3>
                    <p class="text-gray-300 text-sm md:text-base leading-relaxed">Mainan dewasa premium dan produk intim untuk kesenangan dan kepuasan yang lebih baik.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm md:text-base">Cara Memesan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm md:text-base">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm md:text-base">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Kontak</h4>
                    <div class="text-gray-300 space-y-2">
                        <p class="text-sm md:text-base">Email: info@womantoys.com</p>
                        <p class="text-sm md:text-base">Telepon: (021) 1234-5678</p>
                        <p class="text-sm md:text-base">Alamat: Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-6 md:mt-8 pt-6 md:pt-8 text-center">
                <p class="text-gray-300 text-sm md:text-base">&copy; 2024 WomanToys. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <!-- Ensure jQuery is loaded -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }
    </script>
    
    <!-- Initialize any page-specific scripts -->
    <script>
        // Ensure all scripts are loaded before initializing
        window.addEventListener('load', function() {
            // Trigger any custom events for page-specific scripts
            if (typeof window.initPageScripts === 'function') {
                window.initPageScripts();
            }
        });
        
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    // Add mobile menu functionality here if needed
                    console.log('Mobile menu clicked');
                });
            }
            
            // Search functionality enhancements
            const searchInput = document.querySelector('input[name="search"]');
            const searchForm = document.querySelector('form[action="/catalog"]');
            
            if (searchInput && searchForm) {
                // Auto-submit search after 1 second of no typing
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 2 || this.value.length === 0) {
                            searchForm.submit();
                        }
                    }, 1000);
                });
                
                // Submit on Enter key
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        clearTimeout(searchTimeout);
                        searchForm.submit();
                    }
                });
                
                searchInput.addEventListener('input', function() {
                    clearSearchBtn.style.display = this.value ? 'flex' : 'none';
                });
            }
            
            // Smooth scrolling for category navigation
            const categoryLinks = document.querySelectorAll('a[href*="category"]');
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add smooth scroll behavior if needed
                });
            });
        });
    </script>

</body>
</html>

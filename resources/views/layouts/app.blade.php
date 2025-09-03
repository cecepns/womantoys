<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($storeName ?? 'WomanToys') . ' - Mainan Dewasa Premium & Produk Intim')</title>
    @vite('resources/css/app.css')
    
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- Custom Responsive Styles -->
    <style>
        /* Hide scrollbar for category navigation and gallery */
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
        
        /* Responsive pagination */
        .pagination-wrapper {
            overflow-x: auto;
            padding: 0 1rem;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            min-width: max-content;
        }
        
        .pagination li {
            display: flex;
        }
        
        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            min-width: 2.5rem;
            min-height: 2.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }
        
        .pagination a {
            color: #6b7280;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        
        .pagination a:hover {
            color: #ec4899;
            background-color: #fdf2f8;
            border-color: #fce7f3;
        }
        
        .pagination .active span {
            color: white;
            background-color: #ec4899;
            border-color: #ec4899;
        }
        
        .pagination .disabled span {
            color: #9ca3af;
            background-color: #f3f4f6;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }
        
        @media (max-width: 640px) {
            .pagination a,
            .pagination span {
                padding: 0.375rem 0.5rem;
                min-width: 2rem;
                min-height: 2rem;
                font-size: 0.75rem;
            }
        }
        
        /* Line clamp utility */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Responsive shipping options */
        @media (max-width: 768px) {
            .shipping-option {
                padding: 0.75rem;
            }
            
            .shipping-option .service-info {
                font-size: 0.875rem;
            }
            
            .shipping-option .service-details {
                font-size: 0.75rem;
            }
        }
        
        /* Floating Action Button Styles */
        .fab {
            animation: fab-float 3s ease-in-out infinite;
        }
        
        @keyframes fab-float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        .fab:hover {
            animation: none;
            transform: scale(1.1);
        }
        
        /* Mobile responsive FAB */
        @media (max-width: 768px) {
            .fab {
                width: 3.5rem;
                height: 3.5rem;
            }
            
            .fab svg {
                width: 1.5rem;
                height: 1.5rem;
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
                        {{ $storeName ?? 'WomanToys' }}
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
            <div class="lg:hidden py-1">
                <button id="mobile-menu-btn" type="button" aria-label="Toggle categories menu" aria-expanded="false" aria-controls="categories-container" class="inline-flex items-center justify-center p-2 border border-gray-200 rounded-lg text-gray-600 hover:text-pink-600 hover:border-pink-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <div id="categories-container" class="hidden flex flex-col justify-center lg:flex lg:flex-row lg:flex-nowrap gap-5 lg:gap-3 py-2">
                @if(isset($mainCategories) && $mainCategories->count() > 0)
                    @foreach($mainCategories as $main)
                        <div class="relative group shrink-0 category-item">
                            @if($main->categories && $main->categories->count() > 0)
                                <!-- Main menu dengan dropdown -->
                                <button type="button"
                                       class="text-xs text-gray-700 hover:text-pink-600 transition-colors duration-200 whitespace-nowrap font-medium px-3 py-1 flex items-center gap-1 cursor-pointer main-menu-toggle"
                                       aria-expanded="false"
                                       aria-controls="submenu-{{ $main->id }}">
                                    {{ $main->name }}
                                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-pink-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div id="submenu-{{ $main->id }}" class="submenu-panel hidden w-full lg:w-56 lg:absolute lg:left-0 lg:top-full bg-white lg:border lg:border-gray-200 rounded-md lg:shadow-lg z-30 lg:group-hover:block">
                                    <ul class="py-1 max-h-64 overflow-auto scrollbar-hide">
                                        @foreach($main->categories as $child)
                                            <li>
                                                <a href="{{ route('catalog', array_merge(request()->query(), ['category' => $child->slug])) }}"
                                                   class="block px-4 py-2 text-xs text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <!-- Main menu tanpa sub kategori - bisa diklik untuk ke halaman main category -->
                                <a href="{{ route('catalog', array_merge(request()->query(), ['main' => $main->slug])) }}"
                                   class="text-xs text-gray-700 hover:text-pink-600 transition-colors duration-200 whitespace-nowrap font-medium px-3 py-1">
                                    {{ $main->name }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                @elseif(isset($categories) && $categories->count() > 0)
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

    <!-- Floating Action Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <button class="fab w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group" 
                onclick="openChat()"
                aria-label="Chat dengan kami">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </button>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-6 md:py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Company Info -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4">{{ $storeName ?? 'WomanToys' }}</h3>
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
                        <p class="text-sm md:text-base">Email: <a href="mailto:primemania88@gmail.com" class="text-gray-300 hover:text-white transition-colors duration-200">primemania88@gmail.com</a></p>
                        <p class="text-sm md:text-base">Telepon: +62 822 9759 8899</p>
                        <p class="text-sm md:text-base">Alamat: Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-6 md:mt-8 pt-6 md:pt-8 text-center">
                <p class="text-gray-300 text-sm md:text-base">&copy; 2024 {{ $storeName ?? 'WomanToys' }}. Semua hak dilindungi.</p>
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
                    const container = document.getElementById('categories-container');
                    if (!container) return;
                    const isHidden = container.classList.contains('hidden');
                    if (isHidden) {
                        container.classList.remove('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        container.classList.add('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'false');
                        // Also collapse any open submenus on close
                        document.querySelectorAll('.submenu-panel').forEach(function(panel) {
                            panel.classList.add('hidden');
                        });
                        document.querySelectorAll('.main-menu-toggle[aria-expanded="true"]').forEach(function(btn) {
                            btn.setAttribute('aria-expanded', 'false');
                        });
                    }
                });
            }

            // Close categories menu when clicking outside (mobile only)
            document.addEventListener('click', function(e) {
                const container = document.getElementById('categories-container');
                const toggleBtn = document.getElementById('mobile-menu-btn');
                if (!container || window.innerWidth >= 1024) return;
                const withinMenu = container.contains(e.target);
                const clickedToggle = toggleBtn && toggleBtn.contains(e.target);
                if (!withinMenu && !clickedToggle) {
                    if (!container.classList.contains('hidden')) {
                        container.classList.add('hidden');
                        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
                    }
                    document.querySelectorAll('.submenu-panel').forEach(function(panel) {
                        panel.classList.add('hidden');
                    });
                    document.querySelectorAll('.main-menu-toggle[aria-expanded="true"]').forEach(function(btn) {
                        btn.setAttribute('aria-expanded', 'false');
                    });
                }
            });

            // Close on Escape key (mobile only)
            document.addEventListener('keydown', function(e) {
                if (e.key !== 'Escape' || window.innerWidth >= 1024) return;
                const container = document.getElementById('categories-container');
                const toggleBtn = document.getElementById('mobile-menu-btn');
                if (container && !container.classList.contains('hidden')) {
                    container.classList.add('hidden');
                    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
                }
                document.querySelectorAll('.submenu-panel').forEach(function(panel) {
                    panel.classList.add('hidden');
                });
                document.querySelectorAll('.main-menu-toggle[aria-expanded="true"]').forEach(function(btn) {
                    btn.setAttribute('aria-expanded', 'false');
                });
            });
            
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
            
            // Dynamic hide of overflowing main menu items on lg and above
            let categoriesResizeTimeout;
            function adjustCategoriesLayout() {
                const container = document.getElementById('categories-container');
                if (!container) return;
                const items = Array.from(container.querySelectorAll('.category-item'));
                // Reset all items to visible
                items.forEach(item => { item.style.display = ''; });
                // Only apply logic on lg breakpoint and above (1024px)
                if (window.innerWidth < 1024) return;
                const style = window.getComputedStyle(container);
                const gapPx = parseFloat(style.columnGap || style.gap || '0');
                const containerWidth = container.clientWidth;
                let usedWidth = 0;
                items.forEach((item, index) => {
                    const itemWidth = item.offsetWidth;
                    const addGap = index === 0 ? 0 : gapPx;
                    if (usedWidth + addGap + itemWidth <= containerWidth) {
                        usedWidth += addGap + itemWidth;
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
            // Run on load and on resize (debounced)
            adjustCategoriesLayout();
            window.addEventListener('resize', function() {
                clearTimeout(categoriesResizeTimeout);
                categoriesResizeTimeout = setTimeout(adjustCategoriesLayout, 150);
            });

            // Collapse behavior for vertical (mobile) menu: toggle on click, only < lg
            document.addEventListener('click', function(e) {
                const toggle = e.target.closest('.main-menu-toggle');
                if (!toggle) return;
                // Only enable collapse on small screens
                if (window.innerWidth >= 1024) return;
                const controls = toggle.getAttribute('aria-controls');
                if (!controls) return;
                const panel = document.getElementById(controls);
                if (!panel) return;
                const expanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!expanded));
                if (expanded) {
                    panel.classList.add('hidden');
                } else {
                    panel.classList.remove('hidden');
                }
            });

            // Floating Action Button functionality
            window.openChat = function() {
                // Get WhatsApp settings from PHP
                const whatsappPhone = '{{ \App\Helpers\SettingHelper::getWhatsAppNumber() }}';
                const whatsappText = encodeURIComponent('{{ \App\Helpers\SettingHelper::getWhatsAppMessage() }}');
                const whatsappUrl = `https://api.whatsapp.com/send/?phone=62${whatsappPhone}&text=${whatsappText}&type=phone_number&app_absent=0`;
                
                // Open WhatsApp in new tab
                window.open(whatsappUrl, '_blank');
            };
        });
    </script>

</body>
</html>

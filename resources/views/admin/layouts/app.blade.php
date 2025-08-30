<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin - WomanToys')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @notifyCss
    <!-- Alpine.js (required by Laravel Notify for interactions) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #374151;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 2px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Mobile menu overlay */
        .mobile-menu-overlay {
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <x-notify::notify />
    <div class="flex h-screen">
        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden mobile-menu-overlay"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Sidebar Header -->
            <div class="p-4 md:p-6 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg md:text-xl font-bold">Panel Admin</h1>
                        <p class="text-gray-400 text-xs md:text-sm mt-1">Manajemen WomanToys</p>
                    </div>
                    <!-- Mobile close button -->
                    <button id="close-sidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-4 md:mt-6 flex-1 overflow-y-auto sidebar-scroll">
                <ul class="space-y-1 md:space-y-2 px-2 md:px-0">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            <span class="text-sm md:text-base">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.carousel.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Carousel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.main-categories.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Kategori Utama</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.accounts.index') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span class="text-sm md:text-base">Manajemen Rekening</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.edit') }}" class="flex items-center px-4 md:px-6 py-2 md:py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md mx-2 md:mx-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37A1.724 1.724 0 004.317 14.65c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.607 2.265.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm md:text-base">Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 w-64 p-4 md:p-6 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-pink-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs md:text-sm font-bold">{{ Auth::guard('admin')->user() ? substr(Auth::guard('admin')->user()->name ?? Auth::guard('admin')->user()->email, 0, 1) : 'A' }}</span>
                    </div>
                    <div class="ml-2 md:ml-3 min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-medium truncate">{{ Auth::guard('admin')->user() ? (Auth::guard('admin')->user()->name ?? 'Pengguna Admin') : 'Pengguna Admin' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::guard('admin')->user() ? Auth::guard('admin')->user()->email : 'admin@womantoys.com' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button id="open-sidebar" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-xs md:text-sm text-gray-600">@yield('page-description', 'Selamat datang di panel admin')</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors duration-200">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100">
                <div class="p-4 md:p-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-4 md:mb-6 bg-green-100 border border-green-400 text-green-700 px-3 md:px-4 py-2 md:py-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm md:text-base">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 md:mb-6 bg-red-100 border border-red-400 text-red-700 px-3 md:px-4 py-2 md:py-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm md:text-base">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @notifyJs
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const openButton = document.getElementById('open-sidebar');
            const closeButton = document.getElementById('close-sidebar');
            
            // Open sidebar
            openButton.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
            
            // Close sidebar
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            closeButton.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
            
            // Close sidebar when clicking on navigation links (mobile only)
            const navLinks = sidebar.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) { // lg breakpoint
                        closeSidebar();
                    }
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) { // lg breakpoint
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>

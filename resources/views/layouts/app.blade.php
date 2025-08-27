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
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-pink-600 flex items-center">
                        WomanToys
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-md mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search..." 
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        
                    </div>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-pink-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sub Header - Categories -->
    <div class="bg-white border-b border-gray-200 shadow">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between w-full">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        <a href="/catalog?category={{ $category->slug }}" 
                           class="text-sm text-gray-700 hover:text-pink-600 transition-colors duration-200 whitespace-nowrap font-medium text-center">
                            {{ $category->name }}
                        </a>
                    @endforeach
                @else
                    <span class="text-sm text-gray-500">Tidak ada kategori tersedia (Total: {{ isset($categories) ? $categories->count() : 0 }})</span>
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
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">WomanToys</h3>
                    <p class="text-gray-300">Mainan dewasa premium dan produk intim untuk kesenangan dan kepuasan yang lebih baik.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Cara Memesan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <div class="text-gray-300 space-y-2">
                        <p>Email: info@womantoys.com</p>
                        <p>Telepon: (021) 1234-5678</p>
                        <p>Alamat: Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 WomanToys. Semua hak dilindungi.</p>
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
    </script>

</body>
</html>

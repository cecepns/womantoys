<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'WomanToys - Premium Adult Toys & Intimate Products')</title>
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
                    <a href="/" class="text-2xl font-bold text-pink-600">WomanToys</a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="/catalog" class="text-gray-700 hover:text-pink-600 transition-colors duration-200 font-medium">Collection</a>
                    <a href="#" class="text-gray-700 hover:text-pink-600 transition-colors duration-200 font-medium">About Us</a>
                    <a href="#" class="text-gray-700 hover:text-pink-600 transition-colors duration-200 font-medium">Contact</a>
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

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Age Verification Modal -->
    <x-age-modal />

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">WomanToys</h3>
                    <p class="text-gray-300">Premium adult toys and intimate products for enhanced pleasure and satisfaction.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">How to Order</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Terms & Conditions</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <div class="text-gray-300 space-y-2">
                        <p>Email: info@womantoys.com</p>
                        <p>Phone: (021) 1234-5678</p>
                        <p>Address: Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 WomanToys. All rights reserved.</p>
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

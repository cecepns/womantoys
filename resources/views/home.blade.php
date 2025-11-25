@extends('layouts.app')

@section('title', 'Beranda - ' . ($storeName ?? 'WomanToys'))

@section('content')
    <!-- SECTION: Hero Carousel Section -->
    @if ($carouselSlides && $carouselSlides->count() > 0)
        <div class="relative overflow-hidden">
            <div class="owl-carousel owl-theme hero-carousel" id="heroCarousel">
                @foreach ($carouselSlides as $slide)
                    <div class="item relative">
                        <!-- ANCHOR: Background Image -->
                        <div class="relative">

                            @if ($slide->image_path)
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?: 'Slide Carousel' }}"
                                    class="w-full h-auto"
                                    onerror="console.log('Image failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <!-- ANCHOR: Fallback Background -->
                                <div class="w-full min-h-[400px] bg-gradient-to-br from-pink-400 to-purple-600 flex items-center justify-center"
                                    style="display: none;">
                                    <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @else
                                <div
                                    class="w-full min-h-[400px] bg-gradient-to-br from-pink-400 to-purple-600 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <!-- ANCHOR: Overlay -->
                            <div class="absolute inset-0 bg-black opacity-40"></div>
                        </div>

                        <!-- ANCHOR: Slide Content -->
                        <div class="absolute inset-0 z-10 flex items-center justify-center text-center text-white px-4">
                            <div class="max-w-4xl">
                                @if ($slide->title)
                                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                                        {!! $slide->title !!}
                                    </h1>
                                @endif
                                @if ($slide->description)
                                    <p class="text-xl md:text-2xl mb-8 opacity-90">
                                        {!! $slide->description !!}
                                    </p>
                                @endif
                                @if ($slide->hasCta())
                                    <a href="{{ $slide->cta_link }}"
                                        class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-8 rounded-lg transition-colors duration-200 text-lg">
                                        {{ $slide->cta_text }}
                                    </a>
                                @else
                                    <a href="/catalog"
                                        class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-8 rounded-lg transition-colors duration-200 text-lg">
                                        Lihat Koleksi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- ANCHOR: Fallback Hero Section -->
        <div class="relative h-96 md:h-[500px] overflow-hidden">
            <!-- ANCHOR: Background Image -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80"
                    alt="{{ $storeName ?? 'WomanToys' }} Hero" class="w-full h-full object-cover">
                <!-- ANCHOR: Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>

            <!-- ANCHOR: Hero Content -->
            <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Temukan <span class="text-pink-400">Kesenangan</span> Intim Anda
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 opacity-90">
                        Mainan dewasa premium dan produk intim untuk kepuasan yang lebih baik
                    </p>
                    <a href="/catalog"
                        class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-8 rounded-lg transition-colors duration-200 text-lg">
                        Lihat Koleksi
                    </a>
                </div>
            </div>
        </div>
    @endif
    <!-- !SECTION: Hero Carousel Section -->

    <!-- SECTION: Promotion Section -->
    @if ($promotions && $promotions->count() > 0)
        <div class="bg-white py-16">
            <div class="container mx-auto px-4">
                @php
                    $promotionCount = $promotions->count();
                    $gridClass = 'grid grid-cols-1 gap-8';
                    
                    // Selalu gunakan grid 4 kolom untuk desktop jika lebih dari 4 items
                    if ($promotionCount <= 4) {
                        if ($promotionCount == 1) {
                            $gridClass .= '';
                        } elseif ($promotionCount == 2) {
                            $gridClass .= ' md:grid-cols-2';
                        } elseif ($promotionCount == 3) {
                            $gridClass .= ' md:grid-cols-3';
                        } else {
                            $gridClass .= ' md:grid-cols-4';
                        }
                    } else {
                        $gridClass .= ' md:grid-cols-4';
                    }
                @endphp
                
                <div class="{{ $gridClass }}">
                    @foreach ($promotions as $index => $promotion)
                        @php
                            $itemClass = '';
                            
                            // Jika lebih dari 4 items, hitung col-span untuk baris berikutnya
                            if ($promotionCount > 4) {
                                $itemsPerRow = 4;
                                $currentRow = intval($index / $itemsPerRow);
                                $positionInRow = $index % $itemsPerRow;
                                
                                // Baris pertama: normal (tidak perlu col-span)
                                if ($currentRow == 0) {
                                    $itemClass = '';
                                } else {
                                    // Baris berikutnya: hitung sisa items di baris ini
                                    $itemsInCurrentRow = min($itemsPerRow, $promotionCount - ($currentRow * $itemsPerRow));
                                    
                                    if ($itemsInCurrentRow == 1) {
                                        // 1 item: col-span-4 (full width)
                                        $itemClass = 'md:col-span-4';
                                    } elseif ($itemsInCurrentRow == 2) {
                                        // 2 items: masing-masing col-span-2
                                        $itemClass = 'md:col-span-2';
                                    } elseif ($itemsInCurrentRow == 3) {
                                        // 3 items: distribusi merata (1, 1, 2) - total 4 kolom
                                        if ($positionInRow == 0 || $positionInRow == 1) {
                                            $itemClass = 'md:col-span-1';
                                        } else {
                                            $itemClass = 'md:col-span-2';
                                        }
                                    } else {
                                        // 4 items: normal (tidak perlu col-span)
                                        $itemClass = '';
                                    }
                                }
                            }
                        @endphp
                        
                        <div class="{{ $itemClass }}">
                            @if ($promotion->cta_link)
                                <a href="{{ $promotion->cta_link }}" class="block">
                            @endif
                            
                            <div class="relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                @if ($promotion->isVideo())
                                    <video 
                                        src="{{ $promotion->file_url }}" 
                                        class="w-full h-auto object-cover"
                                        autoplay 
                                        loop 
                                        muted 
                                        playsinline
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    ></video>
                                    <!-- ANCHOR: Fallback Background -->
                                    <div class="w-full min-h-[300px] bg-gradient-to-br from-pink-400 to-purple-600 flex items-center justify-center" style="display: none;">
                                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <img 
                                        src="{{ $promotion->file_url }}" 
                                        alt="Promotion {{ $index + 1 }}"
                                        class="w-full h-auto object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <!-- ANCHOR: Fallback Background -->
                                    <div class="w-full min-h-[300px] bg-gradient-to-br from-pink-400 to-purple-600 flex items-center justify-center" style="display: none;">
                                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            @if ($promotion->cta_link)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Featured Products Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Produk Unggulan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan mainan dewasa paling populer dan premium kami untuk kesenangan yang lebih baik
                </p>
            </div>

            @if ($featuredProducts && $featuredProducts->count() > 0)
                <div class="owl-carousel owl-theme featured-products-carousel" id="featuredProductsCarousel">
                    @foreach ($featuredProducts as $product)
                        <div class="item">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback product cards when no products available -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-500">Produk akan segera tersedia</p>
                </div>
            @endif

            <div class="text-center mt-12">
                <a href="/catalog"
                    class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Belanja Berdasarkan Kategori</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan produk sempurna untuk kebutuhan intim Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if ($categories && $categories->count() > 0)
                    @foreach ($categories->take(3) as $category)
                        <a href="{{ route('catalog') }}?category={{ $category->slug }}" class="group cursor-pointer">
                            <div class="relative overflow-hidden rounded-lg shadow-lg">
                                <img src="{{ $category->cover_image_url }}" alt="{{ $category->name }}"
                                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h3 class="text-2xl font-bold mb-2">{{ $category->name }}</h3>
                                    <p class="text-sm opacity-90">{{ $category->products_count }} produk tersedia</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <!-- Fallback categories when no categories available -->
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kategori</h3>
                        <p class="text-gray-500">Kategori akan segera tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center mx-auto gap-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">Tentang Kami</h2>
                    <div class="text-lg text-gray-600 space-y-4">
                        <p>
                            {{ $storeName ?? 'WomanToys' }} adalah toko online terpercaya yang menyediakan produk dewasa
                            berkualitas tinggi untuk memenuhi kebutuhan intim Anda.
                            Kami berkomitmen untuk memberikan pengalaman berbelanja yang aman, nyaman, dan rahasia.
                        </p>
                        <p>
                            Semua produk kami telah melalui kurasi ketat untuk memastikan kualitas, keamanan, dan kepuasan
                            pelanggan.
                            Dengan pengalaman bertahun-tahun di industri ini, kami memahami pentingnya privasi dan
                            kepercayaan pelanggan.
                        </p>
                        <p>
                            Bergabunglah dengan ribuan pelanggan yang telah mempercayai {{ $storeName ?? 'WomanToys' }}
                            untuk kebutuhan intim mereka.
                            Nikmati pengalaman berbelanja yang menyenangkan dengan layanan pelanggan yang responsif dan
                            pengiriman cepat.
                        </p>
                    </div>
                </div>
                <img src="{{ asset($aboutUsImage) }}" alt="Tentang Kami"
                    class="rounded-lg shadow-lg w-full h-full object-cover" style="min-width:0; min-height:0;">
            </div>
        </div>
    </div>

    <style>
        /* Custom Owl Carousel Styling */
        .hero-carousel .owl-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            pointer-events: none;
        }

        .hero-carousel .owl-nav button {
            position: absolute;
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.5) !important;
            border-radius: 50% !important;
            color: white !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            pointer-events: auto;
        }

        .hero-carousel .owl-nav button:hover {
            background: rgba(0, 0, 0, 0.8) !important;
            transform: scale(1.1);
        }

        .hero-carousel .owl-nav .owl-prev {
            left: 20px;
        }

        .hero-carousel .owl-nav .owl-next {
            right: 20px;
        }

        .hero-carousel .owl-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .hero-carousel .owl-dot {
            width: 12px;
            height: 12px;
            margin: 0 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5) !important;
            transition: all 0.3s ease;
        }

        .hero-carousel .owl-dot.active {
            background: white !important;
            transform: scale(1.2);
        }

        .hero-carousel .owl-dot:hover {
            background: rgba(255, 255, 255, 0.8) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-carousel .owl-nav button {
                width: 40px;
                height: 40px;
            }

            .hero-carousel .owl-nav .owl-prev {
                left: 10px;
            }

            .hero-carousel .owl-nav .owl-next {
                right: 10px;
            }
        }

        /* Featured Products Carousel Styling */
        .featured-products-carousel .item {
            height: 315px !important;
        }

        .featured-products-carousel .owl-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            pointer-events: none;
        }

        .featured-products-carousel .owl-nav button {
            position: absolute;
            width: 45px;
            height: 45px;
            background: rgba(236, 72, 153, 0.8) !important;
            border-radius: 50% !important;
            color: white !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            pointer-events: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .featured-products-carousel .owl-nav button:hover {
            background: rgba(236, 72, 153, 1) !important;
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .featured-products-carousel .owl-nav button.disabled {
            opacity: 0.3 !important;
            cursor: not-allowed !important;
        }

        .featured-products-carousel .owl-nav button.disabled:hover {
            background: rgba(236, 72, 153, 0.3) !important;
            transform: none !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        }

        .featured-products-carousel .owl-nav .owl-prev {
            left: -25px;
        }

        .featured-products-carousel .owl-nav .owl-next {
            right: -25px;
        }

        .featured-products-carousel .owl-nav.disabled {
            display: block;
        }

        .featured-products-carousel .owl-dots {
            text-align: center;
            margin-top: 20px;
        }

        .featured-products-carousel .owl-dot {
            width: 12px;
            height: 12px;
            margin: 0 5px;
            border-radius: 50%;
            background: rgba(236, 72, 153, 0.3) !important;
            transition: all 0.3s ease;
        }

        .featured-products-carousel .owl-dot.active {
            background: rgba(236, 72, 153, 1) !important;
            transform: scale(1.2);
        }

        .featured-products-carousel .owl-dot:hover {
            background: rgba(236, 72, 153, 0.6) !important;
        }


        /* Responsive adjustments for featured products carousel */
        @media (max-width: 768px) {
            .featured-products-carousel .owl-nav button {
                width: 35px;
                height: 35px;
            }

            .featured-products-carousel .owl-nav .owl-prev {
                left: -15px;
            }

            .featured-products-carousel .owl-nav .owl-next {
                right: -15px;
            }
        }
    </style>

    <script>
        // Wait for jQuery to be available
        function initOwlCarousel() {
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
                // Initialize hero carousel
                jQuery('#heroCarousel').owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 0,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    smartSpeed: 1000,
                    navText: [
                        '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
                        '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>'
                    ],
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 1
                        },
                        1024: {
                            items: 1
                        }
                    }
                });

                // Initialize featured products carousel
                jQuery('#featuredProductsCarousel').owlCarousel({
                    items: 5,
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    navText: [
                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            margin: 10
                        },
                        480: {
                            items: 2,
                            margin: 15
                        },
                        768: {
                            items: 3,
                            margin: 20
                        },
                        1024: {
                            items: 5,
                            margin: 20
                        }
                    },
                    onInitialized: function() {
                        // Ensure navigation buttons are always visible
                        var carousel = jQuery('#featuredProductsCarousel');
                        carousel.find('.owl-nav button').show();
                    },
                    onRefreshed: function() {
                        // Ensure navigation buttons are visible on refresh
                        var carousel = jQuery('#featuredProductsCarousel');
                        carousel.find('.owl-nav button').show();
                    }
                });
            } else {
                // Retry after a short delay
                setTimeout(initOwlCarousel, 100);
            }
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initOwlCarousel);
        } else {
            initOwlCarousel();
        }

        // Also try on window load as fallback
        window.addEventListener('load', function() {
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
                // Check if carousels are already initialized
                if (!jQuery('#heroCarousel').hasClass('owl-loaded') || !jQuery('#featuredProductsCarousel')
                    .hasClass('owl-loaded')) {
                    initOwlCarousel();
                }
            }
        });

        // Function to ensure navigation is always visible
        function ensureNavigationVisible() {
            var carousel = jQuery('#featuredProductsCarousel');
            if (carousel.length && carousel.hasClass('owl-loaded')) {
                carousel.find('.owl-nav button').show();
            }
        }

        // Check navigation visibility periodically
        setInterval(ensureNavigationVisible, 2000);
    </script>
@endsection

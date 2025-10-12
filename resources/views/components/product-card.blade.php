@props(['product'])

<a href="{{ route('product-detail', $product->slug) }}" class="block h-full">
    <div
        class="border border-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 bg-white h-full flex flex-col">
        <!-- Product Image -->
        <div class="w-full aspect-square bg-gray-200 overflow-hidden">
            @if ($product->main_image_url)
                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
                    class="w-full h-full object-contain hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm font-medium">Tidak Ada Gambar</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="p-4 flex-grow flex flex-col justify-between">
            <!-- Product Name -->
            <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-2">
                {{ $product->name }}
            </h3>

            <!-- Product Price -->
            <div class="mt-auto">
                @php
                    $activeVariants = $product->variants()->active()->get();
                    $variantCount = $activeVariants->count();
                @endphp

                @if ($variantCount === 0)
                    {{-- No variants: show main product price --}}
                    @if ($product->hasDiscount())
                        <div class="space-y-1">
                            <p class="text-pink-600 font-semibold text-xl">
                                {{ $product->formatted_discount_price }}
                            </p>
                            <div class="flex items-center gap-2">
                                <p class="text-gray-400 text-sm line-through">
                                    {{ $product->formatted_price }}
                                </p>
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            </div>
                        </div>
                    @else
                        <p class="text-pink-600 font-semibold text-xl">
                            {{ $product->formatted_price }}
                        </p>
                    @endif
                @elseif ($variantCount === 1)
                    {{-- One variant: show that variant's price --}}
                    @php
                        $variant = $activeVariants->first();
                    @endphp
                    @if ($variant->hasDiscount())
                        <div class="space-y-1">
                            <p class="text-pink-600 font-semibold text-xl">
                                {{ $variant->formatted_discount_price }}
                            </p>
                            <div class="flex items-center gap-2">
                                <p class="text-gray-400 text-sm line-through">
                                    {{ $variant->formatted_price }}
                                </p>
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                    -{{ $variant->discount_percentage }}%
                                </span>
                            </div>
                        </div>
                    @else
                        <p class="text-pink-600 font-semibold text-xl">
                            {{ $variant->formatted_price }}
                        </p>
                    @endif
                @else
                    {{-- Multiple variants: show lowest price --}}
                    @php
                        $lowestPriceVariant = $activeVariants->sortBy('final_price')->first();
                    @endphp
                    @if ($lowestPriceVariant->hasDiscount())
                        <div class="space-y-1">
                            <p class="text-pink-600 font-semibold text-xl">
                                Mulai dari {{ $lowestPriceVariant->formatted_discount_price }}
                            </p>
                            <div class="flex items-center gap-2">
                                <p class="text-gray-400 text-sm line-through">
                                    {{ $lowestPriceVariant->formatted_price }}
                                </p>
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                    -{{ $lowestPriceVariant->discount_percentage }}%
                                </span>
                            </div>
                        </div>
                    @else
                        <p class="text-pink-600 font-semibold text-xl">
                            Mulai dari {{ $lowestPriceVariant->formatted_price }}
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</a>

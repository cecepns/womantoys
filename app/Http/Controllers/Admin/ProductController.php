<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\ProductImage;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * ANCHOR: Display a listing of the products with filtering and search.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }

        // Get products with pagination
        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get categories for filter dropdown
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * ANCHOR: Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * ANCHOR: Store a newly created product in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        // Generate request token for deduplication
        $requestToken = $this->generateRequestToken($request);
        $lockKey = 'product_create_' . $requestToken;

        //Check if this request is already being processed
        if (Cache::has($lockKey)) {
            notify()->warning('Permintaan sedang diproses. Mohon tunggu.', 'Peringatan');
            return redirect()->back();
        }

        // Lock this request for 2 minutes
        Cache::put($lockKey, true, 120);

        $imageService = new ImageUploadService();
        $product = null;

        DB::beginTransaction();
        
        try {
            // Check memory usage before starting
            $this->checkMemoryUsage();

            // Upload main image with validation
            $mainImagePath = null;
            if ($request->hasFile('main_image')) {
                $mainImagePath = $imageService->upload($request->file('main_image'), 'products');
                Log::info('Main image uploaded', ['path' => $mainImagePath]);
            }

            // Prepare product data
            $productData = $request->except(['main_image', 'gallery_images', 'variants_json', 'variant_images']);
            $productData['main_image'] = $mainImagePath;
            $productData['is_featured'] = $request->boolean('is_featured');

            // Create product
            $product = Product::create($productData);
            Log::info('Product created', ['id' => $product->id, 'name' => $product->name]);

            // Check database connection before continuing
            $this->checkDatabaseConnection();

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                $this->uploadGalleryImages($request, $product, $imageService);
            }

            // Handle variants creation
            if ($request->filled('variants_json')) {
                Log::info('Processing variants', [
                    'variants_json' => $request->variants_json,
                    'has_variant_images' => $request->hasFile('variant_images'),
                    'variant_images_count' => $request->file('variant_images') ? count($request->file('variant_images')) : 0
                ]);
                
                $this->createProductVariants($request, $product, $imageService);
            } else {
                Log::info('No variants to process', ['variants_json_filled' => $request->filled('variants_json')]);
            }

            // Everything succeeded - commit and clear tracking
            DB::commit();
            $imageService->clearTracking();
            Cache::forget($lockKey);

            Log::info('Product created successfully', [
                'product_id' => $product->id,
                'uploaded_files' => count($imageService->getUploadedFiles())
            ]);

            notify()->success('Produk berhasil ditambahkan.', 'Berhasil');
            return redirect()->route('admin.products.index');

        } catch (\InvalidArgumentException $e) {
            // Validation error from ImageUploadService
            DB::rollBack();
            $imageService->cleanup();
            Cache::forget($lockKey);

            Log::warning('Product creation failed - validation error', [
                'error' => $e->getMessage(),
                'product_id' => $product?->id
            ]);

            notify()->error($e->getMessage(), 'Validasi Gagal');
            return redirect()->back()->withInput();

        } catch (\PDOException $e) {
            // Database error
            DB::rollBack();
            $imageService->cleanup();
            Cache::forget($lockKey);

            Log::error('Product creation failed - database error', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'product_id' => $product?->id
            ]);

            notify()->error('Terjadi kesalahan pada database. Silakan coba lagi atau hubungi administrator.', 'Error Database');
            return redirect()->back()->withInput();

        } catch (\Exception $e) {
            // Generic error
            DB::rollBack();
            $imageService->cleanup();
            Cache::forget($lockKey);

            Log::error('Product creation failed - general error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $product?->id,
                'uploaded_files_cleaned' => count($imageService->getUploadedFiles())
            ]);

            notify()->error('Gagal menambahkan produk. Silakan coba lagi.', 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * ANCHOR: Upload gallery images for product
     */
    private function uploadGalleryImages(ProductStoreRequest $request, Product $product, ImageUploadService $imageService): void
    {
        $galleryImages = $request->file('gallery_images');
        $order = 1;

        foreach ($galleryImages as $image) {
            // Check memory before each upload
            $this->checkMemoryUsage();

            $imagePath = $imageService->upload($image, 'products');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'order' => $order++
            ]);

            Log::info('Gallery image uploaded', [
                'product_id' => $product->id,
                'path' => $imagePath,
                'order' => $order - 1
            ]);
        }
    }

    /**
     * ANCHOR: Create product variants with images
     */
    private function createProductVariants(ProductStoreRequest $request, Product $product, ImageUploadService $imageService): void
    {
        $variants = json_decode($request->variants_json, true);

        // This should never happen because of validation, but double check
        if (!is_array($variants) || count($variants) === 0) {
            throw new \Exception('Invalid variants data');
        }

        // Get variant images array
        $variantImages = $request->file('variant_images', []);

        foreach ($variants as $index => $variantData) {
            // Check memory before each variant
            $this->checkMemoryUsage();

            $variantImagePath = null;

            // Handle variant image upload - access as array
            if (isset($variantImages[$index]) && $variantImages[$index] instanceof \Illuminate\Http\UploadedFile) {
                $variantImagePath = $imageService->upload(
                    $variantImages[$index],
                    'products/variants'
                );
                
                Log::info('Variant image uploaded', [
                    'product_id' => $product->id,
                    'variant_index' => $index,
                    'path' => $variantImagePath
                ]);
            }

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'name' => $variantData['name'],
                'sku' => $variantData['sku'] ?? null,
                'price' => $variantData['price'],
                'discount_price' => $variantData['discount_price'] ?? null,
                'stock' => $variantData['stock'],
                'image' => $variantImagePath,
                'is_active' => $variantData['is_active'] ?? true,
                'order' => $index + 1,
            ]);

            Log::info('Product variant created', [
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'name' => $variant->name,
                'has_image' => $variantImagePath !== null
            ]);
        }
    }

    /**
     * ANCHOR: Check memory usage to prevent memory exhaustion
     */
    private function checkMemoryUsage(): void
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = $this->convertToBytes($memoryLimit);

        // Warn if using more than 80% of memory
        if ($memoryUsage > ($memoryLimitBytes * 0.8)) {
            Log::warning('High memory usage detected', [
                'usage' => round($memoryUsage / 1024 / 1024, 2) . 'MB',
                'limit' => $memoryLimit,
                'percentage' => round(($memoryUsage / $memoryLimitBytes) * 100, 2) . '%'
            ]);

            throw new \Exception('Memory limit approaching. Please reduce image count or size.');
        }
    }

    /**
     * ANCHOR: Convert PHP memory limit to bytes
     */
    private function convertToBytes(string $value): int
    {
        $unit = strtolower(substr($value, -1));
        $numericValue = (int) $value;

        switch ($unit) {
            case 'g':
                $numericValue *= 1024;
                // fall through
            case 'm':
                $numericValue *= 1024;
                // fall through
            case 'k':
                $numericValue *= 1024;
        }

        return $numericValue;
    }

    /**
     * ANCHOR: Check database connection is still alive
     */
    private function checkDatabaseConnection(): void
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Log::error('Database connection lost', ['error' => $e->getMessage()]);
            throw new \PDOException('Database connection lost. Please try again.');
        }
    }

    /**
     * ANCHOR: Generate unique request token for deduplication
     */
    private function generateRequestToken(ProductStoreRequest $request): string
    {
        $data = $request->except(['_token', 'main_image', 'gallery_images', 'variant_images']);
        return md5($request->input('_token') . json_encode($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        // Debug request data
        Log::info('Request data received: ' . json_encode($request->all()));
        Log::info('Files in request: ' . json_encode($request->allFiles()));
        Log::info('Main image file: ' . ($request->hasFile('main_image') ? 'Present' : 'Not present'));
        Log::info('Gallery images files: ' . ($request->hasFile('gallery_images') ? 'Present' : 'Not present'));
        Log::info('Removed gallery images: ' . json_encode($request->input('removed_gallery_images', [])));

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'specifications' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,draft,out_of_stock',
            'is_featured' => 'nullable|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'gallery_images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4',
        ], [
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
        ]);

        // Prepare update data
        $updateData = $request->except(['main_image', 'gallery_images', 'remove_main_image']);

        // Ensure is_featured is properly cast to boolean
        $updateData['is_featured'] = $request->boolean('is_featured');

        $product->update($updateData);

        // Handle remove main image flag
        if ($request->boolean('remove_main_image')) {
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }
            $product->update(['main_image' => null]);
        }

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('products', 'public');
            $product->update(['main_image' => $imagePath]);
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $request->file('gallery_images');
            $maxOrder = $product->images()->max('order') ?? 0;
            $order = $maxOrder + 1;

            foreach ($galleryImages as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'order' => $order++
                ]);
            }
        }

        // Handle removal of existing gallery images
        if ($request->has('removed_gallery_images')) {
            Log::info('Removing gallery images: ' . json_encode($request->removed_gallery_images));

            foreach ($request->removed_gallery_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    try {
                        // Check if file exists before trying to delete it
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                            Log::info("File deleted for image ID: {$imageId}");
                        } else {
                            Log::info("File not found for image ID: {$imageId} (path: {$image->image_path}) - continuing with database cleanup");
                        }

                        // Always delete the database record regardless of file existence
                        $image->delete();
                        Log::info("Successfully removed image ID: {$imageId} from database");
                    } catch (\Exception $e) {
                        Log::error("Failed to remove image ID: {$imageId}", ['error' => $e->getMessage()]);

                        // Even if file deletion fails, try to delete the database record
                        try {
                            $image->delete();
                            Log::info("Database record deleted for image ID: {$imageId} despite file deletion error");
                        } catch (\Exception $dbError) {
                            Log::error("Failed to delete database record for image ID: {$imageId}", ['error' => $dbError->getMessage()]);
                        }
                    }
                } else {
                    Log::warning("Image ID not found: {$imageId}");
                }
            }
        }

        notify()->success('Produk berhasil diperbarui.', 'Berhasil');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete main image from storage if exists
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
                Log::info("Main image deleted for product ID: {$product->id}");
            }

            // Delete gallery images from storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                    Log::info("Gallery image file deleted for image ID: {$image->id}");
                } else {
                    Log::info("Gallery image file not found for image ID: {$image->id} - continuing with cleanup");
                }
            }

            $product->delete();
            Log::info("Product deleted successfully: {$product->id}");

            notify()->success('Produk berhasil dihapus.', 'Berhasil');
            return back();
        } catch (\Exception $e) {
            Log::error("Failed to delete product ID: {$product->id}", ['error' => $e->getMessage()]);

            notify()->error('Gagal menghapus produk. Silakan coba lagi.', 'Gagal');
            return back();
        }
    }

    /**
     * Remove a specific gallery image.
     */
    public function removeGalleryImage(Request $request, Product $product, ProductImage $image)
    {
        // Ensure the image belongs to the provided product
        if ($image->product_id !== $product->id) {
            return response()->json(['success' => false, 'error' => 'Image does not belong to product'], 422);
        }

        try {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
                Log::info("File deleted for image ID: {$image->id}");
            } else {
                Log::info("File not found for image ID: {$image->id} (path: {$image->image_path}) - continuing with database cleanup");
            }

            $image->delete();
            Log::info("Successfully removed image ID: {$image->id} from database");

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Failed to remove image ID: {$image->id}", ['error' => $e->getMessage()]);

            try {
                $image->delete();
                Log::info("Database record deleted for image ID: {$image->id} despite file deletion error");
                return response()->json(['success' => true]);
            } catch (\Exception $dbError) {
                Log::error("Failed to delete database record for image ID: {$image->id}", ['error' => $dbError->getMessage()]);
                return response()->json(['success' => false, 'error' => $dbError->getMessage()], 500);
            }
        }
    }
}

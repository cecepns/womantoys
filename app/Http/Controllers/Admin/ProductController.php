<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'specifications' => 'required|string',
            'care_instructions' => 'required|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,draft,out_of_stock',
            'is_featured' => 'nullable|boolean',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ], [
            'main_image.required' => 'Gambar utama wajib diupload.',
            'main_image.image' => 'File harus berupa gambar.',
            'main_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'gallery_images.*.image' => 'File galeri harus berupa gambar.',
            'gallery_images.*.mimes' => 'Format gambar galeri harus JPEG, PNG, JPG, atau GIF.',
        ]);

        // Handle main image upload first
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('products', 'public');
        }

        // Create product with main image
        $productData = $request->except(['main_image', 'gallery_images']);
        $productData['main_image'] = $mainImagePath;
        
        // Ensure is_featured is properly cast to boolean
        $productData['is_featured'] = $request->boolean('is_featured');
        
        $product = Product::create($productData);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $request->file('gallery_images');
            $order = 1;
            
            foreach ($galleryImages as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'order' => $order++
                ]);
            }
        }

        // Handle removal of existing gallery images (for edit mode)
        if ($request->has('removed_gallery_images')) {
            foreach ($request->removed_gallery_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    \Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        notify()->success('Produk berhasil ditambahkan.', 'Berhasil');
        return redirect()->route('admin.products.index');
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
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        // Debug request data
        \Log::info('Request data received: ' . json_encode($request->all()));
        \Log::info('Files in request: ' . json_encode($request->allFiles()));
        \Log::info('Main image file: ' . ($request->hasFile('main_image') ? 'Present' : 'Not present'));
        \Log::info('Gallery images files: ' . ($request->hasFile('gallery_images') ? 'Present' : 'Not present'));
        \Log::info('Removed gallery images: ' . json_encode($request->input('removed_gallery_images', [])));

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'specifications' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,draft,out_of_stock',
            'is_featured' => 'nullable|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Prepare update data
        $updateData = $request->except(['main_image', 'gallery_images', 'remove_main_image']);
        
        // Ensure is_featured is properly cast to boolean
        $updateData['is_featured'] = $request->boolean('is_featured');
        
        $product->update($updateData);

        // Handle remove main image flag
        if ($request->boolean('remove_main_image')) {
            if ($product->main_image && \Storage::disk('public')->exists($product->main_image)) {
                \Storage::disk('public')->delete($product->main_image);
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
            \Log::info('Removing gallery images: ' . json_encode($request->removed_gallery_images));
            
            foreach ($request->removed_gallery_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    try {
                        // Check if file exists before trying to delete it
                        if (\Storage::disk('public')->exists($image->image_path)) {
                            \Storage::disk('public')->delete($image->image_path);
                            \Log::info("File deleted for image ID: {$imageId}");
                        } else {
                            \Log::info("File not found for image ID: {$imageId} (path: {$image->image_path}) - continuing with database cleanup");
                        }
                        
                        // Always delete the database record regardless of file existence
                        $image->delete();
                        \Log::info("Successfully removed image ID: {$imageId} from database");
                        
                    } catch (\Exception $e) {
                        \Log::error("Failed to remove image ID: {$imageId}", ['error' => $e->getMessage()]);
                        
                        // Even if file deletion fails, try to delete the database record
                        try {
                            $image->delete();
                            \Log::info("Database record deleted for image ID: {$imageId} despite file deletion error");
                        } catch (\Exception $dbError) {
                            \Log::error("Failed to delete database record for image ID: {$imageId}", ['error' => $dbError->getMessage()]);
                        }
                    }
                } else {
                    \Log::warning("Image ID not found: {$imageId}");
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
            if ($product->main_image && \Storage::disk('public')->exists($product->main_image)) {
                \Storage::disk('public')->delete($product->main_image);
                \Log::info("Main image deleted for product ID: {$product->id}");
            }
            
            // Delete gallery images from storage
            foreach ($product->images as $image) {
                if (\Storage::disk('public')->exists($image->image_path)) {
                    \Storage::disk('public')->delete($image->image_path);
                    \Log::info("Gallery image file deleted for image ID: {$image->id}");
                } else {
                    \Log::info("Gallery image file not found for image ID: {$image->id} - continuing with cleanup");
                }
            }
            
            $product->delete();
            \Log::info("Product deleted successfully: {$product->id}");

            notify()->success('Produk berhasil dihapus.', 'Berhasil');
            return back();
                
        } catch (\Exception $e) {
            \Log::error("Failed to delete product ID: {$product->id}", ['error' => $e->getMessage()]);
            
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
            if (\Storage::disk('public')->exists($image->image_path)) {
                \Storage::disk('public')->delete($image->image_path);
                \Log::info("File deleted for image ID: {$image->id}");
            } else {
                \Log::info("File not found for image ID: {$image->id} (path: {$image->image_path}) - continuing with database cleanup");
            }

            $image->delete();
            \Log::info("Successfully removed image ID: {$image->id} from database");

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error("Failed to remove image ID: {$image->id}", ['error' => $e->getMessage()]);

            try {
                $image->delete();
                \Log::info("Database record deleted for image ID: {$image->id} despite file deletion error");
                return response()->json(['success' => true]);
            } catch (\Exception $dbError) {
                \Log::error("Failed to delete database record for image ID: {$image->id}", ['error' => $dbError->getMessage()]);
                return response()->json(['success' => false, 'error' => $dbError->getMessage()], 500);
            }
        }
    }
}

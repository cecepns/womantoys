<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * ANCHOR: Store a newly created variant in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products/variants', 'public');
        }

        // Get the highest order value for this product
        $maxOrder = $product->variants()->max('order') ?? 0;

        // Create variant
        $variant = $product->variants()->create([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active', true),
            'order' => $maxOrder + 1,
        ]);

        notify()->success('Variant berhasil ditambahkan.', 'Berhasil');
        
        return redirect()->back();
    }

    /**
     * ANCHOR: Update the specified variant in storage.
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to this product
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:product_variants,sku,' . $variant->id,
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'remove_image' => 'nullable|boolean',
        ], [
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
        ]);

        // Prepare update data
        $updateData = [
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $updateData['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $updateData['image'] = $request->file('image')->store('products/variants', 'public');
        }

        $variant->update($updateData);

        notify()->success('Variant berhasil diupdate.', 'Berhasil');
        
        return redirect()->back();
    }

    /**
     * ANCHOR: Remove the specified variant from storage.
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to this product
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        // Check if variant has orders
        if ($variant->orderItems()->count() > 0) {
            notify()->error('Tidak dapat menghapus variant yang sudah memiliki order.', 'Error');
            return redirect()->back();
        }

        // Delete image if exists
        if ($variant->image) {
            Storage::disk('public')->delete($variant->image);
        }

        $variant->delete();

        notify()->success('Variant berhasil dihapus.', 'Berhasil');
        
        return redirect()->back();
    }

    /**
     * ANCHOR: Update the order of variants.
     */
    public function updateOrder(Request $request, Product $product)
    {
        $request->validate([
            'variants' => 'required|array',
            'variants.*' => 'exists:product_variants,id',
        ]);

        foreach ($request->variants as $index => $variantId) {
            $variant = ProductVariant::find($variantId);
            if ($variant && $variant->product_id === $product->id) {
                $variant->update(['order' => $index + 1]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * ANCHOR: Toggle active status of a variant.
     */
    public function toggleActive(Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to this product
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $variant->update(['is_active' => !$variant->is_active]);

        $status = $variant->is_active ? 'diaktifkan' : 'dinonaktifkan';
        notify()->success("Variant berhasil {$status}.", 'Berhasil');
        
        return redirect()->back();
    }
}

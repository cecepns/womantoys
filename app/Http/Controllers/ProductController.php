<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Load the product with its relationships
        $product->load(['category', 'images']);
        
        // Get related products from the same category
        $relatedProducts = Product::with(['category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();
        
        return view('product-detail', compact('product', 'relatedProducts'));
    }
}

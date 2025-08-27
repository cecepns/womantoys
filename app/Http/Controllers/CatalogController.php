<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->active()
            ->inStock();

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Get products with pagination
        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get all categories for filter
        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])->get();

        return view('catalog', compact('products', 'categories'));
    }
}

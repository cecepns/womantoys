<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * ANCHOR: Display catalog page with filtering and search functionality.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->active()
            ->inStock();

        // Filter by main category
        if ($request->has('main') && $request->main !== 'all') {
            $query->whereHas('category.mainCategory', function ($q) use ($request) {
                $q->where('slug', $request->main);
            });
        }

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

        // Sorting functionality
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get products with pagination
        $products = $query->paginate(12)
            ->withQueryString();

        // Get main categories for filter bar
        $mainCategories = MainCategory::orderBy('name', 'asc')->get();

        // Get categories (sub categories) for filter, optionally scoped by selected main
        $categoriesQuery = Category::withCount(['products' => function ($productsQuery) {
            $productsQuery->active()->inStock();
        }])->orderBy('name', 'asc');

        if ($request->has('main') && $request->main !== 'all') {
            $categoriesQuery->whereHas('mainCategory', function ($q) use ($request) {
                $q->where('slug', $request->main);
            });
        }

        $categories = $categoriesQuery->get();

        return view('catalog', compact('products', 'categories', 'mainCategories'));
    }
}

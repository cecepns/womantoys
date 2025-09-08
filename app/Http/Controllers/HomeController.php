<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carouselSlides = CarouselSlide::orderBy('order', 'asc')->get();

        $featuredProducts = Product::with(['category'])
            ->active()
            ->inStock()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])->withCoverImage()->inRandomOrder()->limit(3)->get();

        // Get about us image from settings and generate proper URL
        $aboutUsImagePath = SettingHelper::getAboutUsImage();
        $aboutUsImage = $this->generateImageUrl($aboutUsImagePath);

        // Get store name for title
        $storeName = SettingHelper::getStoreName();

        return view('home', compact(
            'carouselSlides',
            'featuredProducts',
            'categories',
            'aboutUsImage',
            'storeName'
        ));
    }

    /**
     * Generate proper URL for image based on path type
     */
    private function generateImageUrl(string $imagePath): string
    {
        // If it's a public images path (starts with 'images/')
        if (str_starts_with($imagePath, 'images/')) {
            return asset($imagePath);
        }

        // If it's a storage path (starts with 'about-us/' or other storage paths)
        return asset('storage/' . $imagePath);
    }
}

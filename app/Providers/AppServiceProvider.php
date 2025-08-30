<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\MainCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories data with app layout
        View::composer('layouts.app', function ($view) {
            // Keep popular categories (if used elsewhere)
            $categories = Category::withCount(['products' => function ($query) {
                $query->active()->inStock();
            }])
            ->orderBy('products_count', 'desc')
            ->limit(12)
            ->get();

            // Main categories with their sub categories
            $mainCategories = MainCategory::with(['categories' => function ($q) {
                $q->orderBy('name', 'asc');
            }])->orderBy('name', 'asc')->get();
            
            $view->with(compact('categories', 'mainCategories'));
        });
    }
}

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
            
            // Get store name from settings
            $storeName = \App\Helpers\SettingHelper::getStoreName();
            
            $view->with(compact('categories', 'mainCategories', 'storeName'));
        });

        // View Composer for admin layouts
        View::composer('admin.layouts.app', function ($view) {
            $storeName = \App\Helpers\SettingHelper::getStoreName();
            $view->with(compact('storeName'));
        });

        // View Composer for admin login page
        View::composer('admin.login', function ($view) {
            $storeName = \App\Helpers\SettingHelper::getStoreName();
            $view->with(compact('storeName'));
        });

        // View Composer for all views that might need store_name
        View::composer(['home', 'catalog', 'product-detail', 'checkout', 'payment-instruction'], function ($view) {
            $storeName = \App\Helpers\SettingHelper::getStoreName();
            $view->with(compact('storeName'));
        });
    }
}

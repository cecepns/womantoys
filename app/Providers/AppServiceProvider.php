<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
            $categories = Category::withCount(['products' => function ($query) {
                $query->active()->inStock();
            }])->withCoverImage()->get();
            
            $view->with('categories', $categories);
        });
    }
}

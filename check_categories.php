<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

echo "=== Category Check ===\n";
echo "Total categories in database: " . Category::count() . "\n";
echo "Categories with cover image: " . Category::whereNotNull('cover_image')->where('cover_image', '!=', '')->count() . "\n";
echo "Categories without cover image: " . Category::where(function($query) {
    $query->whereNull('cover_image')->orWhere('cover_image', '');
})->count() . "\n";

echo "\n=== All Categories ===\n";
$categories = Category::all();
foreach ($categories as $category) {
    echo "- " . $category->name . " (cover_image: " . ($category->cover_image ?: 'none') . ")\n";
}

echo "\n=== Categories that would show in sub header ===\n";
$categories = Category::withCount(['products' => function ($query) {
    $query->where('status', 'active')->where('stock', '>', 0);
}])->get();

foreach ($categories as $category) {
    echo "- " . $category->name . " (products: " . $category->products_count . ")\n";
}

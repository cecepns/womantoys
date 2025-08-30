<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateFeaturedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update first 4 active products to be featured
        $products = Product::active()->inStock()->take(4)->get();
        
        foreach ($products as $product) {
            $product->update(['is_featured' => true]);
        }
        
        $this->command->info('Updated ' . $products->count() . ' products to featured status.');
    }
}

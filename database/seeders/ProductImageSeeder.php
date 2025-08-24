<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductImage;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get product IDs
        $leloSona = Product::where('name', 'Lelo Sona Cruise 2')->first();
        $premiumVibrator = Product::where('name', 'Premium Vibrator Deluxe')->first();
        $couplesSet = Product::where('name', 'Couples Massager Set')->first();
        $powerRing = Product::where('name', 'Executive Power Ring')->first();

        $productImages = [
            // Lelo Sona Cruise 2 - Additional Images
            [
                'product_id' => $leloSona->id,
                'image_path' => 'products/lelo-sona-cruise-2-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $leloSona->id,
                'image_path' => 'products/lelo-sona-cruise-2-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $leloSona->id,
                'image_path' => 'products/lelo-sona-cruise-2-3.jpg',
                'order' => 3,
            ],

            // Premium Vibrator Deluxe - Additional Images
            [
                'product_id' => $premiumVibrator->id,
                'image_path' => 'products/premium-vibrator-deluxe-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $premiumVibrator->id,
                'image_path' => 'products/premium-vibrator-deluxe-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $premiumVibrator->id,
                'image_path' => 'products/premium-vibrator-deluxe-3.jpg',
                'order' => 3,
            ],

            // Couples Massager Set - Additional Images
            [
                'product_id' => $couplesSet->id,
                'image_path' => 'products/couples-massager-set-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $couplesSet->id,
                'image_path' => 'products/couples-massager-set-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $couplesSet->id,
                'image_path' => 'products/couples-massager-set-3.jpg',
                'order' => 3,
            ],
            [
                'product_id' => $couplesSet->id,
                'image_path' => 'products/couples-massager-set-4.jpg',
                'order' => 4,
            ],

            // Executive Power Ring - Additional Images
            [
                'product_id' => $powerRing->id,
                'image_path' => 'products/executive-power-ring-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $powerRing->id,
                'image_path' => 'products/executive-power-ring-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $powerRing->id,
                'image_path' => 'products/executive-power-ring-3.jpg',
                'order' => 3,
            ],
        ];

        foreach ($productImages as $image) {
            ProductImage::create($image);
        }
    }
}

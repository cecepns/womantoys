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
        $satisfyerPro2 = Product::where('name', 'Satisfyer Pro 2')->first();
        $magicWand = Product::where('name', 'Magic Wand Original')->first();
        $weVibeTango = Product::where('name', 'We-Vibe Tango X')->first();
        $leloGigi = Product::where('name', 'Lelo Gigi 2')->first();
        $womanizerPremium = Product::where('name', 'Womanizer Premium')->first();
        $fleshlightStamina = Product::where('name', 'Fleshlight Stamina Training Unit')->first();
        $tengaEgg = Product::where('name', 'Tenga Egg')->first();
        $hotOctopuss = Product::where('name', 'Hot Octopuss Pulse III')->first();
        $cobraLibre = Product::where('name', 'Cobra Libre II')->first();
        $weVibeSync = Product::where('name', 'We-Vibe Sync')->first();
        $leloTiani = Product::where('name', 'Lelo Tiani 3')->first();
        $satisfyerPartner = Product::where('name', 'Satisfyer Partner Multifun')->first();
        $lovehoneyDesire = Product::where('name', 'Lovehoney Desire Luxury')->first();
        $doxyDieCast = Product::where('name', 'Doxy Die Cast')->first();

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

            // Satisfyer Pro 2 - Additional Images
            [
                'product_id' => $satisfyerPro2->id,
                'image_path' => 'products/satisfyer-pro-2-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $satisfyerPro2->id,
                'image_path' => 'products/satisfyer-pro-2-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $satisfyerPro2->id,
                'image_path' => 'products/satisfyer-pro-2-3.jpg',
                'order' => 3,
            ],

            // Magic Wand Original - Additional Images
            [
                'product_id' => $magicWand->id,
                'image_path' => 'products/magic-wand-original-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $magicWand->id,
                'image_path' => 'products/magic-wand-original-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $magicWand->id,
                'image_path' => 'products/magic-wand-original-3.jpg',
                'order' => 3,
            ],

            // We-Vibe Tango X - Additional Images
            [
                'product_id' => $weVibeTango->id,
                'image_path' => 'products/we-vibe-tango-x-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $weVibeTango->id,
                'image_path' => 'products/we-vibe-tango-x-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $weVibeTango->id,
                'image_path' => 'products/we-vibe-tango-x-3.jpg',
                'order' => 3,
            ],

            // Lelo Gigi 2 - Additional Images
            [
                'product_id' => $leloGigi->id,
                'image_path' => 'products/lelo-gigi-2-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $leloGigi->id,
                'image_path' => 'products/lelo-gigi-2-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $leloGigi->id,
                'image_path' => 'products/lelo-gigi-2-3.jpg',
                'order' => 3,
            ],

            // Womanizer Premium - Additional Images
            [
                'product_id' => $womanizerPremium->id,
                'image_path' => 'products/womanizer-premium-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $womanizerPremium->id,
                'image_path' => 'products/womanizer-premium-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $womanizerPremium->id,
                'image_path' => 'products/womanizer-premium-3.jpg',
                'order' => 3,
            ],

            // Fleshlight Stamina Training Unit - Additional Images
            [
                'product_id' => $fleshlightStamina->id,
                'image_path' => 'products/fleshlight-stamina-training-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $fleshlightStamina->id,
                'image_path' => 'products/fleshlight-stamina-training-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $fleshlightStamina->id,
                'image_path' => 'products/fleshlight-stamina-training-3.jpg',
                'order' => 3,
            ],

            // Tenga Egg - Additional Images
            [
                'product_id' => $tengaEgg->id,
                'image_path' => 'products/tenga-egg-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $tengaEgg->id,
                'image_path' => 'products/tenga-egg-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $tengaEgg->id,
                'image_path' => 'products/tenga-egg-3.jpg',
                'order' => 3,
            ],

            // Hot Octopuss Pulse III - Additional Images
            [
                'product_id' => $hotOctopuss->id,
                'image_path' => 'products/hot-octopuss-pulse-iii-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $hotOctopuss->id,
                'image_path' => 'products/hot-octopuss-pulse-iii-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $hotOctopuss->id,
                'image_path' => 'products/hot-octopuss-pulse-iii-3.jpg',
                'order' => 3,
            ],

            // Cobra Libre II - Additional Images
            [
                'product_id' => $cobraLibre->id,
                'image_path' => 'products/cobra-libre-ii-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $cobraLibre->id,
                'image_path' => 'products/cobra-libre-ii-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $cobraLibre->id,
                'image_path' => 'products/cobra-libre-ii-3.jpg',
                'order' => 3,
            ],

            // We-Vibe Sync - Additional Images
            [
                'product_id' => $weVibeSync->id,
                'image_path' => 'products/we-vibe-sync-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $weVibeSync->id,
                'image_path' => 'products/we-vibe-sync-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $weVibeSync->id,
                'image_path' => 'products/we-vibe-sync-3.jpg',
                'order' => 3,
            ],

            // Lelo Tiani 3 - Additional Images
            [
                'product_id' => $leloTiani->id,
                'image_path' => 'products/lelo-tiani-3-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $leloTiani->id,
                'image_path' => 'products/lelo-tiani-3-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $leloTiani->id,
                'image_path' => 'products/lelo-tiani-3-3.jpg',
                'order' => 3,
            ],

            // Satisfyer Partner Multifun - Additional Images
            [
                'product_id' => $satisfyerPartner->id,
                'image_path' => 'products/satisfyer-partner-multifun-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $satisfyerPartner->id,
                'image_path' => 'products/satisfyer-partner-multifun-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $satisfyerPartner->id,
                'image_path' => 'products/satisfyer-partner-multifun-3.jpg',
                'order' => 3,
            ],

            // Lovehoney Desire Luxury - Additional Images
            [
                'product_id' => $lovehoneyDesire->id,
                'image_path' => 'products/lovehoney-desire-luxury-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $lovehoneyDesire->id,
                'image_path' => 'products/lovehoney-desire-luxury-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $lovehoneyDesire->id,
                'image_path' => 'products/lovehoney-desire-luxury-3.jpg',
                'order' => 3,
            ],

            // Doxy Die Cast - Additional Images
            [
                'product_id' => $doxyDieCast->id,
                'image_path' => 'products/doxy-die-cast-1.jpg',
                'order' => 1,
            ],
            [
                'product_id' => $doxyDieCast->id,
                'image_path' => 'products/doxy-die-cast-2.jpg',
                'order' => 2,
            ],
            [
                'product_id' => $doxyDieCast->id,
                'image_path' => 'products/doxy-die-cast-3.jpg',
                'order' => 3,
            ],
        ];

        foreach ($productImages as $image) {
            ProductImage::create($image);
        }
    }
}

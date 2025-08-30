<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MainCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get main category IDs
        $mainanWanita = MainCategory::where('name', 'Mainan Wanita')->first();
        $mainanPria = MainCategory::where('name', 'Mainan Pria')->first();
        $mainanPasangan = MainCategory::where('name', 'Mainan Pasangan')->first();
        $aksesorisPelumas = MainCategory::where('name', 'Aksesoris & Pelumas')->first();
        $kostumLingerie = MainCategory::where('name', 'Kostum & Lingerie')->first();
        $suplemenVitamin = MainCategory::where('name', 'Suplemen & Vitamin')->first();
        $mainanBdsm = MainCategory::where('name', 'Mainan BDSM')->first();
        $mainanEksotis = MainCategory::where('name', 'Mainan Eksotis')->first();

        $categories = [
            // Mainan Wanita
            [
                'name' => 'Vibrator',
                'slug' => 'vibrator',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Dildo',
                'slug' => 'dildo',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Mainan Anal',
                'slug' => 'mainan-anal',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Mainan Remote Control',
                'slug' => 'mainan-remote-control',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Mainan Waterproof',
                'slug' => 'mainan-waterproof',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Mainan Rechargeable',
                'slug' => 'mainan-rechargeable',
                'main_category_id' => $mainanWanita->id,
            ],

            // Mainan Pria
            [
                'name' => 'Alat Bantu Pria',
                'slug' => 'alat-bantu-pria',
                'main_category_id' => $mainanPria->id,
            ],
            [
                'name' => 'Ring Penguat',
                'slug' => 'ring-penguat',
                'main_category_id' => $mainanPria->id,
            ],

            // Mainan Pasangan
            [
                'name' => 'Untuk Pasangan',
                'slug' => 'untuk-pasangan',
                'main_category_id' => $mainanPasangan->id,
            ],

            // Aksesoris & Pelumas
            [
                'name' => 'Pelumas',
                'slug' => 'pelumas',
                'main_category_id' => $aksesorisPelumas->id,
            ],
            [
                'name' => 'Kondom',
                'slug' => 'kondom',
                'main_category_id' => $aksesorisPelumas->id,
            ],
            [
                'name' => 'Aksesoris Dewasa',
                'slug' => 'aksesoris-dewasa',
                'main_category_id' => $aksesorisPelumas->id,
            ],
            [
                'name' => 'Produk Perawatan Intim',
                'slug' => 'produk-perawatan-intim',
                'main_category_id' => $aksesorisPelumas->id,
            ],

            // Kostum & Lingerie
            [
                'name' => 'Kostum & Lingerie',
                'slug' => 'kostum-lingerie',
                'main_category_id' => $kostumLingerie->id,
            ],

            // Suplemen & Vitamin
            [
                'name' => 'Suplemen & Vitamin',
                'slug' => 'suplemen-vitamin',
                'main_category_id' => $suplemenVitamin->id,
            ],

            // Mainan BDSM
            [
                'name' => 'Mainan BDSM',
                'slug' => 'mainan-bdsm',
                'main_category_id' => $mainanBdsm->id,
            ],

            // Mainan Eksotis
            [
                'name' => 'Mainan Eksotis',
                'slug' => 'mainan-eksotis',
                'main_category_id' => $mainanEksotis->id,
            ],
            [
                'name' => 'Bundle Package',
                'slug' => 'bundle-package',
                'main_category_id' => $mainanEksotis->id,
            ],

            // Kategori umum (untuk kompatibilitas)
            [
                'name' => 'Untuk Wanita',
                'slug' => 'untuk-wanita',
                'main_category_id' => $mainanWanita->id,
            ],
            [
                'name' => 'Untuk Pria',
                'slug' => 'untuk-pria',
                'main_category_id' => $mainanPria->id,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']], // Cek berdasarkan slug
                $category // Data yang akan dibuat jika tidak ada
            );
        }
    }
}

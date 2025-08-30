<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainCategory;

class MainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainCategories = [
            [
                'name' => 'Mainan Wanita',
                'slug' => 'mainan-wanita',
            ],
            [
                'name' => 'Mainan Pria',
                'slug' => 'mainan-pria',
            ],
            [
                'name' => 'Mainan Pasangan',
                'slug' => 'mainan-pasangan',
            ],
            [
                'name' => 'Aksesoris & Pelumas',
                'slug' => 'aksesoris-pelumas',
            ],
            [
                'name' => 'Kostum & Lingerie',
                'slug' => 'kostum-lingerie',
            ],
            [
                'name' => 'Suplemen & Vitamin',
                'slug' => 'suplemen-vitamin',
            ],
            [
                'name' => 'Mainan BDSM',
                'slug' => 'mainan-bdsm',
            ],
            [
                'name' => 'Mainan Eksotis',
                'slug' => 'mainan-eksotis',
            ],
        ];

        foreach ($mainCategories as $mainCategory) {
            MainCategory::firstOrCreate(
                ['slug' => $mainCategory['slug']], // Cek berdasarkan slug
                $mainCategory // Data yang akan dibuat jika tidak ada
            );
        }
    }
}

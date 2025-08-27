<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Untuk Wanita',
                'slug' => 'untuk-wanita',
            ],
            [
                'name' => 'Untuk Pria',
                'slug' => 'untuk-pria',
            ],
            [
                'name' => 'Untuk Pasangan',
                'slug' => 'untuk-pasangan',
            ],
            [
                'name' => 'Vibrator',
                'slug' => 'vibrator',
            ],
            [
                'name' => 'Dildo',
                'slug' => 'dildo',
            ],
            [
                'name' => 'Mainan Anal',
                'slug' => 'mainan-anal',
            ],
            [
                'name' => 'Ring Penguat',
                'slug' => 'ring-penguat',
            ],
            [
                'name' => 'Pelumas',
                'slug' => 'pelumas',
            ],
            [
                'name' => 'Kondom',
                'slug' => 'kondom',
            ],
            [
                'name' => 'Mainan BDSM',
                'slug' => 'mainan-bdsm',
            ],
            [
                'name' => 'Kostum & Lingerie',
                'slug' => 'kostum-lingerie',
            ],
            [
                'name' => 'Alat Bantu Pria',
                'slug' => 'alat-bantu-pria',
            ],
            [
                'name' => 'Mainan Remote Control',
                'slug' => 'mainan-remote-control',
            ],
            [
                'name' => 'Mainan Waterproof',
                'slug' => 'mainan-waterproof',
            ],
            [
                'name' => 'Mainan Rechargeable',
                'slug' => 'mainan-rechargeable',
            ],
            [
                'name' => 'Suplemen & Vitamin',
                'slug' => 'suplemen-vitamin',
            ],
            [
                'name' => 'Aksesoris Dewasa',
                'slug' => 'aksesoris-dewasa',
            ],
            [
                'name' => 'Produk Perawatan Intim',
                'slug' => 'produk-perawatan-intim',
            ],
            [
                'name' => 'Mainan Eksotis',
                'slug' => 'mainan-eksotis',
            ],
            [
                'name' => 'Bundle Package',
                'slug' => 'bundle-package',
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

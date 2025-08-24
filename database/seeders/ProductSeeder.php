<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $womenCategory = Category::where('name', 'Untuk Wanita')->first();
        $menCategory = Category::where('name', 'Untuk Pria')->first();
        $couplesCategory = Category::where('name', 'Untuk Pasangan')->first();

        $products = [
            [
                'category_id' => $womenCategory->id,
                'name' => 'Lelo Sona Cruise 2',
                'slug' => 'lelo-sona-cruise-2',
                'short_description' => 'Premium sonic wave massager',
                'description' => 'Lelo Sona Cruise 2 adalah massager premium yang menggunakan teknologi sonic wave untuk memberikan pengalaman yang luar biasa. Dirancang dengan ergonomis dan memiliki 12 pola getaran yang berbeda untuk memenuhi berbagai preferensi.',
                'specifications' => json_encode([
                    'Bahan' => 'Medical-grade silicone',
                    'Ukuran' => '12.5 x 3.5 cm',
                    'Berat' => '115 gram',
                    'Baterai' => 'Rechargeable lithium-ion',
                    'Durasi Penggunaan' => 'Hingga 2 jam',
                    'Pola Getaran' => '12 pola berbeda',
                    'Waterproof' => 'IPX7 (submersible)',
                    'Charging Time' => '2 jam untuk pengisian penuh'
                ]),
                'care_instructions' => json_encode([
                    'Pembersihan' => 'Bersihkan dengan sabun lembut dan air hangat setelah setiap penggunaan',
                    'Penyimpanan' => 'Simpan di tempat yang kering dan sejuk',
                    'Charging' => 'Gunakan charger yang disediakan, jangan overcharge',
                    'Maintenance' => 'Periksa secara berkala untuk kerusakan atau retak'
                ]),
                'price' => 1500000,
                'main_image' => 'products/lelo-sona-cruise-2.jpg',
                'status' => 'active',
                'stock' => 15,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Premium Vibrator Deluxe',
                'slug' => 'premium-vibrator-deluxe',
                'short_description' => 'High-quality vibrator with multiple settings',
                'description' => 'Premium Vibrator Deluxe menawarkan kualitas terbaik dengan desain yang elegan dan fitur yang lengkap. Dilengkapi dengan berbagai pola getaran dan intensitas yang dapat disesuaikan untuk pengalaman yang optimal.',
                'specifications' => json_encode([
                    'Bahan' => 'Body-safe silicone',
                    'Ukuran' => '15 x 4 cm',
                    'Berat' => '180 gram',
                    'Baterai' => 'AA batteries (2 pcs)',
                    'Durasi Penggunaan' => 'Hingga 3 jam',
                    'Pola Getaran' => '8 pola berbeda',
                    'Waterproof' => 'IPX6 (splash proof)',
                    'Intensitas' => '10 level intensitas'
                ]),
                'care_instructions' => json_encode([
                    'Pembersihan' => 'Bersihkan dengan sabun antibakteri dan air hangat',
                    'Penyimpanan' => 'Simpan dalam pouch yang disediakan',
                    'Baterai' => 'Ganti baterai secara berkala untuk performa optimal',
                    'Maintenance' => 'Jangan gunakan jika ada kerusakan pada casing'
                ]),
                'price' => 850000,
                'main_image' => 'products/premium-vibrator-deluxe.jpg',
                'status' => 'active',
                'stock' => 8,
            ],
            [
                'category_id' => $couplesCategory->id,
                'name' => 'Couples Massager Set',
                'slug' => 'couples-massager-set',
                'short_description' => 'Complete set for intimate couples play',
                'description' => 'Couples Massager Set adalah paket lengkap yang dirancang khusus untuk pasangan. Set ini mencakup berbagai alat yang dapat digunakan bersama untuk meningkatkan keintiman dan kenikmatan pasangan.',
                'specifications' => json_encode([
                    'Kandungan Set' => '3 massager, 1 ring, 1 remote control',
                    'Bahan' => 'Medical-grade silicone dan ABS plastic',
                    'Ukuran' => 'Berbagai ukuran untuk setiap item',
                    'Berat Total' => '450 gram',
                    'Baterai' => 'Rechargeable dan AAA batteries',
                    'Durasi Penggunaan' => 'Hingga 4 jam',
                    'Pola Getaran' => '15 pola berbeda',
                    'Waterproof' => 'IPX7 (submersible)',
                    'Remote Control' => 'Wireless dengan jangkauan 10 meter'
                ]),
                'care_instructions' => json_encode([
                    'Pembersihan' => 'Bersihkan setiap item secara terpisah dengan sabun lembut',
                    'Penyimpanan' => 'Simpan dalam box yang disediakan',
                    'Charging' => 'Charge semua item sebelum penggunaan pertama',
                    'Maintenance' => 'Periksa koneksi remote control secara berkala'
                ]),
                'price' => 2100000,
                'main_image' => 'products/couples-massager-set.jpg',
                'status' => 'draft',
                'stock' => 0,
            ],
            [
                'category_id' => $menCategory->id,
                'name' => 'Executive Power Ring',
                'slug' => 'executive-power-ring',
                'short_description' => 'Premium ring with enhanced features',
                'description' => 'Executive Power Ring adalah cincin premium yang dirancang untuk meningkatkan performa dan kenikmatan. Dilengkapi dengan teknologi vibrasi yang dapat disesuaikan dan bahan berkualitas tinggi.',
                'specifications' => json_encode([
                    'Bahan' => 'Medical-grade silicone dan stainless steel',
                    'Ukuran' => 'Diameter 5.5 cm (adjustable)',
                    'Berat' => '85 gram',
                    'Baterai' => 'Rechargeable lithium-ion',
                    'Durasi Penggunaan' => 'Hingga 1.5 jam',
                    'Pola Getaran' => '6 pola berbeda',
                    'Waterproof' => 'IPX7 (submersible)',
                    'Adjustable' => 'Ya, dapat disesuaikan ukurannya',
                    'Intensitas' => '8 level intensitas'
                ]),
                'care_instructions' => json_encode([
                    'Pembersihan' => 'Bersihkan dengan sabun antibakteri dan air hangat',
                    'Penyimpanan' => 'Simpan dalam pouch yang disediakan',
                    'Charging' => 'Charge sebelum penggunaan pertama',
                    'Maintenance' => 'Periksa elastisitas ring secara berkala'
                ]),
                'price' => 650000,
                'main_image' => 'products/executive-power-ring.jpg',
                'status' => 'out_of_stock',
                'stock' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

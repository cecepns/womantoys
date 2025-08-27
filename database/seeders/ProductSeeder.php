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
                'specifications' => 'Bahan: Medical-grade silicone
Ukuran: 12.5 x 3.5 cm
Berat: 115 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 2 jam
Pola Getaran: 12 pola berbeda
Waterproof: IPX7 (submersible)
Charging Time: 2 jam untuk pengisian penuh',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun lembut dan air hangat setelah setiap penggunaan
Penyimpanan: Simpan di tempat yang kering dan sejuk
Charging: Gunakan charger yang disediakan, jangan overcharge
Maintenance: Periksa secara berkala untuk kerusakan atau retak',
                'price' => 1500000,
                'main_image' => 'products/lelo-sona-cruise-2.jpg',
                'status' => 'active',
                'stock' => 15,
                'weight' => 115,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Premium Vibrator Deluxe',
                'slug' => 'premium-vibrator-deluxe',
                'short_description' => 'High-quality vibrator with multiple settings',
                'description' => 'Premium Vibrator Deluxe menawarkan kualitas terbaik dengan desain yang elegan dan fitur yang lengkap. Dilengkapi dengan berbagai pola getaran dan intensitas yang dapat disesuaikan untuk pengalaman yang optimal.',
                'specifications' => 'Bahan: Body-safe silicone
Ukuran: 15 x 4 cm
Berat: 180 gram
Baterai: AA batteries (2 pcs)
Durasi Penggunaan: Hingga 3 jam
Pola Getaran: 8 pola berbeda
Waterproof: IPX6 (splash proof)
Intensitas: 10 level intensitas',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Baterai: Ganti baterai secara berkala untuk performa optimal
Maintenance: Jangan gunakan jika ada kerusakan pada casing',
                'price' => 850000,
                'main_image' => 'products/premium-vibrator-deluxe.jpg',
                'status' => 'active',
                'stock' => 8,
                'weight' => 180,
            ],
            [
                'category_id' => $couplesCategory->id,
                'name' => 'Couples Massager Set',
                'slug' => 'couples-massager-set',
                'short_description' => 'Complete set for intimate couples play',
                'description' => 'Couples Massager Set adalah paket lengkap yang dirancang khusus untuk pasangan. Set ini mencakup berbagai alat yang dapat digunakan bersama untuk meningkatkan keintiman dan kenikmatan pasangan.',
                'specifications' => 'Kandungan Set: 3 massager, 1 ring, 1 remote control
Bahan: Medical-grade silicone dan ABS plastic
Ukuran: Berbagai ukuran untuk setiap item
Berat Total: 450 gram
Baterai: Rechargeable dan AAA batteries
Durasi Penggunaan: Hingga 4 jam
Pola Getaran: 15 pola berbeda
Waterproof: IPX7 (submersible)
Remote Control: Wireless dengan jangkauan 10 meter',
                'care_instructions' => 'Pembersihan: Bersihkan setiap item secara terpisah dengan sabun lembut
Penyimpanan: Simpan dalam box yang disediakan
Charging: Charge semua item sebelum penggunaan pertama
Maintenance: Periksa koneksi remote control secara berkala',
                'price' => 2100000,
                'main_image' => 'products/couples-massager-set.jpg',
                'status' => 'draft',
                'stock' => 0,
                'weight' => 450,
            ],
            [
                'category_id' => $menCategory->id,
                'name' => 'Executive Power Ring',
                'slug' => 'executive-power-ring',
                'short_description' => 'Premium ring with enhanced features',
                'description' => 'Executive Power Ring adalah cincin premium yang dirancang untuk meningkatkan performa dan kenikmatan. Dilengkapi dengan teknologi vibrasi yang dapat disesuaikan dan bahan berkualitas tinggi.',
                'specifications' => 'Bahan: Medical-grade silicone dan stainless steel
Ukuran: Diameter 5.5 cm (adjustable)
Berat: 85 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 1.5 jam
Pola Getaran: 6 pola berbeda
Waterproof: IPX7 (submersible)
Adjustable: Ya, dapat disesuaikan ukurannya
Intensitas: 8 level intensitas',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Charge sebelum penggunaan pertama
Maintenance: Periksa elastisitas ring secara berkala',
                'price' => 650000,
                'main_image' => 'products/executive-power-ring.jpg',
                'status' => 'out_of_stock',
                'stock' => 0,
                'weight' => 85,
            ],
            // Produk baru - Untuk Wanita
            [
                'category_id' => $womenCategory->id,
                'name' => 'Satisfyer Pro 2',
                'slug' => 'satisfyer-pro-2',
                'short_description' => 'Revolutionary air pulse technology',
                'description' => 'Satisfyer Pro 2 menggunakan teknologi air pulse yang revolusioner untuk memberikan stimulasi yang unik dan intens. Dirancang dengan ergonomis dan memiliki 11 level intensitas yang dapat disesuaikan.',
                'specifications' => 'Bahan: Body-safe silicone dan ABS plastic
Ukuran: 13.5 x 4.5 cm
Berat: 95 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 3 jam
Level Intensitas: 11 level berbeda
Waterproof: IPX7 (submersible)
Charging Time: 1.5 jam untuk pengisian penuh',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun lembut dan air hangat
Penyimpanan: Simpan di tempat yang kering dan sejuk
Charging: Gunakan charger yang disediakan
Maintenance: Periksa nozzle secara berkala',
                'price' => 1200000,
                'main_image' => 'products/satisfyer-pro-2.jpg',
                'status' => 'active',
                'stock' => 12,
                'weight' => 95,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Magic Wand Original',
                'slug' => 'magic-wand-original',
                'short_description' => 'Classic powerful massager',
                'description' => 'Magic Wand Original adalah massager klasik yang telah teruji selama puluhan tahun. Memberikan getaran yang kuat dan konsisten untuk pengalaman yang memuaskan.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 30 x 6 cm
Berat: 540 gram
Power: AC powered (120V)
Durasi Penggunaan: Unlimited (AC powered)
Level Intensitas: 2 level (low/high)
Cord Length: 2.4 meter
Noise Level: Low vibration noise',
                'care_instructions' => 'Pembersihan: Bersihkan head dengan sabun antibakteri
Penyimpanan: Simpan di tempat yang kering
Power: Pastikan voltage sesuai dengan standar lokal
Maintenance: Periksa kabel secara berkala',
                'price' => 950000,
                'main_image' => 'products/magic-wand-original.jpg',
                'status' => 'active',
                'stock' => 6,
                'weight' => 540,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'We-Vibe Tango X',
                'slug' => 'we-vibe-tango-x',
                'short_description' => 'Ultra-powerful bullet vibrator',
                'description' => 'We-Vibe Tango X adalah bullet vibrator ultra-kuat dengan desain yang compact dan diskrit. Dilengkapi dengan motor yang bertenaga dan berbagai pola getaran.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 8.5 x 2.5 cm
Berat: 45 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 2 jam
Pola Getaran: 8 pola berbeda
Waterproof: IPX7 (submersible)
Charging Time: 1.5 jam untuk pengisian penuh',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan magnetic charger yang disediakan
Maintenance: Periksa koneksi charger secara berkala',
                'price' => 1100000,
                'main_image' => 'products/we-vibe-tango-x.jpg',
                'status' => 'active',
                'stock' => 18,
                'weight' => 45,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Lelo Gigi 2',
                'slug' => 'lelo-gigi-2',
                'short_description' => 'Elegant G-spot massager',
                'description' => 'Lelo Gigi 2 adalah massager G-spot yang elegan dengan desain yang ergonomis. Dirancang khusus untuk stimulasi G-spot dengan berbagai pola getaran.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 18 x 3.5 cm
Berat: 140 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 4 jam
Pola Getaran: 6 pola berbeda
Waterproof: IPX7 (submersible)
Charging Time: 2 jam untuk pengisian penuh',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun lembut dan air hangat
Penyimpanan: Simpan di tempat yang kering dan sejuk
Charging: Gunakan charger yang disediakan
Maintenance: Periksa secara berkala untuk kerusakan',
                'price' => 1350000,
                'main_image' => 'products/lelo-gigi-2.jpg',
                'status' => 'active',
                'stock' => 9,
                'weight' => 140,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Womanizer Premium',
                'slug' => 'womanizer-premium',
                'short_description' => 'Premium air pulse stimulator',
                'description' => 'Womanizer Premium menggunakan teknologi air pulse yang canggih untuk memberikan stimulasi yang unik dan intens. Dilengkapi dengan fitur auto-pilot dan smart silence.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 13.5 x 4.5 cm
Berat: 120 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 4 jam
Level Intensitas: 12 level berbeda
Waterproof: IPX7 (submersible)
Smart Silence: Auto-stop saat tidak digunakan',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun lembut dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan magnetic charger yang disediakan
Maintenance: Periksa nozzle secara berkala',
                'price' => 1800000,
                'main_image' => 'products/womanizer-premium.jpg',
                'status' => 'active',
                'stock' => 7,
                'weight' => 120,
            ],
            // Produk baru - Untuk Pria
            [
                'category_id' => $menCategory->id,
                'name' => 'Fleshlight Stamina Training Unit',
                'slug' => 'fleshlight-stamina-training-unit',
                'short_description' => 'Training unit for stamina improvement',
                'description' => 'Fleshlight Stamina Training Unit dirancang khusus untuk melatih stamina dan kontrol. Menggunakan material yang realistis dan dapat disesuaikan intensitasnya.',
                'specifications' => 'Bahan: SuperSkin material (patented)
Ukuran: 22 x 8 cm
Berat: 450 gram
Case: ABS plastic case
Cleaning: Easy to clean design
Storage: Includes storage case
Realistic: Highly realistic texture
Training: Stamina training focused',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam case yang disediakan
Drying: Keringkan dengan handuk bersih
Maintenance: Gunakan renewing powder secara berkala',
                'price' => 750000,
                'main_image' => 'products/fleshlight-stamina-training.jpg',
                'status' => 'active',
                'stock' => 14,
                'weight' => 450,
            ],
            [
                'category_id' => $menCategory->id,
                'name' => 'Tenga Egg',
                'slug' => 'tenga-egg',
                'short_description' => 'Disposable pleasure egg',
                'description' => 'Tenga Egg adalah pleasure egg sekali pakai yang praktis dan diskrit. Menggunakan material yang lembut dan dapat digunakan untuk stimulasi manual.',
                'specifications' => 'Bahan: TPE (Thermoplastic Elastomer)
Ukuran: 8 x 4 cm (expanded)
Berat: 25 gram
Usage: Single use disposable
Texture: Soft and stretchy
Packaging: Individual sealed package
Discrete: Egg-shaped design
Portable: Compact and travel-friendly',
                'care_instructions' => 'Usage: Untuk sekali pakai saja
Disposal: Buang setelah penggunaan
Storage: Simpan di tempat yang kering
Safety: Jangan gunakan jika kemasan rusak',
                'price' => 45000,
                'main_image' => 'products/tenga-egg.jpg',
                'status' => 'active',
                'stock' => 50,
                'weight' => 25,
            ],
            [
                'category_id' => $menCategory->id,
                'name' => 'Hot Octopuss Pulse III',
                'slug' => 'hot-octopuss-pulse-iii',
                'short_description' => 'Revolutionary male vibrator',
                'description' => 'Hot Octopuss Pulse III menggunakan teknologi pulse plate yang revolusioner untuk stimulasi yang unik dan intens. Dirancang untuk memberikan pengalaman yang berbeda dari vibrator tradisional.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 18 x 8 cm
Berat: 280 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 2 jam
Pola Getaran: 10 pola berbeda
Waterproof: IPX7 (submersible)
Technology: Pulse plate technology',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan charger yang disediakan
Maintenance: Periksa pulse plate secara berkala',
                'price' => 1400000,
                'main_image' => 'products/hot-octopuss-pulse-iii.jpg',
                'status' => 'active',
                'stock' => 5,
                'weight' => 280,
            ],
            [
                'category_id' => $menCategory->id,
                'name' => 'Cobra Libre II',
                'slug' => 'cobra-libre-ii',
                'short_description' => 'Hands-free male stimulator',
                'description' => 'Cobra Libre II adalah stimulator pria hands-free yang dirancang untuk memberikan stimulasi yang intens dan memuaskan. Menggunakan teknologi vibrasi yang canggih.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 15 x 7 cm
Berat: 220 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 1.5 jam
Pola Getaran: 6 pola berbeda
Waterproof: IPX7 (submersible)
Hands-free: Designed for hands-free use',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan charger yang disediakan
Maintenance: Periksa secara berkala untuk kerusakan',
                'price' => 1200000,
                'main_image' => 'products/cobra-libre-ii.jpg',
                'status' => 'draft',
                'stock' => 0,
                'weight' => 220,
            ],
            // Produk baru - Untuk Pasangan
            [
                'category_id' => $couplesCategory->id,
                'name' => 'We-Vibe Sync',
                'slug' => 'we-vibe-sync',
                'short_description' => 'Adjustable couples vibrator',
                'description' => 'We-Vibe Sync adalah vibrator pasangan yang dapat disesuaikan ukurannya. Dirancang untuk stimulasi internal dan eksternal secara bersamaan, memberikan pengalaman yang menyenangkan untuk kedua pasangan.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: Adjustable length (7-9 cm)
Berat: 85 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 2 jam
Pola Getaran: 10 pola berbeda
Waterproof: IPX7 (submersible)
App Control: Bluetooth app control available',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun antibakteri dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan magnetic charger yang disediakan
Maintenance: Periksa koneksi Bluetooth secara berkala',
                'price' => 1600000,
                'main_image' => 'products/we-vibe-sync.jpg',
                'status' => 'active',
                'stock' => 11,
                'weight' => 85,
            ],
            [
                'category_id' => $couplesCategory->id,
                'name' => 'Lelo Tiani 3',
                'slug' => 'lelo-tiani-3',
                'short_description' => 'Premium couples massager',
                'description' => 'Lelo Tiani 3 adalah massager pasangan premium yang dirancang untuk stimulasi internal dan eksternal. Menggunakan teknologi yang canggih untuk memberikan pengalaman yang optimal.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 18 x 3.5 cm
Berat: 95 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 3 jam
Pola Getaran: 8 pola berbeda
Waterproof: IPX7 (submersible)
Remote Control: Wireless remote included',
                'care_instructions' => 'Pembersihan: Bersihkan dengan sabun lembut dan air hangat
Penyimpanan: Simpan dalam pouch yang disediakan
Charging: Gunakan charger yang disediakan
Maintenance: Periksa remote control secara berkala',
                'price' => 1900000,
                'main_image' => 'products/lelo-tiani-3.jpg',
                'status' => 'active',
                'stock' => 8,
                'weight' => 95,
            ],
            [
                'category_id' => $couplesCategory->id,
                'name' => 'Satisfyer Partner Multifun',
                'slug' => 'satisfyer-partner-multifun',
                'short_description' => 'Multifunctional couples toy',
                'description' => 'Satisfyer Partner Multifun adalah mainan pasangan multifungsi yang dapat digunakan untuk berbagai jenis stimulasi. Dilengkapi dengan berbagai attachment untuk variasi pengalaman.',
                'specifications' => 'Bahan: Medical-grade silicone dan ABS plastic
Ukuran: 20 x 4 cm
Berat: 120 gram
Baterai: Rechargeable lithium-ion
Durasi Penggunaan: Hingga 2.5 jam
Pola Getaran: 12 pola berbeda
Waterproof: IPX7 (submersible)
Attachments: 3 different attachments included',
                'care_instructions' => 'Pembersihan: Bersihkan semua bagian dengan sabun antibakteri
Penyimpanan: Simpan dalam box yang disediakan
Charging: Gunakan charger yang disediakan
Maintenance: Periksa attachment secara berkala',
                'price' => 1450000,
                'main_image' => 'products/satisfyer-partner-multifun.jpg',
                'status' => 'active',
                'stock' => 6,
                'weight' => 120,
            ],
            [
                'category_id' => $couplesCategory->id,
                'name' => 'Lovehoney Desire Luxury',
                'slug' => 'lovehoney-desire-luxury',
                'short_description' => 'Luxury couples collection',
                'description' => 'Lovehoney Desire Luxury adalah koleksi mainan pasangan mewah yang mencakup berbagai alat untuk meningkatkan keintiman. Set ini dirancang untuk memberikan pengalaman yang lengkap.',
                'specifications' => 'Kandungan Set: 2 vibrators, 1 ring, 1 lubricant, 1 storage bag
Bahan: Medical-grade silicone dan ABS plastic
Ukuran: Berbagai ukuran untuk setiap item
Berat Total: 380 gram
Baterai: Rechargeable dan AAA batteries
Durasi Penggunaan: Hingga 3 jam
Pola Getaran: 10 pola berbeda
Waterproof: IPX7 (submersible)',
                'care_instructions' => 'Pembersihan: Bersihkan setiap item secara terpisah
Penyimpanan: Simpan dalam storage bag yang disediakan
Charging: Charge semua item sebelum penggunaan pertama
Maintenance: Periksa semua item secara berkala',
                'price' => 1750000,
                'main_image' => 'products/lovehoney-desire-luxury.jpg',
                'status' => 'out_of_stock',
                'stock' => 0,
                'weight' => 380,
            ],
            [
                'category_id' => $womenCategory->id,
                'name' => 'Doxy Die Cast',
                'slug' => 'doxy-die-cast',
                'short_description' => 'Professional grade massager',
                'description' => 'Doxy Die Cast adalah massager tingkat profesional dengan motor yang sangat bertenaga. Dirancang untuk memberikan stimulasi yang intens dan memuaskan.',
                'specifications' => 'Bahan: Medical-grade silicone dan die-cast aluminum
Ukuran: 28 x 6 cm
Berat: 680 gram
Power: AC powered (230V)
Durasi Penggunaan: Unlimited (AC powered)
Level Intensitas: 3 level (low/medium/high)
Cord Length: 2.5 meter
Noise Level: Ultra-quiet operation',
                'care_instructions' => 'Pembersihan: Bersihkan head dengan sabun antibakteri
Penyimpanan: Simpan di tempat yang kering dan aman
Power: Pastikan voltage sesuai dengan standar lokal
Maintenance: Periksa kabel dan head secara berkala',
                'price' => 2200000,
                'main_image' => 'products/doxy-die-cast.jpg',
                'status' => 'active',
                'stock' => 3,
                'weight' => 680,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

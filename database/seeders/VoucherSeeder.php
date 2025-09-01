<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'WELCOME50',
                'name' => 'Welcome 50% Off',
                'description' => 'Selamat datang! Dapatkan diskon 50% untuk pembelian pertama Anda',
                'type' => 'percentage',
                'value' => 50,
                'min_purchase' => 100000,
                'max_discount' => 75000,
                'usage_limit' => 100,
                'used_count' => 15,
                'starts_at' => now(),
                'expires_at' => now()->addDays(30),
                'is_active' => true,
                'first_time_only' => true,
            ],
            [
                'code' => 'SAVE10K',
                'name' => 'Hemat 10 Ribu',
                'description' => 'Potongan langsung Rp 10.000 untuk semua produk',
                'type' => 'fixed_amount',
                'value' => 10000,
                'min_purchase' => 50000,
                'max_discount' => null,
                'usage_limit' => 50,
                'used_count' => 8,
                'starts_at' => now(),
                'expires_at' => now()->addDays(15),
                'is_active' => true,
                'first_time_only' => false,
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Gratis Ongkir',
                'description' => 'Gratis ongkos kirim untuk semua tujuan',
                'type' => 'free_shipping',
                'value' => 0,
                'min_purchase' => 25000,
                'max_discount' => null,
                'usage_limit' => 200,
                'used_count' => 45,
                'starts_at' => now(),
                'expires_at' => now()->addDays(60),
                'is_active' => true,
                'first_time_only' => false,
            ],
            [
                'code' => 'SUMMER20',
                'name' => 'Summer Sale 20%',
                'description' => 'Promo musim panas! Diskon 20% untuk semua produk',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 75000,
                'max_discount' => 50000,
                'usage_limit' => 150,
                'used_count' => 150, // Habis kuota
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->subDays(1), // Expired
                'is_active' => false,
                'first_time_only' => false,
            ],
            [
                'code' => 'LOYALTY15',
                'name' => 'Loyalty Member 15%',
                'description' => 'Khusus member setia! Diskon 15% tanpa minimum pembelian',
                'type' => 'percentage',
                'value' => 15,
                'min_purchase' => 0,
                'max_discount' => 25000,
                'usage_limit' => null, // Unlimited
                'used_count' => 32,
                'starts_at' => now(),
                'expires_at' => null, // Permanent
                'is_active' => true,
                'first_time_only' => false,
            ],
            [
                'code' => 'MIDNIGHT50',
                'name' => 'Midnight Flash Sale',
                'description' => 'Flash sale tengah malam! Diskon 50% hanya 24 jam',
                'type' => 'percentage',
                'value' => 50,
                'min_purchase' => 200000,
                'max_discount' => 100000,
                'usage_limit' => 25,
                'used_count' => 0,
                'starts_at' => now()->addDays(1),
                'expires_at' => now()->addDays(2),
                'is_active' => true,
                'first_time_only' => false,
            ],
        ];

        foreach ($vouchers as $voucherData) {
            Voucher::create($voucherData);
        }
    }
}


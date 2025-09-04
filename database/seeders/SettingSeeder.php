<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default WhatsApp settings
        Setting::setValue('whatsapp_number', '8100235004');
        Setting::setValue('whatsapp_message', 'Halo, saya ingin bertanya produk terbaru womantoys');
        
        // Default store settings
        Setting::setValue('store_name', 'WomanToys');
        Setting::setValue('store_address', '');
        Setting::setValue('store_city_label', '');
        Setting::setValue('store_origin_id', '');
    }
}

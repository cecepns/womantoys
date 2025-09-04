<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    /**
     * ANCHOR: Get WhatsApp number from settings.
     */
    public static function getWhatsAppNumber(): string
    {
        return Setting::getValue('whatsapp_number', '8100235004');
    }

    public static function getAddress(): string
    {
        return Setting::getValue('store_city_label', 'Jakarta, Indonesia');
    }

    /**
     * ANCHOR: Get WhatsApp message from settings.
     */
    public static function getWhatsAppMessage(): string
    {
        return Setting::getValue('whatsapp_message', 'Halo, saya ingin bertanya produk terbaru womantoys');
    }

    /**
     * ANCHOR: Get store name from settings.
     */
    public static function getStoreName(): string
    {
        return Setting::getValue('store_name', 'WomanToys');
    }
}

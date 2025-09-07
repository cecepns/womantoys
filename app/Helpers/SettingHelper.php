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

    /**
     * ANCHOR: Get store city label from settings.
     */
    public static function getAddress(): string
    {
        return Setting::getValue('store_city_label', 'Jakarta, Indonesia');
    }

    /**
     * ANCHOR: Get email from settings.
     */
    public static function getEmail(): string
    {
        return Setting::getValue('email', 'primemania88@gmail.com');
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

    /**
     * ANCHOR: Get logo from settings.
     */
    public static function getLogo(): ?string
    {
        return Setting::getValue('logo', '');
    }

    /**
     * ANCHOR: Get about us image from settings.
     */
    public static function getAboutUsImage(): string
    {
        return Setting::getValue('about_us_image', 'images/lauren-richmond-5Z3ugfTYYPI-unsplash (1).jpg');
    }

    /**
     * ANCHOR: Generic method to get any setting value.
     */
    public static function getValue(string $key, $default = null)
    {
        return Setting::getValue($key, $default);
    }
}

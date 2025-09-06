<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * ANCHOR: Format currency value without trailing zeros.
     * 
     * @param float $value
     * @param string $prefix
     * @return string
     */
    public static function formatCurrency($value, $prefix = 'Rp '): string
    {
        // Convert to float to handle decimal properly
        $floatValue = (float) $value;

        // Format with 2 decimal places first
        $formatted = number_format($floatValue, 2, ',', '.');

        // Remove trailing zeros and comma if needed
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, ',');

        return $prefix . $formatted;
    }

    /**
     * ANCHOR: Format percentage value without trailing zeros.
     * 
     * @param float $value
     * @return string
     */
    public static function formatPercentage($value): string
    {
        // Convert to float to handle decimal properly
        $floatValue = (float) $value;

        // Format with 2 decimal places first
        $formatted = number_format($floatValue, 2, ',', '.');

        // Remove trailing zeros and comma if needed
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, ',');

        return $formatted . '%';
    }

    /**
     * ANCHOR: Format value for input field without trailing zeros.
     * 
     * @param float $value
     * @return string
     */
    public static function formatInputValue($value): string
    {
        // Convert to float to handle decimal properly
        $floatValue = (float) $value;

        // If the value is a whole number, return without decimal
        if ($floatValue == floor($floatValue)) {
            return (string) floor($floatValue);
        }

        // Format with 2 decimal places first
        $formatted = number_format($floatValue, 2, '.', '');

        // Remove trailing zeros
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key with optional default.
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = static::query()->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Create or update a setting value.
     */
    public static function setValue(string $key, $value): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => is_null($value) ? null : (string) $value]
        );
    }
}



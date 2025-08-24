<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'order',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the full image URL.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image_path)) {
            return null;
        }

        // If the image path is already a full URL, return it as is
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Otherwise, assume it's a relative path and prepend the storage URL
        return asset('storage/' . $this->image_path);
    }

    /**
     * Scope a query to only include images ordered by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Check if the image exists and is accessible.
     *
     * @return bool
     */
    public function hasValidImage()
    {
        if (empty($this->image_path)) {
            return false;
        }

        // If it's a full URL, we can't easily check if it exists
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Check if file exists in storage
        return Storage::disk('public')->exists($this->image_path);
    }
}

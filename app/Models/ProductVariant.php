<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'discount_price',
        'stock',
        'image',
        'is_active',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * ANCHOR: Get the product that owns the variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ANCHOR: Get the order items for the variant.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * ANCHOR: Get the formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * ANCHOR: Get the formatted discount price.
     *
     * @return string|null
     */
    public function getFormattedDiscountPriceAttribute()
    {
        if (is_null($this->discount_price)) {
            return null;
        }

        return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
    }

    /**
     * Check if the variant has a valid image.
     *
     * @return bool
     */
    public function hasValidImage()
    {
        if (empty($this->image)) {
            return false;
        }

        return Storage::disk('public')->exists($this->image);
    }

    /**
     * Get the image URL with fallback.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if ($this->hasValidImage()) {
            return asset('storage/' . $this->image);
        }

        return null;
    }

    /**
     * Check if the variant has a discount.
     *
     * @return bool
     */
    public function hasDiscount()
    {
        return !is_null($this->discount_price) && $this->discount_price > 0 && $this->discount_price < $this->price;
    }

    /**
     * Get the discount percentage.
     *
     * @return float|null
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount()) {
            return null;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100, 0);
    }

    /**
     * Get the final price (discount price if available, otherwise regular price).
     *
     * @return int
     */
    public function getFinalPriceAttribute()
    {
        return $this->hasDiscount() ? $this->discount_price : $this->price;
    }

    /**
     * Get the formatted final price.
     *
     * @return string
     */
    public function getFormattedFinalPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    /**
     * Scope a query to only include active variants.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include variants with stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}

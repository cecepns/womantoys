<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'variant_name',
        'product_name',
        'price',
        'original_price',
        'quantity',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant for the order item.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the subtotal for this item.
     *
     * @return int
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get the formatted subtotal.
     *
     * @return string
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get the formatted original price.
     *
     * @return string|null
     */
    public function getFormattedOriginalPriceAttribute()
    {
        if (is_null($this->original_price)) {
            return null;
        }

        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    /**
     * Check if the order item has a discount.
     *
     * @return bool
     */
    public function hasDiscount()
    {
        return !is_null($this->original_price) && $this->original_price > $this->price;
    }

    /**
     * Get the discount amount for this item.
     *
     * @return int
     */
    public function getDiscountAmountAttribute()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }

        return $this->original_price - $this->price;
    }

    /**
     * Get the formatted discount amount.
     *
     * @return string
     */
    public function getFormattedDiscountAmountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
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

        return round((($this->original_price - $this->price) / $this->original_price) * 100, 0);
    }

    /**
     * Scope a query to only include order items from a specific order.
     */
    public function scopeByOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope a query to only include order items from a specific product.
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}

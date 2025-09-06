<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'care_instructions',
        'price',
        'discount_price',
        'main_image',
        'status',
        'stock',
        'weight',
        'is_featured',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        // Update slug when name is updated
        static::updating(function ($product) {
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * ANCHOR: Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * ANCHOR: Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * ANCHOR: Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * ANCHOR: Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
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
     * ANCHOR: Get the formatted weight.
     *
     * @return string|null
     */
    public function getFormattedWeightAttribute()
    {
        if (is_null($this->weight)) {
            return null;
        }

        if ($this->weight >= 1000) {
            return number_format($this->weight / 1000, 2) . ' kg';
        }

        return number_format($this->weight, 0) . ' gram';
    }

    /**
     * Get the status label for display.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'draft' => 'Draft',
            'out_of_stock' => 'Stok Habis',
            default => 'Unknown'
        };
    }

    /**
     * Get the status badge class for display.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'draft' => 'bg-yellow-100 text-yellow-800',
            'out_of_stock' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include products with stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include products from a specific category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to search products by name or description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('short_description', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the featured status label for display.
     *
     * @return string
     */
    public function getFeaturedStatusLabelAttribute()
    {
        return $this->is_featured ? 'Unggulan' : 'Biasa';
    }

    /**
     * Get the featured status badge class for display.
     *
     * @return string
     */
    public function getFeaturedStatusBadgeClassAttribute()
    {
        return $this->is_featured ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if the product has a valid main image.
     *
     * @return bool
     */
    public function hasValidMainImage()
    {
        if (empty($this->main_image)) {
            return false;
        }

        return Storage::disk('public')->exists($this->main_image);
    }

    /**
     * Get the main image URL with fallback.
     *
     * @return string
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->hasValidMainImage()) {
            return asset('storage/' . $this->main_image);
        }

        // Return null to indicate no image, will be handled in the view
        return null;
    }

    /**
     * Check if the product has a discount.
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
}

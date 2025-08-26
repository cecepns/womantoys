<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'cover_image',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Update slug when name is updated
        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include categories with cover images.
     */
    public function scopeWithCoverImage($query)
    {
        return $query->whereNotNull('cover_image')->where('cover_image', '!=', '');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Check if the category has a cover image.
     *
     * @return bool
     */
    public function hasCoverImage()
    {
        return !empty($this->cover_image);
    }

    /**
     * Get the cover image URL.
     *
     * @return string|null
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->hasCoverImage() ? asset('storage/' . $this->cover_image) : null;
    }
}

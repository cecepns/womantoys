<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MainCategory extends Model
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
        static::creating(function ($mainCategory) {
            if (empty($mainCategory->slug)) {
                $mainCategory->slug = Str::slug($mainCategory->name);
            }
        });

        // Update slug when name is updated
        static::updating(function ($mainCategory) {
            if ($mainCategory->isDirty('name') && !$mainCategory->isDirty('slug')) {
                $mainCategory->slug = Str::slug($mainCategory->name);
            }
        });
    }

    /**
     * Get the categories for the main category.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Scope a query to only include main categories with cover images.
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
     * Check if the main category has a cover image.
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

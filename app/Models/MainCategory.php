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
        'order',
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

            // Auto-set order to be at the end
            if (empty($mainCategory->order)) {
                $mainCategory->order = static::max('order') + 1;
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

    /**
     * Move the main category up in order.
     *
     * @return bool
     */
    public function moveUp()
    {
        $previousCategory = static::where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousCategory) {
            $tempOrder = $this->order;
            $this->order = $previousCategory->order;
            $previousCategory->order = $tempOrder;

            $this->save();
            $previousCategory->save();

            return true;
        }

        return false;
    }

    /**
     * Move the main category down in order.
     *
     * @return bool
     */
    public function moveDown()
    {
        $nextCategory = static::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextCategory) {
            $tempOrder = $this->order;
            $this->order = $nextCategory->order;
            $nextCategory->order = $tempOrder;

            $this->save();
            $nextCategory->save();

            return true;
        }

        return false;
    }

    /**
     * Check if this is the first main category.
     *
     * @return bool
     */
    public function isFirst()
    {
        $minOrder = static::min('order');
        return $minOrder !== null && $this->order == $minOrder;
    }

    /**
     * Check if this is the last main category.
     *
     * @return bool
     */
    public function isLast()
    {
        $maxOrder = static::max('order');
        return $maxOrder !== null && $this->order == $maxOrder;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarouselSlide extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
        'title',
        'description',
        'cta_text',
        'cta_link',
        'order',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Set default order when creating if not provided
        static::creating(function ($slide) {
            if (empty($slide->order)) {
                $slide->order = static::max('order') + 1;
            }
        });
    }

    /**
     * Scope a query to only include slides ordered by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope a query to only include active slides (with image).
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('image_path')->where('image_path', '!=', '');
    }

    /**
     * Scope a query to only include slides with complete content.
     */
    public function scopeComplete($query)
    {
        return $query->whereNotNull('title')
                    ->whereNotNull('description')
                    ->where('title', '!=', '')
                    ->where('description', '!=', '');
    }

    /**
     * Scope a query to only include slides with partial content.
     */
    public function scopePartial($query)
    {
        return $query->where(function($q) {
            $q->whereNull('title')
              ->orWhere('title', '=', '')
              ->orWhereNull('description')
              ->orWhere('description', '=', '');
        });
    }

    /**
     * Get the full image URL.
     *
     * @return string|null
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

    /**
     * Get a fallback image URL when the main image is not available.
     *
     * @return string
     */
    public function getFallbackImageUrl()
    {
        // You can customize this to return a default image
        return asset('images/default-carousel.jpg');
    }

    /**
     * Get the image URL with fallback handling.
     *
     * @return string
     */
    public function getSafeImageUrlAttribute()
    {
        if ($this->hasValidImage()) {
            return $this->image_url;
        }

        return $this->getFallbackImageUrl();
    }

    /**
     * Check if the slide has a call-to-action.
     *
     * @return bool
     */
    public function hasCta()
    {
        return !empty($this->cta_text) && !empty($this->cta_link);
    }

    /**
     * Check if the slide has a description.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return !empty($this->description);
    }

    /**
     * Get truncated description for display.
     *
     * @param int $length
     * @return string
     */
    public function getTruncatedDescription($length = 100)
    {
        if (empty($this->description)) {
            return '';
        }

        if (strlen($this->description) <= $length) {
            return $this->description;
        }

        return substr($this->description, 0, $length) . '...';
    }

    /**
     * Check if the slide has complete content (title and description).
     *
     * @return bool
     */
    public function hasCompleteContent()
    {
        return !empty($this->title) && !empty($this->description);
    }

    /**
     * Get slide status for display.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if (empty($this->image_path)) {
            return 'inactive';
        }

        if ($this->hasCompleteContent()) {
            return 'complete';
        }

        return 'partial';
    }

    /**
     * Move the slide up in order.
     *
     * @return bool
     */
    public function moveUp()
    {
        $previousSlide = static::where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousSlide) {
            $tempOrder = $this->order;
            $this->order = $previousSlide->order;
            $previousSlide->order = $tempOrder;

            $this->save();
            $previousSlide->save();

            return true;
        }

        return false;
    }

    /**
     * Move the slide down in order.
     *
     * @return bool
     */
    public function moveDown()
    {
        $nextSlide = static::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextSlide) {
            $tempOrder = $this->order;
            $this->order = $nextSlide->order;
            $nextSlide->order = $tempOrder;

            $this->save();
            $nextSlide->save();

            return true;
        }

        return false;
    }

    /**
     * Get the next slide in order.
     *
     * @return CarouselSlide|null
     */
    public function getNextSlide()
    {
        return static::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();
    }

    /**
     * Get the previous slide in order.
     *
     * @return CarouselSlide|null
     */
    public function getPreviousSlide()
    {
        return static::where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    /**
     * Check if this is the first slide.
     *
     * @return bool
     */
    public function isFirst()
    {
        $minOrder = static::min('order');
        return $minOrder !== null && $this->order == $minOrder;
    }

    /**
     * Check if this is the last slide.
     *
     * @return bool
     */
    public function isLast()
    {
        $maxOrder = static::max('order');
        return $maxOrder !== null && $this->order == $maxOrder;
    }
}

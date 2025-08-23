<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Check if the slide has a call-to-action.
     *
     * @return bool
     */
    public function hasCta()
    {
        return !empty($this->cta_text) && !empty($this->cta_link);
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
}

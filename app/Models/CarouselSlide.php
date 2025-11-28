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
        'image_mobile_path',
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
     * URL gambar mobile (opsional). Jika path kosong, kembalikan null.
     * Digunakan untuk perangkat mobile, dengan fallback ke gambar desktop.
     */
    public function getImageMobileUrlAttribute()
    {
        if (empty($this->image_mobile_path)) {
            return null;
        }

        if (filter_var($this->image_mobile_path, FILTER_VALIDATE_URL)) {
            return $this->image_mobile_path;
        }

        return asset('storage/' . $this->image_mobile_path);
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
     * Cek ketersediaan file gambar mobile (opsional).
     * Jika path berupa URL penuh, asumsikan valid.
     */
    public function hasValidMobileImage()
    {
        if (empty($this->image_mobile_path)) {
            return false;
        }

        if (filter_var($this->image_mobile_path, FILTER_VALIDATE_URL)) {
            return true;
        }

        return Storage::disk('public')->exists($this->image_mobile_path);
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_path',
        'cta_link',
        'is_active',
        'order',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Set default order when creating if not provided
        static::creating(function ($promotion) {
            if (empty($promotion->order)) {
                $promotion->order = static::max('order') ?? 0;
                $promotion->order += 1;
            }
        });
    }

    /**
     * Get the full file URL.
     *
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        if (empty($this->file_path)) {
            return null;
        }

        // If the file path is already a full URL, return it as is
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }

        // Otherwise, assume it's a relative path and prepend the storage URL
        return asset('storage/' . $this->file_path);
    }

    /**
     * Check if the file is a video.
     *
     * @return bool
     */
    public function isVideo()
    {
        if (empty($this->file_path)) {
            return false;
        }

        $extension = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        return in_array($extension, ['mp4']);
    }

    /**
     * Check if the file is an image.
     *
     * @return bool
     */
    public function isImage()
    {
        if (empty($this->file_path)) {
            return false;
        }

        $extension = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Scope a query to only include active promotions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order promotions by order field.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Check if the file exists and is accessible.
     *
     * @return bool
     */
    public function hasValidFile()
    {
        if (empty($this->file_path)) {
            return false;
        }

        // If it's a full URL, we can't easily check if it exists
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Check if file exists in storage
        return Storage::disk('public')->exists($this->file_path);
    }
}


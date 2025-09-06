<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'voucher_id',
        'order_id',
        'customer_email',
        'discount_amount',
        'used_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'used_at' => 'datetime',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set used_at timestamp when creating
        static::creating(function ($voucherUsage) {
            if (empty($voucherUsage->used_at)) {
                $voucherUsage->used_at = now();
            }
        });
    }

    /**
     * Get the voucher that owns the voucher usage.
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Get the order that owns the voucher usage.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the formatted discount amount.
     *
     * @return string
     */
    public function getFormattedDiscountAmountAttribute()
    {
        return FormatHelper::formatCurrency($this->discount_amount);
    }

    /**
     * Scope a query to filter by customer email.
     */
    public function scopeByCustomer($query, $email)
    {
        return $query->where('customer_email', $email);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('used_at', [$startDate, $endDate]);
    }
}

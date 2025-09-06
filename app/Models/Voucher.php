<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Voucher extends Model
{
    /**
     * Voucher type constants
     */
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED_AMOUNT = 'fixed_amount';
    const TYPE_FREE_SHIPPING = 'free_shipping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
        'applicable_categories',
        'applicable_products',
        'exclude_products',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'applicable_categories' => 'array',
        'applicable_products' => 'array',
        'exclude_products' => 'array',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate code if not provided
        static::creating(function ($voucher) {
            if (empty($voucher->code)) {
                $voucher->code = self::generateCode();
            }
        });
    }

    /**
     * Generate a unique voucher code.
     *
     * @return string
     */
    public static function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Get the voucher usages for the voucher.
     */
    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    /**
     * Get the orders that used this voucher.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if voucher is valid for use.
     *
     * @param array $cart
     * @param string $customerEmail
     * @return array
     */
    public function validateForUse($cart = [], $customerEmail = null)
    {
        // Check if voucher is active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Voucher tidak aktif'];
        }

        // Check if voucher has started
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return ['valid' => false, 'message' => 'Voucher belum berlaku'];
        }

        // Check if voucher has expired
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return ['valid' => false, 'message' => 'Voucher sudah kadaluarsa'];
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Voucher sudah habis digunakan'];
        }

        // Check minimum purchase
        $cartTotal = collect($cart)->sum('total') ?? 0;
        if ($cartTotal < $this->min_purchase) {
            return [
                'valid' => false,
                'message' => 'Minimal belanja Rp ' . number_format($this->min_purchase, 0, ',', '.')
            ];
        }



        return ['valid' => true, 'voucher' => $this];
    }

    /**
     * Calculate discount amount.
     *
     * @param float $total
     * @param float $shippingCost
     * @return float
     */
    public function calculateDiscount($total, $shippingCost = 0)
    {
        switch ($this->type) {
            case self::TYPE_PERCENTAGE:
                $discount = $total * ($this->value / 100);
                if ($this->max_discount) {
                    $discount = min($discount, $this->max_discount);
                }
                return $discount;

            case self::TYPE_FIXED_AMOUNT:
                return min($this->value, $total);

            case self::TYPE_FREE_SHIPPING:
                return 0; // Free shipping discount is applied by setting shipping cost to 0

            default:
                return 0;
        }
    }

    /**
     * Get the formatted value for display.
     *
     * @return string
     */
    public function getFormattedValueAttribute()
    {
        switch ($this->type) {
            case self::TYPE_PERCENTAGE:
                return FormatHelper::formatPercentage($this->value);
            case self::TYPE_FIXED_AMOUNT:
                return FormatHelper::formatCurrency($this->value);
            case self::TYPE_FREE_SHIPPING:
                return 'Gratis Ongkir';
            default:
                return '';
        }
    }

    /**
     * Get the type label for display.
     *
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            self::TYPE_PERCENTAGE => 'Persentase',
            self::TYPE_FIXED_AMOUNT => 'Nominal',
            self::TYPE_FREE_SHIPPING => 'Gratis Ongkir',
            default => 'Unknown'
        };
    }

    /**
     * Get the status label for display.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if (!$this->is_active) {
            return 'Nonaktif';
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'Belum Aktif';
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return 'Kadaluarsa';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'Habis';
        }

        return 'Aktif';
    }

    /**
     * Get the status badge class for display.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        $status = $this->getStatusLabelAttribute();

        return match ($status) {
            'Aktif' => 'bg-green-100 text-green-800',
            'Nonaktif' => 'bg-red-100 text-red-800',
            'Belum Aktif' => 'bg-yellow-100 text-yellow-800',
            'Kadaluarsa' => 'bg-red-100 text-red-800',
            'Habis' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Scope a query to only include active vouchers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include valid vouchers.
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            });
    }

    /**
     * Scope a query to search vouchers.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('code', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Scope a query to only include used vouchers.
     */
    public function scopeUsed($query)
    {
        return $query->where('used_count', '>', 0);
    }

    /**
     * Scope a query to only include unused vouchers.
     */
    public function scopeUnused($query)
    {
        return $query->where('used_count', 0);
    }

    /**
     * Check if voucher has been used.
     *
     * @return bool
     */
    public function hasBeenUsed()
    {
        return $this->used_count > 0;
    }

    /**
     * Get the usage count.
     *
     * @return int
     */
    public function getUsageCount()
    {
        return $this->used_count;
    }
}

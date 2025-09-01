<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    /**
     * Order status constants
     */
    const STATUS_PENDING_PAYMENT = 'menunggu_pembayaran';
    const STATUS_PAID = 'sudah_dibayar';
    const STATUS_PROCESSING = 'sedang_diproses';
    const STATUS_SHIPPED = 'dikirim';
    const STATUS_DELIVERED = 'diterima';
    const STATUS_CANCELLED = 'dibatalkan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_number',
        'confirmation_token',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_method',
        'shipping_cost',
        'total_amount',
        'status',
        'payment_proof_path',
        'voucher_id',
        'voucher_code',
        'discount_amount',
        'subtotal',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate order number and confirmation token when creating
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
            if (empty($order->confirmation_token)) {
                $order->confirmation_token = Str::random(32);
            }
            if (empty($order->status)) {
                $order->status = self::STATUS_PENDING_PAYMENT;
            }
        });
    }

    /**
     * Generate a unique order number.
     *
     * @return string
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        
        return $prefix . $date . $random;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'order_number';
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the voucher that was used for this order.
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Get the voucher usage for this order.
     */
    public function voucherUsage()
    {
        return $this->hasOne(VoucherUsage::class);
    }

    /**
     * Get the formatted total amount.
     *
     * @return string
     */
    public function getFormattedTotalAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get the formatted shipping cost.
     *
     * @return string
     */
    public function getFormattedShippingCostAttribute()
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    /**
     * Get the formatted subtotal amount.
     *
     * @return string
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get the formatted discount amount.
     *
     * @return string
     */
    public function getFormattedDiscountAmountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    /**
     * Check if order is pending payment.
     *
     * @return bool
     */
    public function isPendingPayment()
    {
        return $this->status === self::STATUS_PENDING_PAYMENT;
    }

    /**
     * Check if order is paid.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Check if order is processing.
     *
     * @return bool
     */
    public function isProcessing()
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if order is shipped.
     *
     * @return bool
     */
    public function isShipped()
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    /**
     * Check if order is delivered.
     *
     * @return bool
     */
    public function isDelivered()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    /**
     * Check if order is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Scope a query to only include orders with specific status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include orders by customer email.
     */
    public function scopeByCustomerEmail($query, $email)
    {
        return $query->where('customer_email', $email);
    }

    /**
     * Scope a query to search orders by order number or customer name.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
    }
}

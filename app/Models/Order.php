<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Coupon;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'order_number',
        'first_name',
        'last_name',
        'company_name',
        'address',
        'apartment',
        'state_country',
        'postal_zip',
        'email',
        'phone',
        'order_notes',
        'subtotal',
        'total',
        'status',
        'payment_method',
        'payment_screenshot',
        'coupon_code',
        'coupon_id',
        'coupon_discount',
        'discount_amount',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Get the order items for this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon used for this order.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(uniqid());
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'full_name',
        'email',
        'phone',
        'address1',
        'address2',
        'city',
        'district',
        'postal_code',
        'subtotal',
        'shipping',
        'tax',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = self::generateOrderNumber();
        });
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'image',
        'color',
        'size',
        'quantity',
        'price',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

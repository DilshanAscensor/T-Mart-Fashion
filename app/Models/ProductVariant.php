<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'stock',
        'product_color_id',

    ];

    protected $appends = ['available_stock'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id')
            ->whereColumn('color', 'color')
            ->whereColumn('size', 'size');
    }

    public function getAvailableStockAttribute()
    {
        $sold = \App\Models\OrderItem::where('product_id', $this->product_id)
            ->where('color', $this->color)
            ->where('size', $this->size)
            ->sum('quantity');

        return $this->stock - $sold;
    }
}

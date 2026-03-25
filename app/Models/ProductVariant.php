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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


     public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColors::class, 'product_color_id');
    }
}

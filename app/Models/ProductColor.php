<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color_code',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_color_id');
    }
}

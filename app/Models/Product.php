<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'description',
        'price',
        'stock',
        'category_id',
        'cost_price',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

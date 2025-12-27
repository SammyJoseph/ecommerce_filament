<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReview extends Product
{
    protected $table = 'products';

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function getMorphClass()
    {
        return Product::class;
    }
}

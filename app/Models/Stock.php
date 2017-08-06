<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Product\Products as ProductModel;

class Stock extends Model
{

    protected $table = 'stock';

    public function product()
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }

}
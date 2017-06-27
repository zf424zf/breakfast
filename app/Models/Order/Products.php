<?php

namespace App\Models\Order;

use App\Models\Model;
use App\Models\Product\Products as ProductModel;

class Products extends Model
{

    protected $table = 'orders_products';

    public function product()
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }


}
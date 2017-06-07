<?php

namespace App\Models\Product;

use App\Models\Model;

class Saleday extends Model
{

    protected $table = 'products_saleday';

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

}
<?php

namespace App\Models\Product;

use App\Models\Model;
use App\Models\Saleday as Saledays;

class Products extends Model
{

    protected $table = 'products';

    public function saledays()
    {
        return $this->belongsToMany(Saledays::class,'products_saleday','product_id','saleday_id');
    }

    public function pickuptimes()
    {
        return  $this->hasMany(PickupTime::class,'product_id');
    }


}
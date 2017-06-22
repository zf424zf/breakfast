<?php

namespace App\Models\Product;

use App\Models\Model;
use App\Models\Saleday as Saledays;
use App\Models\Metro\Place as Places;
use App\Models\PickupTime as Pickuptimes;
use Illuminate\Database\Eloquent\Builder;

class Products extends Model
{

    protected $table = 'products';

    public function saledays()
    {
        return $this->belongsToMany(Saledays::class, 'products_saleday', 'product_id', 'saleday');
    }

    public function pickuptimes()
    {
        return $this->belongsToMany(Pickuptimes::class, 'products_pickup_time', 'product_id', 'pickuptime_id');
    }

    public function places()
    {
        return $this->belongsToMany(Places::class, 'products_place', 'product_id', 'place_id');
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where('stock','>', 0)->where('status',1);
    }


}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Coupon extends Model
{

    protected $table = 'coupon_card';

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid(Builder $query)
    {
        return $query->where('expire', '>', time())->where('status', 0);
    }

}
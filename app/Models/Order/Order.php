<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Model;

class Order extends Model
{

    protected $table = 'orders';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany(Products::class, 'order_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Logs::class, 'order_id', 'order_id');
    }

}
<?php

namespace App\Models\Order;

use App\Models\Model;
use App\Models\PickupTime as PickuptimeModel;
use App\Models\Metro\Place as PlaceModel;
use App\Models\Users as UsersModel;

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

    public function pickuptime()
    {
        return $this->hasOne(PickuptimeModel::class, 'id', 'pickuptime_id');
    }

    public function place()
    {
        return $this->hasOne(PlaceModel::class, 'id', 'place_id');
    }

    public function user()
    {
        return $this->hasOne(UsersModel::class, 'id', 'uid');
    }

}
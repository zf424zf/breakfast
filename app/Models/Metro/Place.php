<?php

namespace App\Models\Metro;

use App\Models\Model;
use App\Models\PickupTime;

class Place extends Model
{

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'metro_place_relation', 'place_id', 'station_id');
    }

    public function pickuptimes()
    {
        return $this->belongsToMany(PickupTime::class, 'metro_place_pickuptime', 'place_id', 'pickuptime_id');
    }

}
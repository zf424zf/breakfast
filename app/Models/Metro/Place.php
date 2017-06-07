<?php

namespace App\Models\Metro;

use App\Models\Model;

class Place extends Model
{

    public function stations()
    {
        return $this->belongsToMany(Station::class,'metro_place_relation', 'place_id','station_id');
    }

}
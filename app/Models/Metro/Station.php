<?php

namespace App\Models\Metro;

use App\Models\Model;

class Station extends Model
{

    public function metros()
    {
        return $this->belongsToMany(Metro::class,'metro_station_relation', 'station_id','metro_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class,'metro_place_relation', 'station_id','place_id');
    }

}
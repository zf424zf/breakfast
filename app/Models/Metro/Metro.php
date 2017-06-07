<?php

namespace App\Models\Metro;

use App\Models\Model;

class Metro extends Model
{

    protected $table = 'metro';

    public function stations()
    {
        return $this->belongsToMany(Station::class,'metro_station_relation', 'metro_id','station_id');
    }

}
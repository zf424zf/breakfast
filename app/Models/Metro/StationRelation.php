<?php

namespace App\Models\Metro;

use App\Models\Model;

class StationRelation extends Model
{
    protected $table = 'metro_station_relation';

    public $timestamps = false;

    public function station()
    {
        return $this->hasOne(Station::class, 'id', 'station_id');
    }

}
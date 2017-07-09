<?php

namespace App\Models\Metro;

use App\Models\Model;

class PlaceRelation extends Model
{

    protected $table = 'metro_place_relation';

    public $timestamps = false;

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

}
<?php

namespace App\Models;


class Users extends Model
{

    protected $table = 'users';

    protected $casts = [
        'profile' => 'array',
    ];

}
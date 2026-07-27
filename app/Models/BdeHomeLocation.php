<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BdeHomeLocation extends Model
{


    protected $fillable = [

        'bde_id',

        'home_lat',

        'home_long',

        'home_address',

    ];

    protected $casts = [

        'home_lat' => 'decimal:7',

        'home_long' => 'decimal:7',

    ];
}

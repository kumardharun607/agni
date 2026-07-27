<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrapDistributor extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'rep_id',

        'name',

        'customer_name',

        'mobile',

        'country_id',

        'state_id',

        'city_id',

        'pincode_id',

        'address',

        'gst_no',

        'pan_no',

        'email',

        'latitude',

        'longitude',

        'image',

        'dob',

        'date',
    ];

    protected $casts = [

        'dob'=>'date',

        'date'=>'date',

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function pincode()
    {
        return $this->belongsTo(Pincode::class);
    }
}
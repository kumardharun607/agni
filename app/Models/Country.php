<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    protected static function booted(): void
    {
        // Soft-delete dependent states → cities → pincodes when a country is soft-deleted
        static::deleting(function (Country $country) {
            if ($country->isForceDeleting()) {
                return;
            }

            $stateIds = $country->states()->pluck('id');
            if ($stateIds->isEmpty()) {
                return;
            }

            $cityIds = City::whereIn('state_id', $stateIds)->pluck('id');

            if ($cityIds->isNotEmpty()) {
                Pincode::whereIn('city_id', $cityIds)->delete();
                City::whereIn('id', $cityIds)->delete();
            }

            State::whereIn('id', $stateIds)->delete();
        });
    }
}

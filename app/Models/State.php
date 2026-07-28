<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $fillable = ['country_id', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    protected static function booted(): void
    {
        // Soft-delete dependent cities → pincodes when a state is soft-deleted
        static::deleting(function (State $state) {
            if ($state->isForceDeleting()) {
                return;
            }

            $cityIds = $state->cities()->pluck('id');
            if ($cityIds->isEmpty()) {
                return;
            }

            Pincode::whereIn('city_id', $cityIds)->delete();
            City::whereIn('id', $cityIds)->delete();
        });
    }
}

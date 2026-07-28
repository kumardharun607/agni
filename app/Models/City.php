<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = ['state_id', 'name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function pincodes()
    {
        return $this->hasMany(Pincode::class);
    }

    protected static function booted(): void
    {
        // Soft-delete dependent pincodes when a city is soft-deleted
        static::deleting(function (City $city) {
            if ($city->isForceDeleting()) {
                return;
            }

            $city->pincodes()->delete();
        });
    }
}

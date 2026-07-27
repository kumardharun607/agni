<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {
    use SoftDeletes;
    protected $fillable = ['state_id', 'name'];
    public function state() { return $this->belongsTo(State::class); }
    public function pincodes() { return $this->hasMany(Pincode::class); }
}

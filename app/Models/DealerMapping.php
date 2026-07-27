<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerMapping extends Model
{
    use SoftDeletes;
    protected $fillable = ['dealer_id', 'bde_id'];

    public function dealer() { return $this->belongsTo(Dealer::class, 'dealer_id'); }
    public function bde() { return $this->belongsTo(User::class, 'bde_id'); }
}

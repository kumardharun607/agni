<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMapping extends Model
{
    use SoftDeletes;
    protected $fillable = ['parent_id', 'child_id'];

    public function parentUser() { return $this->belongsTo(User::class, 'parent_id'); }
    public function childUser() { return $this->belongsTo(User::class, 'child_id'); }
}

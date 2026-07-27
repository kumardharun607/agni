<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
    use SoftDeletes;
    protected $fillable = ['name', 'level'];

    public function users() { return $this->hasMany(User::class); }
    public function rolePermissions() { return $this->hasMany(RolePermission::class); }
}

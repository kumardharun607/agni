<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'emp_code', 'role_id', 'name', 'mobile', 'country_id', 'state_id',
        'city_id', 'pincode_id', 'address', 'doj', 'dob', 'email',
        'password', 'plain_password', 'otp',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'doj' => 'date',
        'dob' => 'date',
    ];

    // Automatically hash password whenever plain_password/password is set.
    // Controllers always write to plain_password; this keeps password (hash) in sync.
    public function setPlainPasswordAttribute($value): void
    {
        $this->attributes['plain_password'] = $value;
        $this->attributes['password'] = Hash::make($value);
    }

    public function role() { return $this->belongsTo(Role::class); }
    public function country() { return $this->belongsTo(Country::class); }
    public function state() { return $this->belongsTo(State::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function pincode() { return $this->belongsTo(Pincode::class); }

    // hierarchy: users this user manages (children) e.g Manager->children Telecallers
    public function children()
    {
        return $this->belongsToMany(User::class, 'user_mappings', 'parent_id', 'child_id')
            ->withTimestamps();
    }

    // hierarchy: the user(s) this user reports to (parents)
    public function parents()
    {
        return $this->belongsToMany(User::class, 'user_mappings', 'child_id', 'parent_id')
            ->withTimestamps();
    }
}

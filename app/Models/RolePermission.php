<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model {
    protected $fillable = ['role_id', 'permission_dropdown_id', 'can_view', 'can_add', 'can_edit', 'can_delete', 'can_import', 'can_export'];
    protected $casts = ['can_view' => 'boolean', 'can_add' => 'boolean', 'can_edit' => 'boolean', 'can_delete' => 'boolean', 'can_import' => 'boolean', 'can_export' => 'boolean'];

    public function role() { return $this->belongsTo(Role::class); }
    public function permission() { return $this->belongsTo(PermissionDropdown::class, 'permission_dropdown_id'); }
}

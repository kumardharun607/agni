<?php
namespace App\Http\Middleware;

use App\Models\PermissionDropdown;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    // usage in routes: ->middleware('permission:Dealer,view')
    public function handle(Request $request, Closure $next, string $feature, string $ability)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $featureRow = PermissionDropdown::where('name', $feature)->first();
        $column = 'can_' . $ability;

        $allowed = $featureRow
            ? RolePermission::where('role_id', $user->role_id)
                ->where('permission_dropdown_id', $featureRow->id)
                ->where($column, true)
                ->exists()
            : false;

        if (!$allowed) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}

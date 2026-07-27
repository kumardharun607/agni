<?php

namespace App\Repositories\Eloquent;

use App\Models\DealerMapping;
use App\Models\Role;
use App\Models\User;
use App\Models\UserMapping;
use App\Repositories\Interfaces\DealerMappingRepositoryInterface;

class DealerMappingRepository extends BaseRepository implements DealerMappingRepositoryInterface
{
    // Hierarchy order used across the module, from lowest level number to highest:
    // Telecaller (1) -> Manager (2) -> SO (3) -> BDE (4)
    public function __construct(DealerMapping $model)
    {
        parent::__construct($model);
    }

    // Org hierarchy screen: root = BDE, descending through SO -> Manager -> Telecaller
    public function buildHierarchyTree(): array
    {
        $roles = Role::orderBy('level')->get()->keyBy('name');
        $tree = [];

        if (isset($roles['BDE'])) {
            $bdes = User::where('role_id', $roles['BDE']->id)->orderBy('name')->get();

            foreach ($bdes as $bde) {
                $tree[] = [
                    'user' => $bde,
                    'children' => $this->buildLevel($bde, 'SO'),
                ];
            }
        }

        return $tree;
    }

    private function buildLevel(User $parent, string $nextRoleName): array
    {
        $nextRole = Role::where('name', $nextRoleName)->first();

        if (! $nextRole) {
            return [];
        }

        $children = $parent->children()->where('role_id', $nextRole->id)->orderBy('name')->get();

        $roleAfter = match ($nextRoleName) {
            'SO' => 'Manager',
            'Manager' => 'Telecaller',
            default => null,
        };

        return $children->map(function ($child) use ($roleAfter) {
            return [
                'user' => $child,
                'children' => $roleAfter ? $this->buildLevel($child, $roleAfter) : [],
            ];
        })->toArray();
    }

    /**
     * Change 4: validate parent/child order for the user_mapping hierarchy.
     *
     * Role levels are seeded as Telecaller = 1, Manager = 2, SO = 3, BDE = 4,
     * where a *lower* level number ranks *higher* in this hierarchy (Telecaller
     * outranks Manager, which outranks SO, which outranks BDE). A mapping is only
     * valid when the parent's level number is smaller (higher rank) than the
     * child's level number (lower rank) — e.g. parent Telecaller -> child BDE is
     * valid, but parent BDE -> child Telecaller is not and must throw an error.
     */
    public function validateHierarchyOrder(int $parentId, int $childId): ?string
    {
        $parent = User::with('role')->find($parentId);
        $child = User::with('role')->find($childId);

        if (! $parent || ! $parent->role || $parent->role->level === null) {
            return 'Selected parent does not have a valid hierarchy level assigned.';
        }

        if (! $child || ! $child->role || $child->role->level === null) {
            return 'Selected child does not have a valid hierarchy level assigned.';
        }

        if ((int) $parent->role->level >= (int) $child->role->level) {
            return 'Invalid mapping: parent must be a higher level than the child. '
                . 'Only the order Telecaller \u2192 Manager \u2192 SO \u2192 BDE is allowed as parent \u2192 child.';
        }

        return null;
    }

    public function createUserMapping(int $parentId, int $childId)
    {
        return UserMapping::firstOrCreate([
            'parent_id' => $parentId,
            'child_id' => $childId,
        ]);
    }
}

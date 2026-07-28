<?php

namespace App\Http\Controllers\DealerMapping;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\DealerMapping;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealerMappingController extends Controller
{
    use HasCsvIO;

    

    public function index()
    {
        return view('dealer_mapping.index');
    }

    public function data()
    {
        return DataTables::of(DealerMapping::with(['dealer', 'bde']))
            ->addIndexColumn()
            ->addColumn('dealer_name', fn ($row) => $row->dealer->name . ' (' . $row->dealer->alias_id . ')')
            ->addColumn('bde_name', fn ($row) => $row->bde->name ?? '-')
            ->addColumn('action', fn ($row) => view('dealer_mapping.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $dealers = Dealer::orderBy('name')->get();
        $bdes = User::whereHas('role', function ($q) { $q->where('name', 'BDE'); })->orderBy('name')->get();

        return view('dealer_mapping.create', compact('dealers', 'bdes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->mappingRules());
        DealerMapping::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Dealer mapped to BDE successfully.', 'redirect' => route('dealer-mapping.index')]);
        }

        return redirect()->route('dealer-mapping.index')->with('success', 'Dealer mapped to BDE successfully.');
    }

    public function edit(DealerMapping $dealer_mapping)
    {
        $dealers = Dealer::orderBy('name')->get();
        $bdes = User::whereHas('role', function ($q) { $q->where('name', 'BDE'); })->orderBy('name')->get();

        return view('dealer_mapping.edit', ['item' => $dealer_mapping, 'dealers' => $dealers, 'bdes' => $bdes]);
    }

    // Change 6: read-only view of a Dealer -> BDE mapping row.
    public function show(DealerMapping $dealer_mapping)
    {
        $dealers = Dealer::orderBy('name')->get();
        $bdes = User::whereHas('role', function ($q) { $q->where('name', 'BDE'); })->orderBy('name')->get();

        return view('dealer_mapping.edit', [
            'item' => $dealer_mapping,
            'dealers' => $dealers,
            'bdes' => $bdes,
            'readonly' => true,
        ]);
    }

    public function update(Request $request, DealerMapping $dealer_mapping)
    {
        $data = $request->validate($this->mappingRules());
        $dealer_mapping->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Mapping updated successfully.', 'redirect' => route('dealer-mapping.index')]);
        }

        return redirect()->route('dealer-mapping.index')->with('success', 'Mapping updated successfully.');
    }

    public function destroy(DealerMapping $dealer_mapping)
    {
        $dealer_mapping->delete();

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('dealer_mapping.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\DealerMappingExport,
            'dealer-mapping.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);

        try {
            $rows = $this->readSpreadsheet($request->file('file'), [
                ['Dealer Alias ID', 'dealer_alias_id', 'alias_id'],
                ['BDE Emp Code', 'bde_emp_code', 'emp_code'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $msg = collect($e->errors())->flatten()->first() ?: 'Invalid import file.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withErrors(['file' => $msg]);
        }

        $count = 0;
        $duplicates = [];
        $notFound = [];
        $restored = 0;

        foreach ($rows as $row) {
            $dealerAlias = $this->csvValue($row, 'Dealer Alias ID')
                ?: $this->csvValue($row, 'dealer_alias_id')
                ?: $this->csvValue($row, 'alias_id');
            $bdeEmpCode = $this->csvValue($row, 'BDE Emp Code')
                ?: $this->csvValue($row, 'bde_emp_code')
                ?: $this->csvValue($row, 'emp_code');

            if (! $dealerAlias || ! $bdeEmpCode) {
                continue;
            }

            $dealerAlias = trim((string) $dealerAlias);
            $bdeEmpCode = trim((string) $bdeEmpCode);

            $dealer = Dealer::where('alias_id', $dealerAlias)->first();
            $bde = User::where('emp_code', $bdeEmpCode)->first();

            if (! $dealer || ! $bde) {
                $parts = [];
                if (! $dealer) {
                    $parts[] = "Dealer Alias ID '{$dealerAlias}' not found";
                }
                if (! $bde) {
                    $parts[] = "BDE Emp Code '{$bdeEmpCode}' not found";
                }
                $notFound[] = implode(' and ', $parts);
                continue;
            }

            // Live mapping already exists
            $live = DealerMapping::where('dealer_id', $dealer->id)
                ->where('bde_id', $bde->id)
                ->first();
            if ($live) {
                $duplicates[] = "{$dealerAlias} -> {$bdeEmpCode}";
                continue;
            }

            // Soft-deleted mapping for same pair -> restore (clears deleted_at)
            $trashed = DealerMapping::onlyTrashed()
                ->where('dealer_id', $dealer->id)
                ->where('bde_id', $bde->id)
                ->first();
            if ($trashed) {
                $trashed->restore();
                $restored++;
                $count++;
                continue;
            }

            try {
                DealerMapping::create([
                    'dealer_id' => $dealer->id,
                    'bde_id' => $bde->id,
                ]);
                $count++;
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                $trashed = DealerMapping::onlyTrashed()
                    ->where('dealer_id', $dealer->id)
                    ->where('bde_id', $bde->id)
                    ->first();
                if ($trashed) {
                    $trashed->restore();
                    $restored++;
                    $count++;
                } else {
                    $duplicates[] = "{$dealerAlias} -> {$bdeEmpCode}";
                }
            }
        }

        if ($count === 0 && ! empty($duplicates) && empty($notFound)) {
            $message = 'These dealer mappings already exist and cannot be imported: ' . implode(', ', array_unique($duplicates));
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        if ($count === 0 && ! empty($notFound)) {
            $message = implode('; ', array_unique($notFound));
            if (! empty($duplicates)) {
                $message .= '. Also already exist: ' . implode(', ', array_unique($duplicates));
            }
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        if ($count === 0) {
            $message = 'No valid rows found to import. Required columns: Dealer Alias ID, BDE Emp Code (both must already exist in the system).';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        $message = $count . ' dealer mapping(s) imported successfully.';
        if ($restored > 0) {
            $message .= ' (' . $restored . ' previously deleted mapping(s) restored.)';
        }
        if (! empty($duplicates)) {
            $message .= ' Skipped (already exist): ' . implode(', ', array_unique($duplicates));
        }
        if (! empty($notFound)) {
            $message .= ' Skipped (not found): ' . implode('; ', array_unique($notFound));
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('dealer-mapping.index')->with('success', $message);
    }

    // Org hierarchy screen: Telecaller -> Manager -> SO -> BDE
    // Change 3: this used to be a button inside the Dealer Mapping section;
    // it's now only reachable from the sidebar (Masters -> View Hierarchy).
    public function hierarchy()
    {
        $tree = $this->buildHierarchyTree();

        return view('dealer_mapping.hierarchy', compact('tree'));
    }

    // form to link a child user under a parent user in the hierarchy
    public function mapUserForm()
    {
        $roles = Role::orderBy('level')->get();
        $users = User::with('role')->orderBy('name')->get();

        return view('dealer_mapping.map_user', compact('roles', 'users'));
    }

    public function mapUserStore(Request $request)
    {
        $data = $request->validate(['parent_id' => 'required|exists:users,id', 'child_id' => 'required|exists:users,id|different:parent_id']);

        // Change 4: parent must be a higher hierarchy level than the child
        // (Telecaller -> Manager -> SO -> BDE order only). Reject anything else.
        $error = $this->validateHierarchyOrder((int) $data['parent_id'], (int) $data['child_id']);

        if ($error) {
            return back()->withInput()->withErrors(['child_id' => $error]);
        }

        $this->createUserMapping((int) $data['parent_id'], (int) $data['child_id']);

        return redirect()->route('dealer-mapping.hierarchy')->with('success', 'User linked in hierarchy successfully.');
    }


    private function mappingRules(): array
    {
        return [
            'dealer_id' => ['required', 'exists:dealers,id'],
            'bde_id' => ['required', 'exists:users,id'],
        ];
    }

    private function buildHierarchyTree(): array
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

    private function validateHierarchyOrder(int $parentId, int $childId): ?string
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
            return 'Invalid mapping: parent must be a higher level than the child. Only the order Telecaller → Manager → SO → BDE is allowed as parent → child.';
        }
        return null;
    }

    private function createUserMapping(int $parentId, int $childId)
    {
        return \App\Models\UserMapping::firstOrCreate([
            'parent_id' => $parentId,
            'child_id' => $childId,
        ]);
    }
}

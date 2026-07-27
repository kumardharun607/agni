<?php

namespace App\Http\Controllers\DealerMapping;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealerMapping\DealerMappingRequest;
use App\Http\Requests\DealerMapping\MapUserRequest;
use App\Models\Dealer;
use App\Models\DealerMapping;
use App\Models\Role;
use App\Models\User;
use App\Services\DealerMappingService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealerMappingController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly DealerMappingService $service,
        private readonly RoleService $roleService,
        private readonly UserService $userService,
    ) {
    }

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
        $bdes = $this->userService->getByRoleName('BDE');

        return view('dealer_mapping.create', compact('dealers', 'bdes'));
    }

    public function store(DealerMappingRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Dealer mapped to BDE successfully.', 'redirect' => route('dealer-mapping.index')]);
        }

        return redirect()->route('dealer-mapping.index')->with('success', 'Dealer mapped to BDE successfully.');
    }

    public function edit(DealerMapping $dealer_mapping)
    {
        $dealers = Dealer::orderBy('name')->get();
        $bdes = $this->userService->getByRoleName('BDE');

        return view('dealer_mapping.edit', ['item' => $dealer_mapping, 'dealers' => $dealers, 'bdes' => $bdes]);
    }

    // Change 6: read-only view of a Dealer -> BDE mapping row.
    public function show(DealerMapping $dealer_mapping)
    {
        $dealers = Dealer::orderBy('name')->get();
        $bdes = $this->userService->getByRoleName('BDE');

        return view('dealer_mapping.edit', [
            'item' => $dealer_mapping,
            'dealers' => $dealers,
            'bdes' => $bdes,
            'readonly' => true,
        ]);
    }

    public function update(DealerMappingRequest $request, DealerMapping $dealer_mapping)
    {
        $this->service->update($dealer_mapping->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Mapping updated successfully.', 'redirect' => route('dealer-mapping.index')]);
        }

        return redirect()->route('dealer-mapping.index')->with('success', 'Mapping updated successfully.');
    }

    public function destroy(DealerMapping $dealer_mapping)
    {
        $this->service->delete($dealer_mapping->id);

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
        $rows = $this->readCsv($request->file('file'));

        $count = 0;
        foreach ($rows as $row) {
            $dealerAlias = $this->csvValue($row, 'Dealer Alias ID');
            $bdeEmpCode = $this->csvValue($row, 'BDE Emp Code');
            $dealer = $dealerAlias ? Dealer::where('alias_id', $dealerAlias)->first() : null;
            $bde = $bdeEmpCode ? User::where('emp_code', $bdeEmpCode)->first() : null;
            if (! $dealer || ! $bde) {
                continue;
            }
            $this->service->firstOrCreate(['dealer_id' => $dealer->id, 'bde_id' => $bde->id]);
            $count++;
        }

        $message = "$count dealer mappings imported successfully.";
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
        $tree = $this->service->buildHierarchyTree();

        return view('dealer_mapping.hierarchy', compact('tree'));
    }

    // form to link a child user under a parent user in the hierarchy
    public function mapUserForm()
    {
        $roles = $this->roleService->getAllOrderedByLevel();
        $users = User::with('role')->orderBy('name')->get();

        return view('dealer_mapping.map_user', compact('roles', 'users'));
    }

    public function mapUserStore(MapUserRequest $request)
    {
        $data = $request->validated();

        // Change 4: parent must be a higher hierarchy level than the child
        // (Telecaller -> Manager -> SO -> BDE order only). Reject anything else.
        $error = $this->service->validateHierarchyOrder((int) $data['parent_id'], (int) $data['child_id']);

        if ($error) {
            return back()->withInput()->withErrors(['child_id' => $error]);
        }

        $this->service->createUserMapping((int) $data['parent_id'], (int) $data['child_id']);

        return redirect()->route('dealer-mapping.hierarchy')->with('success', 'User linked in hierarchy successfully.');
    }
}

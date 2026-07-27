<?php

namespace App\Http\Controllers\PermissionDropdown;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionDropdown\PermissionDropdownRequest;
use App\Models\PermissionDropdown;
use App\Services\PermissionDropdownService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionDropdownController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly PermissionDropdownService $service
    ) {
    }

    public function index()
    {
        return view('permission_dropdown.index');
    }

    public function data()
    {
        return DataTables::of(PermissionDropdown::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('permission_dropdown.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('permission_dropdown.create');
    }

    public function store(PermissionDropdownRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Feature added successfully.', 'redirect' => route('permission-dropdown.index')]);
        }

        return redirect()->route('permission-dropdown.index')->with('success', 'Feature added successfully.');
    }

    public function edit(PermissionDropdown $permission_dropdown)
    {
        return view('permission_dropdown.edit', ['item' => $permission_dropdown]);
    }

    // Change 6: read-only view of a feature row.
    public function show(PermissionDropdown $permission_dropdown)
    {
        return view('permission_dropdown.edit', ['item' => $permission_dropdown, 'readonly' => true]);
    }

    public function update(PermissionDropdownRequest $request, PermissionDropdown $permission_dropdown)
    {
        $this->service->update($permission_dropdown->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Feature updated successfully.', 'redirect' => route('permission-dropdown.index')]);
        }

        return redirect()->route('permission-dropdown.index')->with('success', 'Feature updated successfully.');
    }

    public function destroy(PermissionDropdown $permission_dropdown)
    {
        $this->service->delete($permission_dropdown->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('permission_dropdown.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PermissionDropdownExport,
            'permission-dropdown.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));

        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name');
            if (! $name) {
                continue;
            }
            $this->service->firstOrCreate(['name' => $name]);
            $count++;
        }

        $message = "$count features imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('permission-dropdown.index')->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\PermissionDropdown;

use App\Http\Controllers\Controller;
use App\Models\PermissionDropdown;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionDropdownController extends Controller
{
    use HasCsvIO;

    

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

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        PermissionDropdown::create($data);

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

    public function update(Request $request, PermissionDropdown $permission_dropdown)
    {
        $data = $request->validate($this->rules($permission_dropdown->id));
        $permission_dropdown->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Feature updated successfully.', 'redirect' => route('permission-dropdown.index')]);
        }

        return redirect()->route('permission-dropdown.index')->with('success', 'Feature updated successfully.');
    }

    public function destroy(PermissionDropdown $permission_dropdown)
    {
        $permission_dropdown->delete();

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
            PermissionDropdown::firstOrCreate(['name' => $name]);
            $count++;
        }

        $message = "$count features imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('permission-dropdown.index')->with('success', $message);
    }


    private function rules(?int $id = null): array
    {
        return ['name' => ['required', 'string', 'max:255']];
    }
}

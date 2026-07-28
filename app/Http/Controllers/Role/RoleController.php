<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    use HasCsvIO;

    

    public function index()
    {
        return view('roles.index');
    }

    public function data()
    {
        return DataTables::of(Role::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('roles.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        Role::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Role created successfully.', 'redirect' => route('roles.index')]);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate($this->rules($role->id));
        $role->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Role updated successfully.', 'redirect' => route('roles.index')]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('roles.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RoleExport,
            'roles.xlsx'
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
            Role::updateOrCreate(['name' => $name], ['level' => $this->csvValue($row, 'Level')]);
            $count++;
        }

        $message = "$count roles imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('roles.index')->with('success', $message);
    }


    private function rules(?int $id = null): array
    {
        return ['name' => ['required', 'string', 'max:255'], 'level' => ['nullable', 'integer']];
    }
}

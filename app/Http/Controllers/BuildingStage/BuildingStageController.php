<?php

namespace App\Http\Controllers\BuildingStage;

use App\Http\Controllers\Controller;
use App\Models\BuildingStage;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BuildingStageController extends Controller
{
    use HasCsvIO;

    public function index()
    {
        return view('building-stages.index');
    }

    public function data()
    {
        return DataTables::of(BuildingStage::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('building-stages.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('building-stages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:building_stage,name'],
        ], [
            'name.required' => 'Building stage name is required.',
            'name.unique' => 'This building stage already exists.',
        ]);

        BuildingStage::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Building stage created successfully.', 'redirect' => route('building-stages.index')]);
        }

        return redirect()->route('building-stages.index')->with('success', 'Building stage created successfully.');
    }

    public function edit(BuildingStage $building_stage)
    {
        return view('building-stages.edit', ['item' => $building_stage]);
    }

    public function show(BuildingStage $building_stage)
    {
        return view('building-stages.edit', ['item' => $building_stage, 'readonly' => true]);
    }

    public function update(Request $request, BuildingStage $building_stage)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('building_stage', 'name')->ignore($building_stage->id)],
        ], [
            'name.required' => 'Building stage name is required.',
            'name.unique' => 'This building stage already exists.',
        ]);

        $building_stage->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Building stage updated successfully.', 'redirect' => route('building-stages.index')]);
        }

        return redirect()->route('building-stages.index')->with('success', 'Building stage updated successfully.');
    }

    public function destroy(BuildingStage $building_stage)
    {
        $building_stage->delete();

        return response()->json(['success' => true, 'message' => 'Building stage deleted successfully.']);
    }

    public function importForm()
    {
        return view('building-stages.import');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\BuildingStagesExport, 'building-stages.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));
        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name');
            if (! $name) {
                continue;
            }
            BuildingStage::firstOrCreate(['name' => $name]);
            $count++;
        }
        $message = "$count building stages imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('building-stages.index')->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\FloorStage;

use App\Http\Controllers\Controller;
use App\Models\FloorStage;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class FloorStageController extends Controller
{
    use HasCsvIO;

    public function index()
    {
        return view('floor-stages.index');
    }

    public function data()
    {
        return DataTables::of(FloorStage::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('floor-stages.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('floor-stages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:floor_stage,name'],
        ], [
            'name.required' => 'Floor stage name is required.',
            'name.unique' => 'This floor stage already exists.',
        ]);

        FloorStage::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Floor stage created successfully.', 'redirect' => route('floor-stages.index')]);
        }

        return redirect()->route('floor-stages.index')->with('success', 'Floor stage created successfully.');
    }

    public function edit(FloorStage $floor_stage)
    {
        return view('floor-stages.edit', ['item' => $floor_stage]);
    }

    public function show(FloorStage $floor_stage)
    {
        return view('floor-stages.edit', ['item' => $floor_stage, 'readonly' => true]);
    }

    public function update(Request $request, FloorStage $floor_stage)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('floor_stage', 'name')->ignore($floor_stage->id)],
        ], [
            'name.required' => 'Floor stage name is required.',
            'name.unique' => 'This floor stage already exists.',
        ]);

        $floor_stage->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Floor stage updated successfully.', 'redirect' => route('floor-stages.index')]);
        }

        return redirect()->route('floor-stages.index')->with('success', 'Floor stage updated successfully.');
    }

    public function destroy(FloorStage $floor_stage)
    {
        $floor_stage->delete();

        return response()->json(['success' => true, 'message' => 'Floor stage deleted successfully.']);
    }

    public function importForm()
    {
        return view('floor-stages.import');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\FloorStagesExport, 'floor-stages.xlsx');
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
            FloorStage::firstOrCreate(['name' => $name]);
            $count++;
        }
        $message = "$count floor stages imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('floor-stages.index')->with('success', $message);
    }
}

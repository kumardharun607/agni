<?php

namespace App\Http\Controllers\SalesStage;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesStage\SalesStageRequest;
use App\Models\SalesStage;
use App\Services\SalesStageService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesStageController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly SalesStageService $service
    ) {
    }

    public function index()
    {
        return view('sales_stage.index');
    }

    public function data()
    {
        return DataTables::of(SalesStage::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('sales_stage.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('sales_stage.create');
    }

    public function store(SalesStageRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Sales stage created successfully.', 'redirect' => route('sales-stage.index')]);
        }

        return redirect()->route('sales-stage.index')->with('success', 'Sales stage created successfully.');
    }

    public function edit(SalesStage $sales_stage)
    {
        return view('sales_stage.edit', ['item' => $sales_stage]);
    }

    // Change 6: read-only view of a sales stage row.
    public function show(SalesStage $sales_stage)
    {
        return view('sales_stage.edit', ['item' => $sales_stage, 'readonly' => true]);
    }

    public function update(SalesStageRequest $request, SalesStage $sales_stage)
    {
        $this->service->update($sales_stage->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Sales stage updated successfully.', 'redirect' => route('sales-stage.index')]);
        }

        return redirect()->route('sales-stage.index')->with('success', 'Sales stage updated successfully.');
    }

    public function destroy(SalesStage $sales_stage)
    {
        $this->service->delete($sales_stage->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('sales_stage.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SalesStageExport,
            'sales-stage.xlsx'
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

        $message = "$count sales stages imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('sales-stage.index')->with('success', $message);
    }
}

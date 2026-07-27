<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryRequest;
use App\Models\Country;
use App\Services\CountryService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly CountryService $service
    ) {
    }

    public function index()
    {
        return view('masters.countries.index');
    }

    public function data()
    {
        return DataTables::of(Country::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('masters.countries.columns.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('masters.countries.create');
    }

    public function store(CountryRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Country created successfully.', 'redirect' => route('countries.index')]);
        }

        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        return view('masters.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $this->service->update($country->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Country updated successfully.', 'redirect' => route('countries.index')]);
        }

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $this->service->delete($country->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('masters.countries.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CountryExport,
            'countries.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        try {
            $rows = $this->readSpreadsheet($request->file('file'), [['Name', 'name', 'country_name']]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => collect($e->errors())->flatten()->first()], 422);
            }
            return back()->withErrors($e->errors());
        }
        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'country_name');
            if (! $name) {
                continue;
            }
            $code = $this->csvValue($row, 'Code') ?: $this->csvValue($row, 'code');
            $this->service->updateOrCreate(['name' => $name], ['code' => $code]);
            $count++;
        }
        if ($count === 0) {
            $message = 'No valid rows found to import. Check that the Name column has values.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }
        $message = "$count countries imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('countries.index')->with('success', $message);
    }
}

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

        $ext = strtolower($request->file('file')->getClientOriginalExtension());
        $count = 0;

        if (in_array($ext, ['xlsx', 'xls'])) {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\CountryImport, $request->file('file'));
            $count = 'file';
            $message = 'Countries imported successfully.';
        } else {
            $rows = $this->readCsv($request->file('file'));
            foreach ($rows as $row) {
                $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'country_name');
                if (! $name) {
                    continue;
                }
                $this->service->updateOrCreate(['name' => $name], ['code' => $this->csvValue($row, 'Code') ?: $this->csvValue($row, 'code')]);
                $count++;
            }
            $message = "$count countries imported successfully.";
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('countries.index')->with('success', $message);
    }
}

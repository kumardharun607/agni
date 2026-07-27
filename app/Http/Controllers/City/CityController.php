<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CityRequest;
use App\Models\City;
use App\Models\State;
use App\Services\CityService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly CityService $service
    ) {
    }

    public function index()
    {
        return view('masters.cities.index');
    }

    public function data()
    {
        return DataTables::of(City::with('state'))
            ->addIndexColumn()
            ->addColumn('state_name', fn ($row) => $row->state->name ?? '-')
            ->addColumn('action', fn ($row) => view('masters.cities.columns.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $states = State::orderBy('name')->get();

        return view('masters.cities.create', compact('states'));
    }

    public function store(CityRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'City created successfully.', 'redirect' => route('cities.index')]);
        }

        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        $states = State::orderBy('name')->get();

        return view('masters.cities.edit', compact('city', 'states'));
    }

    public function update(CityRequest $request, City $city)
    {
        $this->service->update($city->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'City updated successfully.', 'redirect' => route('cities.index')]);
        }

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $this->service->delete($city->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('masters.cities.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CityExport,
            'cities.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));

        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'city_name');
            $stateName = $this->csvValue($row, 'State') ?: $this->csvValue($row, 'state');
            $state = $stateName ? State::where('name', $stateName)->first() : null;
            if (! $name || ! $state) {
                continue;
            }
            $this->service->updateOrCreate(['name' => $name, 'state_id' => $state->id]);
            $count++;
        }

        $message = "$count cities imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('cities.index')->with('success', $message);
    }
}

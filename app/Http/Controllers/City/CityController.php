<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    use HasCsvIO;
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

    public function store(Request $request)
    {
        // validation + create handled below
        $data = $request->validate($this->rules());
        City::create($data);

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

    public function update(Request $request, City $city)
    {
        $data = $request->validate($this->rules($city->id));
        $city->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'City updated successfully.', 'redirect' => route('cities.index')]);
        }

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

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
        try {
            $rows = $this->readSpreadsheet($request->file('file'), [['Name', 'name', 'city_name'], ['State', 'state']]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => collect($e->errors())->flatten()->first()], 422);
            }
            return back()->withErrors($e->errors());
        }

        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'city_name');
            $stateName = $this->csvValue($row, 'State') ?: $this->csvValue($row, 'state');
            $state = $stateName ? State::where('name', $stateName)->first() : null;
            if (! $name || ! $state) {
                continue;
            }
            City::updateOrCreate(['name' => $name, 'state_id' => $state->id]);
            $count++;
        }

        if ($count === 0) {
            $message = 'No valid rows found. Required columns: Name, State (state must already exist).';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }
        $message = "$count cities imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('cities.index')->with('success', $message);
    }


    private function rules(?int $id = null): array
    {
        return [
            'state_id' => ['required', 'exists:states,id'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}

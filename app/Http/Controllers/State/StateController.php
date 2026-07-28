<?php

namespace App\Http\Controllers\State;

use App\Http\Controllers\Controller;
use App\Http\Requests\State\StateRequest;
use App\Models\Country;
use App\Models\State;
use App\Services\StateService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly StateService $service
    ) {
    }

    public function index()
    {
        return view('masters.states.index');
    }

    public function data()
    {
        return DataTables::of(State::with('country'))
            ->addIndexColumn()
            ->addColumn('country_name', fn ($row) => $row->country->name ?? '-')
            ->addColumn('action', fn ($row) => view('masters.states.columns.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('masters.states.create', compact('countries'));
    }

    public function store(StateRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'State created successfully.', 'redirect' => route('states.index')]);
        }

        return redirect()->route('states.index')->with('success', 'State created successfully.');
    }

    public function edit(State $state)
    {
        $countries = Country::orderBy('name')->get();

        return view('masters.states.edit', compact('state', 'countries'));
    }

    public function update(StateRequest $request, State $state)
    {
        $this->service->update($state->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'State updated successfully.', 'redirect' => route('states.index')]);
        }

        return redirect()->route('states.index')->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        $this->service->delete($state->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('masters.states.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\StateExport,
            'states.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        try {
            $rows = $this->readSpreadsheet($request->file('file'), [['Name', 'name', 'state_name'], ['Country', 'country']]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => collect($e->errors())->flatten()->first()], 422);
            }
            return back()->withErrors($e->errors());
        }

        $count = 0;
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'state_name');
            $countryName = $this->csvValue($row, 'Country') ?: $this->csvValue($row, 'country');
            if (! $name || ! $countryName) {
                continue;
            }
            $country = Country::firstOrCreate(['name' => $countryName]);
            $this->service->updateOrCreate(['name' => $name, 'country_id' => $country->id]);
            $count++;
        }

        if ($count === 0) {
            $message = 'No valid rows found. Required columns: Name, Country.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }
        $message = "$count states imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('states.index')->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    use HasCsvIO;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('countries', 'name')->whereNull('deleted_at'),
            ],
            'code' => ['nullable', 'string', 'max:10'],
        ], [
            'name.unique' => 'This country already exists.',
            'name.required' => 'Country name is required.',
        ]);

        $trashed = Country::onlyTrashed()->where('name', $data['name'])->first();
        if ($trashed) {
            $trashed->restore();
            $trashed->update($data);
        } else {
            Country::create($data);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Country created successfully.', 'redirect' => route('countries.index')]);
        }

        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        return view('masters.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('countries', 'name')->whereNull('deleted_at')->ignore($country->id),
            ],
            'code' => ['nullable', 'string', 'max:10'],
        ], [
            'name.unique' => 'This country already exists.',
        ]);

        $country->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Country updated successfully.', 'redirect' => route('countries.index')]);
        }

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $country->delete();

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
        $duplicates = [];
        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name') ?: $this->csvValue($row, 'name') ?: $this->csvValue($row, 'country_name');
            if (! $name) {
                continue;
            }
            $name = trim($name);
            $code = $this->csvValue($row, 'Code') ?: $this->csvValue($row, 'code');

            $existing = Country::where('name', $name)->first();
            if ($existing) {
                $duplicates[] = $name;
                continue;
            }

            $trashed = Country::onlyTrashed()->where('name', $name)->first();
            if ($trashed) {
                $trashed->restore();
                $trashed->update(['code' => $code]);
                $count++;
                continue;
            }

            Country::create(['name' => $name, 'code' => $code]);
            $count++;
        }

        if (! empty($duplicates) && $count === 0) {
            $message = 'These countries already exist and cannot be imported: ' . implode(', ', array_unique($duplicates));
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        if ($count === 0) {
            $message = 'No valid rows found to import. Check that the Name column has values.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        $message = "$count countries imported successfully.";
        if (! empty($duplicates)) {
            $message .= ' Skipped (already exist): ' . implode(', ', array_unique($duplicates));
        }
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('countries.index')->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\Pincode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pincode\PincodeRequest;
use App\Models\City;
use App\Models\Pincode;
use App\Services\PincodeService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PincodeController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly PincodeService $service
    ) {
    }

    public function index()
    {
        return view('masters.pincodes.index');
    }

    public function data()
    {
        return DataTables::of(Pincode::with('city.state.country'))
            ->addIndexColumn()
            ->addColumn('country_name', fn ($row) => $row->city->state->country->name ?? '-')
            ->addColumn('state_name', fn ($row) => $row->city->state->name ?? '-')
            ->addColumn('city_name', fn ($row) => $row->city->name ?? '-')
            ->addColumn('status', fn ($row) => '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Active</span>')
            ->addColumn('action', fn ($row) => view('masters.pincodes.columns.action', compact('row'))->render())
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();

        return view('masters.pincodes.create', compact('cities'));
    }

    public function store(PincodeRequest $request)
    {
        $this->service->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pincode created successfully.', 'redirect' => route('pincodes.index')]);
        }

        return redirect()->route('pincodes.index')->with('success', 'Pincode created successfully.');
    }

    public function edit(Pincode $pincode)
    {
        $cities = City::orderBy('name')->get();

        return view('masters.pincodes.edit', compact('pincode', 'cities'));
    }

    public function update(PincodeRequest $request, Pincode $pincode)
    {
        $this->service->update($pincode->id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pincode updated successfully.', 'redirect' => route('pincodes.index')]);
        }

        return redirect()->route('pincodes.index')->with('success', 'Pincode updated successfully.');
    }

    public function destroy(Pincode $pincode)
    {
        $this->service->delete($pincode->id);

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('masters.pincodes.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PincodeExport,
            'pincodes.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));

        $count = 0;
        foreach ($rows as $row) {
            $cityName = $this->csvValue($row, 'City') ?: $this->csvValue($row, 'city');
            $pincode = $this->csvValue($row, 'Pincode') ?: $this->csvValue($row, 'pincode');
            $city = $cityName ? City::where('name', $cityName)->first() : null;
            if (! $city || ! $pincode) {
                continue;
            }
            $this->service->updateOrCreate(['city_id' => $city->id, 'pincode' => $pincode]);
            $count++;
        }

        $message = "$count pincodes imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('pincodes.index')->with('success', $message);
    }
}

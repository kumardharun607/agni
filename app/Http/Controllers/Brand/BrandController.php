<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    use HasCsvIO;

    public function index()
    {
        return view('brands.index');
    }

    public function data()
    {
        return DataTables::of(Brand::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($row) => view('brands.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
        ], [
            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists.',
        ]);

        Brand::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Brand created successfully.', 'redirect' => route('brands.index')]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function show(Brand $brand)
    {
        return view('brands.edit', ['brand' => $brand, 'readonly' => true]);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($brand->id)],
        ], [
            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists.',
        ]);

        $brand->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Brand updated successfully.', 'redirect' => route('brands.index')]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
    }

    public function importForm()
    {
        return view('brands.import');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\BrandsExport, 'brands.xlsx');
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
            Brand::firstOrCreate(['name' => $name]);
            $count++;
        }
        $message = "$count brands imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('brands.index')->with('success', $message);
    }
}

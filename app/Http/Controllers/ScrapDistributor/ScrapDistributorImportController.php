<?php

namespace App\Http\Controllers\ScrapDistributor;

use App\Http\Controllers\Controller;
use App\Exports\ScrapDistributorExport;
use App\Imports\ScrapDistributorImport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ScrapDistributorImportController extends Controller
{
    public function index()
    {
        return view('scrap-distributors.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ScrapDistributorImport, $request->file('file'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Throwable $e) {
            return back()->withErrors([
                'file' => 'Invalid file or column names. Please export Scrap Distributors first and use the same column headers (name is required).',
            ]);
        }

        return redirect()->route('scrap-distributors.index')->with('success', 'Scrap Distributors imported successfully.');
    }

    public function export()
    {
        return Excel::download(new ScrapDistributorExport, 'scrap_distributors.xlsx');
    }
}

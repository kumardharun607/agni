<?php

namespace App\Http\Controllers\ScrapSeller;

use App\Http\Controllers\Controller;
use App\Exports\ScrapSellerExport;
use App\Imports\ScrapSellerImport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ScrapSellerImportController extends Controller
{
    public function index()
    {
        return view('scrap-sellers.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new ScrapSellerImport, $request->file('file'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Throwable $e) {
            return back()->withErrors([
                'file' => 'Invalid file or column names. Please export Scrap Sellers first and use the same column headers (company_name is required).',
            ]);
        }

        return redirect()->route('scrap-sellers.index')->with('success', 'Scrap Sellers imported successfully.');
    }

    public function export()
    {
        return Excel::download(new ScrapSellerExport, 'scrap_sellers.xlsx');
    }
}

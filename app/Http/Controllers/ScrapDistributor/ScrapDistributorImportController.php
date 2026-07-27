<?php

namespace App\Http\Controllers\ScrapDistributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ScrapDistributorImport;
use App\Exports\ScrapDistributorExport;

class ScrapDistributorImportController extends Controller
{
    public function index()
    {
        return view('scrap-distributors.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(
            new ScrapDistributorImport,
            $request->file('file')
        );

        return redirect()
            ->route('scrap-distributors.index')
            ->with('success', 'Import Completed Successfully');
    }

    public function export()
    {
        return Excel::download(
            new ScrapDistributorExport,
            'scrap_distributors.xlsx'
        );
    }
}
<?php

namespace App\Http\Controllers\BdeHomeLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\BdeHomeLocationImport;
use App\Exports\BdeHomeLocationExport;

class BdeHomeLocationImportController extends Controller
{
    public function index()
    {
        return view('bde-home-locations.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(
            new BdeHomeLocationImport,
            $request->file('file')
        );

        return redirect()->route('bde-home-locations.index')->with('success', 'BDE Home Locations imported successfully.');
    }

    public function export()
    {
        return Excel::download(
            new BdeHomeLocationExport,
            'bde_home_locations.xlsx'
        );
    }
}
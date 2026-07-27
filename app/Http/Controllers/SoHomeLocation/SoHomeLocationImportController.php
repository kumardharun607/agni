<?php

namespace App\Http\Controllers\SoHomeLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\SoHomeLocationImport;
use App\Exports\SoHomeLocationExport;

class SoHomeLocationImportController extends Controller
{
    public function index()
    {
        return view('so-home-locations.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(
            new SoHomeLocationImport,
            $request->file('file')
        );

        return redirect()->route('so-home-locations.index')->with('success', 'SO Home Locations imported successfully.');
    }

    public function export()
    {
        return Excel::download(
            new SoHomeLocationExport,
            'so_home_locations.xlsx'
        );
    }
}
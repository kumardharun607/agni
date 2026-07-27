<?php

namespace App\Http\Controllers\ScrapSeller;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ScrapSellerImport;
use App\Exports\ScrapSellerExport;



class ScrapSellerImportController extends Controller
{


    public function index()
    {

        return view('scrap-sellers.import');

    }



    public function store(Request $request)
    {


        $request->validate([

            'file'=>'required|mimes:xlsx,csv,xls'

        ]);


        Excel::import(

            new ScrapSellerImport,

            $request->file('file')

        );


        return redirect()->route('scrap-sellers.index')->with('success', 'Scrap Sellers imported successfully.');

    }




    public function export()
    {


        return Excel::download(

            new ScrapSellerExport,

            'scrap_sellers.xlsx'

        );


    }



}
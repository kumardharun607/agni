<?php

namespace App\Http\Controllers\ScrapSeller;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScrapSellerImport;
use App\Exports\ScrapSellerExport;
=======
use App\Exports\ScrapSellerExport;
use App\Imports\ScrapSellerImport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
>>>>>>> b1d09de9960bbbdde66a81dfd9cc085dec352046

class ScrapSellerImportController extends Controller
{
    public function index()
    {
        return view('scrap-sellers.import');
    }

    public function store(Request $request)
    {
        $request->validate([
<<<<<<< HEAD
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        try {
            Excel::import(
                new ScrapSellerImport,
                $request->file('file')
            );

            return redirect()
                ->route('scrap-sellers.index')
                ->with('success', 'Scrap Sellers imported successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Import validation failed: ' . implode(' | ', $messages));
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (
                stripos($msg, 'column') !== false ||
                stripos($msg, 'undefined array key') !== false ||
                stripos($msg, 'SQLSTATE') !== false
            ) {
                return back()->with(
                    'error',
                    'Column mismatch. Please upload a file with the correct headers: ' .
                    implode(', ', ScrapSellerImport::$expectedHeadings)
                );
            }
            return back()->with('error', 'Import failed: ' . $msg);
        }
=======
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
>>>>>>> b1d09de9960bbbdde66a81dfd9cc085dec352046
    }

    public function export()
    {
<<<<<<< HEAD
        return Excel::download(
            new ScrapSellerExport,
            'scrap_sellers.xlsx'
        );
=======
        return Excel::download(new ScrapSellerExport, 'scrap_sellers.xlsx');
>>>>>>> b1d09de9960bbbdde66a81dfd9cc085dec352046
    }
}

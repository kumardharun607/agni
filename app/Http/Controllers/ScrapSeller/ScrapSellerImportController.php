<?php

namespace App\Http\Controllers\ScrapSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
    }

    public function export()
    {
        return Excel::download(
            new ScrapSellerExport,
            'scrap_sellers.xlsx'
        );
    }
}

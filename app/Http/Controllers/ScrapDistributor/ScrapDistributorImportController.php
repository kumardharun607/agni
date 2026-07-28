<?php

namespace App\Http\Controllers\ScrapDistributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

        try {
            Excel::import(
                new ScrapDistributorImport,
                $request->file('file')
            );

            return redirect()
                ->route('scrap-distributors.index')
                ->with('success', 'Import Completed Successfully');
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
                    implode(', ', ScrapDistributorImport::$expectedHeadings)
                );
            }
            return back()->with('error', 'Import failed: ' . $msg);
        }
    }

    public function export()
    {
        return Excel::download(
            new ScrapDistributorExport,
            'scrap_distributors.xlsx'
        );
    }
}

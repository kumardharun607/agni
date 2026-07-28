<?php

namespace App\Http\Controllers\BdeHomeLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

        try {
            Excel::import(
                new BdeHomeLocationImport,
                $request->file('file')
            );

            return redirect()
                ->route('bde-home-locations.index')
                ->with('success', 'BDE Home Locations imported successfully.');
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
                    implode(', ', BdeHomeLocationImport::$expectedHeadings)
                );
            }
            return back()->with('error', 'Import failed: ' . $msg);
        }
    }

    public function export()
    {
        return Excel::download(
            new BdeHomeLocationExport,
            'bde_home_locations.xlsx'
        );
    }
}

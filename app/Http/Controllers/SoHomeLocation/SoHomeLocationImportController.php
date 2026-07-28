<?php

namespace App\Http\Controllers\SoHomeLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

        try {
            Excel::import(
                new SoHomeLocationImport,
                $request->file('file')
            );

            return redirect()
                ->route('so-home-locations.index')
                ->with('success', 'SO Home Locations imported successfully.');
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
                    implode(', ', SoHomeLocationImport::$expectedHeadings)
                );
            }
            return back()->with('error', 'Import failed: ' . $msg);
        }
    }

    public function export()
    {
        return Excel::download(
            new SoHomeLocationExport,
            'so_home_locations.xlsx'
        );
    }
}

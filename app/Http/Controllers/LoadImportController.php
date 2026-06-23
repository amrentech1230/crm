<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LoadsImport;
use Maatwebsite\Excel\Facades\Excel;

class LoadImportController extends Controller
{
    // ✅ This method displays the upload form
    public function showForm()
    {
        return view('import');
    }

    // ✅ This method processes the Excel file
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new LoadsImport, $request->file('file'));

        //return back()->with('success', 'Load data updated successfully!');
    }
}

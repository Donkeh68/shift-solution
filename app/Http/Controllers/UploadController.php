<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImportJob;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UploadController extends Controller
{
    // Request CSV file
    public function index(): View
    {
        // Display view
        return view('uploads.index', []);
    }

    // Process CSV file
    public function import(Request $request): View
    {
        // Validate CSV file
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
            'max' => '16mb'
        ]);

        // Process CSV file
        $result = "busy";
        $file = $request->file('csv');
        $storedFile = $file->store('csv', 'public');
        dispatch(new ProcessImportJob(storage_path('app/public/' . $storedFile)));

        // Display view with feedback from process
        return view('uploads.import')
        ->with("result", $result);
    }
}

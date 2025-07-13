<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ErrorController extends Controller
{
    // 400 Bad Request
    public function index400(): View
    {
        // Display view
        return view('errors.400');
    }
}


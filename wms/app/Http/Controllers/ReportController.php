<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReportController extends Controller
{
    public function xnt(): View
    {
        return view('reports.xnt');
    }

    public function efficiency(): View
    {
        return view('reports.efficiency');
    }

    public function abc(): View
    {
        return view('reports.abc');
    }
}

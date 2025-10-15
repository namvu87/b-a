<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(): View
    {
        return view('issues.index');
    }

    public function create(): View
    {
        return view('issues.create');
    }
}

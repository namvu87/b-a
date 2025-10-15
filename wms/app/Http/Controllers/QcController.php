<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class QcController extends Controller
{
    public function queue(): View
    {
        return view('qc.queue');
    }

    public function form(): View
    {
        return view('qc.form');
    }
}

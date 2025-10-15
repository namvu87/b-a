<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function index(): View
    {
        return view('receipts.index');
    }

    public function create(): View
    {
        return view('receipts.create');
    }
}

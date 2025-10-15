<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StocktakeController extends Controller
{
    public function planCreate(): View
    {
        return view('stocktake.plan-create');
    }

    public function execute(): View
    {
        return view('stocktake.execute');
    }

    public function reconcile(): View
    {
        return view('stocktake.reconcile');
    }
}

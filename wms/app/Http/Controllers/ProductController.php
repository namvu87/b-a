<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index');
    }

    public function show(string $id): View
    {
        return view('products.show', ['id' => $id]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index(): View
    {
        return view('ventes.index');
    }

    public function create(): View
    {
        return view('ventes.create');
    }
}

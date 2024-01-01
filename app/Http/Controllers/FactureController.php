<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index(): View
    {
        return view('factures.index');
    }

    public function create(): View
    {
        return view('factures.create');
    }

    public function detail(Facture $facture): View
    {
        return view('factures.info' , compact('facture'));
    }
}

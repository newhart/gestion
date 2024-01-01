<?php

namespace App\Http\Controllers;

use App\Models\Bonde;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function index(): View
    {
        return view('achats.index');
    }

    public function create(Bonde $bonde , string $type): View
    {
        return view('achats.create' , compact('bonde', 'type'));
    }

    public function new(): View
    {
        return view('achats.create-new');
    }

    public function choice(): View
    {
        return view('achats.choice');
    }
}

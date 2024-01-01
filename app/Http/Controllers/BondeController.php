<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BondeController extends Controller
{
    public function create()
    {
        return view('bondes.create' , ['type' => 'entry']);
    }

    public function create_entry()
    {
        return view('bondes.create' , ['type' => 'sorty']);
    }
}

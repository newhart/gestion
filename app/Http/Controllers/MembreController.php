<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function index(): View
    {
        return view('membres.index');
    }

    public function create(): View
    {
        return view('membres.create');
    }

    public function edit(User $user)
    {
        return view('membres.edit', compact('user'));
    }
}

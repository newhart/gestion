<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(): View
    {
        return view('companies.index');
    }
    public function create(): View
    {
        return view('companies.create');
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }
}

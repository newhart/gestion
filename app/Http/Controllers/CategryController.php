<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategryController extends Controller
{
    public function index(): View
    {
        return view('categories.index');
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function create_sub_category()
    {
        return \view('categories.sub-category.create');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
}

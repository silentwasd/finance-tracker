<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::all();

        return view('categories.index')
            ->with('items', $items);
    }
}

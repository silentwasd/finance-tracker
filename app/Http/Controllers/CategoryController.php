<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Structures\TransactionType;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::all();

        return view('categories.index')
            ->with('items', $items);
    }

    public function edit(Category $category)
    {
        return view('categories.edit')
            ->with('item', $category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Structures\TransactionType;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::with('transactions')
            ->get()
            ->sortByDesc(fn (Category $category) => count($category->transactions));

        return view('categories.index')
            ->with('items', $items);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $item = new Category();
        $item->name = $request->input('name');
        $item->transaction_type = TransactionType::from($request->input('type'));
        $item->save();

        return redirect()->route('categories.index');
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

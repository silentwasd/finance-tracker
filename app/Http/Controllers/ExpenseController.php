<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $items = Expense::orderBy('completed_at')->get();

        return view('expenses')
            ->with('items', $items);
    }
}

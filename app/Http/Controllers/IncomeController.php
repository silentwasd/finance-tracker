<?php

namespace App\Http\Controllers;

use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $items = Income::orderBy('completed_at')->get();

        return view('incomes')
            ->with('items', $items);
    }
}

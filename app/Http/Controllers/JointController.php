<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;

class JointController extends Controller
{
    public function index()
    {
        $incomes = Income::orderBy('completed_at')->get();
        $expenses = Expense::orderBy('completed_at')->get();

        $items = $incomes->map(fn (Income $income) => [
            'type' => 'income',
            'model' => $income
        ])->concat(
            $expenses->map(fn (Expense $expense) => [
                'type' => 'expense',
                'model' => $expense
            ])->all()
        )->sortBy(fn (array $item) => $item['model']->completed_at);

        return view('joint')
            ->with('items', $items);
    }
}

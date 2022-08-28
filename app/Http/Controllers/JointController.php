<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Structures\Money;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        return view('joint.index')
            ->with('items', $items);
    }

    public function balance()
    {
        $incomes = DB::table('incomes')
            ->selectRaw("'income' as type, sum(value) as value, completed_at")
            ->groupBy('completed_at');

        $combined = DB::table('expenses')
            ->selectRaw("'expense' as type, sum(value) as value, completed_at")
            ->groupBy('completed_at')
            ->unionAll($incomes)
            ->get();

        $result = $combined->groupBy('completed_at')
            ->map(function (Collection $row) {
                $incomes = $row->where('type', 'income')->first()->value ?? 0;
                $expenses = $row->where('type', 'expense')->first()->value ?? 0;

                return [
                    'incomes' => $incomes,
                    'expenses' => $expenses,
                    'balance' => $incomes - $expenses
                ];
            })
            ->map(fn (array $row, string $date) => [
                'incomes' => new Money($row['incomes']),
                'expenses' => new Money($row['expenses']),
                'balance' => new Money($row['balance']),
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', $date)
            ])
            ->values();

        return view('joint.balance')
            ->with('result', $result);
    }
}

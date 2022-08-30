<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Structures\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JointController extends Controller
{
    public function index()
    {
        return redirect()->route('joint.index', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $incomes = Income::orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get();

        $expenses = Expense::orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get();

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
            ->with('items', $items)
            ->with('month', $month);
    }

    public function balance()
    {
        return redirect()->route('joint.balance', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function balanceByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $incomes = DB::table('incomes')
            ->selectRaw("'income' as type, sum(value) as value, completed_at")
            ->groupBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay);

        $combined = DB::table('expenses')
            ->selectRaw("'expense' as type, sum(value) as value, completed_at")
            ->groupBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
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
            ->values()
            ->sortBy('date');

        return view('joint.balance')
            ->with('result', $result)
            ->with('month', $month);
    }
}

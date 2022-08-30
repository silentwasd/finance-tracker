<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Structures\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use UnitEnum;

class ExpenseController extends Controller
{
    public function index()
    {
        $items = Expense::orderBy('completed_at')
            ->with('expenseType')
            ->get();

        return view('expenses.index')
            ->with('items', $items);
    }

    public function stats()
    {
        return redirect()->route('expenses.stats', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function statsByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $total = 0 > 0 ? [
            'sum' => new Money( $result->sum(fn (array $expense) => $expense['value']->pennies()) ),
            'min' => new Money( $result->min(fn (array $expense) => $expense['min']->pennies()) ),
            'max' => new Money( $result->max(fn (array $expense) => $expense['max']->pennies()) )
        ] : [
            'sum' => new Money(0),
            'min' => new Money(0),
            'max' => new Money(0)
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / now()->daysInMonth );

        $months = collect(Month::cases());
        $curMonthKey = $months->search(fn (UnitEnum $unit) => $unit->name == $month->name);

        return view('expenses.stats')
            ->with('result', $this->groupedByType($firstDay, $lastDay))
            ->with('total', $total)
            ->with('months', [
                'cur' => $month->value,
                'next' => $curMonthKey + 1 < $months->count() ? $months[$curMonthKey + 1]->value : null,
                'prev' => $curMonthKey - 1 >= 0 ? $months[$curMonthKey - 1]->value : null,
            ]);
    }

    private function groupedByType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $expenses = DB::table('expenses')
            ->selectRaw('sum(value) as value, min(value) as min, max(value) as max, count(value) as count, expense_types.name as expense_type')
            ->groupBy('expense_type')
            ->join('expense_types', 'expense_type', '=', 'expense_types.id', 'left')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->orderByDesc('value')
            ->get();

        return $expenses->map(fn (object $expense) => [
            'value' => new Money($expense->value),
            'type' => $expense->expense_type,
            'min' => new Money($expense->min),
            'max' => new Money($expense->max),
            'avg' => new Money($expense->value / $expense->count)
        ]);
    }
}

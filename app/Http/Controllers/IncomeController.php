<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Structures\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use UnitEnum;

class IncomeController extends Controller
{
    public function index()
    {
        $items = Income::orderBy('completed_at')
            ->with('incomeType')
            ->get();

        return view('incomes.index')
            ->with('items', $items);
    }

    public function stats()
    {
        return redirect()->route('incomes.stats', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function statsByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $incomes = DB::table('incomes')
            ->selectRaw('sum(value) as value, min(value) as min, max(value) as max, count(value) as count, income_types.name as income_type')
            ->groupBy('income_type')
            ->join('income_types', 'income_type', '=', 'income_types.id', 'left')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->orderByDesc('value')
            ->get();

        $result = $incomes->map(fn (object $income) => [
            'value' => new Money($income->value),
            'type' => $income->income_type,
            'min' => new Money($income->min),
            'max' => new Money($income->max),
            'avg' => new Money($income->value / $income->count)
        ]);

        $total = $result->count() > 0 ? [
            'sum' => new Money( $result->sum(fn (array $income) => $income['value']->pennies()) ),
            'min' => new Money( $result->min(fn (array $income) => $income['min']->pennies()) ),
            'max' => new Money( $result->max(fn (array $income) => $income['max']->pennies()) )
        ] : [
            'sum' => new Money(0),
            'min' => new Money(0),
            'max' => new Money(0)
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / now()->daysInMonth );

        $months = collect(Month::cases());
        $curMonthKey = $months->search(fn (UnitEnum $unit) => $unit->name == $month->name);

        return view('incomes.stats')
            ->with('result', $result)
            ->with('total', $total)
            ->with('months', [
                'cur' => $month->value,
                'next' => $curMonthKey + 1 < $months->count() ? $months[$curMonthKey + 1]->value : null,
                'prev' => $curMonthKey - 1 >= 0 ? $months[$curMonthKey - 1]->value : null,
            ]);
    }
}

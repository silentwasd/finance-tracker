<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Structures\Money;
use App\Structures\Month;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return redirect()->route('incomes.stats', Str::substr(Str::lower(now()->monthName), 0, 3));
    }

    public function statsByMonth(Month $month)
    {
        $incomes = DB::table('incomes')
            ->selectRaw('sum(value) as value, min(value) as min, max(value) as max, count(value) as count, income_types.name as income_type')
            ->groupBy('income_type')
            ->join('income_types', 'income_type', '=', 'income_types.id')
            ->where('completed_at', '>=', (new Carbon(new \DateTime("first day of $month->name"))))
            ->where('completed_at', '<=', (new Carbon(new \DateTime("last day of $month->name"))))
            ->get();

        $result = $incomes->map(fn (object $income) => [
            'value' => new Money($income->value),
            'type' => $income->income_type,
            'min' => new Money($income->min),
            'max' => new Money($income->max),
            'avg' => new Money($income->value / $income->count)
        ]);

        $total = [
            'sum' => new Money( $result->count() > 0 ? $result->sum(fn (array $income) => $income['value']->pennies()) : 0 ),
            'min' => new Money( $result->count() > 0 ? $result->min(fn (array $income) => $income['min']->pennies()) : 0 ),
            'max' => new Money( $result->count() > 0 ? $result->max(fn (array $income) => $income['max']->pennies()) : 0 )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / now()->daysInMonth );

        return view('incomes.stats')
            ->with('result', $result)
            ->with('total', $total);
    }
}

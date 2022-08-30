<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Structures\Money;
use Illuminate\Support\Facades\DB;

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
        $incomes = DB::table('incomes')
            ->selectRaw('sum(value) as value, min(value) as min, max(value) as max, count(value) as count, income_types.name as income_type')
            ->groupBy('income_type')
            ->join('income_types', 'income_type', '=', 'income_types.id')
            ->where('completed_at', '>=', now()->startOfMonth())
            ->where('completed_at', '<=', now()->endOfMonth())
            ->get();

        $result = $incomes->map(fn (object $income) => [
            'value' => new Money($income->value),
            'type' => $income->income_type,
            'min' => new Money($income->min),
            'max' => new Money($income->max),
            'avg' => new Money($income->value / $income->count)
        ]);

        $total = [
            'sum' => new Money( $result->sum(fn (array $income) => $income['value']->pennies()) ),
            'min' => new Money( $result->min(fn (array $income) => $income['min']->pennies()) ),
            'max' => new Money( $result->max(fn (array $income) => $income['max']->pennies()) )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / now()->daysInMonth );

        return view('incomes.stats')
            ->with('result', $result)
            ->with('total', $total);
    }
}

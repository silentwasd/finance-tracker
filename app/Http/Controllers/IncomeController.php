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
            ->selectRaw('sum(value) as value, income_types.name as income_type')
            ->groupBy('income_type')
            ->join('income_types', 'income_type', '=', 'income_types.id')
            ->where('completed_at', '>=', now()->startOfMonth())
            ->where('completed_at', '<=', now()->endOfMonth())
            ->get();

        $result = $incomes->map(fn (object $income) => [
            'value' => new Money($income->value),
            'type' => $income->income_type
        ]);

        $total = [
            'sum' => new Money( $result->sum(fn (array $income) => $income['value']->pennies()) )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / now()->daysInMonth );

        return view('incomes.stats')
            ->with('result', $result)
            ->with('total', $total);
    }
}

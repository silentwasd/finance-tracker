<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Structures\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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
        return redirect()->route('incomes.stats', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function statsByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        return view('incomes.stats')
            ->with('type', $this->groupedByType($firstDay, $lastDay))
            ->with('total', $this->groupedByCompletedTime($firstDay, $lastDay))
            ->with('month', $month);
    }

    private function groupedByType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $incomes = DB::table('incomes')
            ->selectRaw('sum(value) as sum, min(value) as min, max(value) as max, count(value) as count, income_types.name as income_type')
            ->groupBy('income_type')
            ->join('income_types', 'income_type', '=', 'income_types.id', 'left')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->orderByDesc('sum')
            ->get();

        return $incomes->map(fn (object $income) => [
            'type' => $income->income_type,
            'sum' => new Money($income->sum),
            'min' => new Money($income->min),
            'max' => new Money($income->max),
            'avg' => new Money($income->sum / $income->count)
        ]);
    }

    private function groupedByCompletedTime(Carbon $firstDay, Carbon $lastDay): array
    {
        $incomes = DB::table('incomes')
            ->selectRaw('sum(value) as sum')
            ->groupBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $income) => [ 'sum' => new Money($income->sum) ]);

        $total = [
            'sum' => new Money( $incomes->sum(fn (array $income) => $income['sum']->pennies()) ?? 0 ),
            'min' => new Money( $incomes->min(fn (array $income) => $income['sum']->pennies()) ?? 0 ),
            'max' => new Money( $incomes->max(fn (array $income) => $income['sum']->pennies()) ?? 0 )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / $firstDay->daysInMonth );

        return $total;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Structures\Money;
use App\Structures\Month;
use App\Structures\TransactionType;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IncomeController extends Controller
{
    public function index()
    {
        return redirect()->route('incomes.index', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $items = Transaction::where('transaction_type', TransactionType::Income)
            ->orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->with('category')
            ->get();

        return view('incomes.index')
            ->with('items', $items)
            ->with('month', $month);
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
            ->with('timeAndType', $this->groupedByCompletedTimeAndType($firstDay, $lastDay))
            ->with('type', $this->groupedByType($firstDay, $lastDay))
            ->with('name', $this->groupedByName($firstDay, $lastDay))
            ->with('total', $this->groupedByCompletedTime($firstDay, $lastDay))
            ->with('month', $month);
    }

    private function groupedByType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $incomes = DB::table('transactions')
            ->selectRaw('sum(value) as sum, min(value) as min, max(value) as max, count(value) as count, categories.name as income_type')
            ->groupBy('category_id')
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', TransactionType::Income)
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
        $incomes = DB::table('transactions')
            ->selectRaw('sum(value) as sum')
            ->groupBy('completed_at')
            ->where('transaction_type', TransactionType::Income)
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

    private function groupedByCompletedTimeAndType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $incomes = DB::table('transactions')
            ->selectRaw('sum(value) as sum, categories.name as income_type')
            ->groupBy(['completed_at', 'category_id'])
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', TransactionType::Income)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $income) => [
                'type' => $income->income_type,
                'sum' => new Money($income->sum)
            ]);

        return $incomes->groupBy('type')
            ->map(fn (Collection $group, string $type) => [
                'type' => $type,
                'sum' => new Money( $group->sum( fn (array $income) => $income['sum']->pennies() ) ),
                'min' => new Money( $group->min( fn (array $income) => $income['sum']->pennies() ) ),
                'max' => new Money( $group->max( fn (array $income) => $income['sum']->pennies() ) )
            ])
            ->map(
                fn (array $group) => array_merge(
                    $group,
                    ['avg' => new Money( $group['sum']->pennies() / $firstDay->daysInMonth )]
                )
            )
            ->sortByDesc('sum')
            ->values();
    }

    private function groupedByName(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $incomes = DB::table('transactions')
            ->selectRaw('name, sum(value) as sum, min(value) as min, max(value) as max, count(value) as count')
            ->groupBy('name')
            ->where('transaction_type', TransactionType::Income)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->having('count', '>', 1)
            ->orderByDesc('sum')
            ->get();

        return $incomes->map(fn (object $income) => [
            'name' => $income->name,
            'sum' => new Money($income->sum),
            'min' => new Money($income->min),
            'max' => new Money($income->max),
            'avg' => new Money($income->sum / $income->count),
            'count' => $income->count
        ]);
    }
}

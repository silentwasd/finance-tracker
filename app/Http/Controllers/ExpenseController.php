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

class ExpenseController extends Controller
{
    public function index()
    {
        return redirect()->route('expenses.index', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $items = Transaction::where('transaction_type', TransactionType::Expense)
            ->orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->with('category')
            ->get();

        return view('expenses.index')
            ->with('items', $items)
            ->with('month', $month);
    }

    public function stats()
    {
        return redirect()->route('expenses.stats', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function statsByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        return view('expenses.stats')
            ->with('timeAndType', $this->groupedByCompletedTimeAndType($firstDay, $lastDay))
            ->with('type', $this->groupedByType($firstDay, $lastDay))
            ->with('name', $this->groupedByName($firstDay, $lastDay))
            ->with('total', $this->groupedByCompletedTime($firstDay, $lastDay))
            ->with('month', $month);
    }

    private function groupedByType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $expenses = DB::table('transactions')
            ->selectRaw('sum(value) as sum, min(value) as min, max(value) as max, count(value) as count, categories.name as expense_type')
            ->groupBy('category_id')
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', TransactionType::Expense)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->orderByDesc('sum')
            ->get();

        return $expenses->map(fn (object $expense) => [
            'type' => $expense->expense_type,
            'sum' => new Money($expense->sum),
            'min' => new Money($expense->min),
            'max' => new Money($expense->max),
            'avg' => new Money($expense->sum / $expense->count)
        ]);
    }

    private function groupedByCompletedTime(Carbon $firstDay, Carbon $lastDay): array
    {
        $expenses = DB::table('transactions')
            ->selectRaw('sum(value) as sum')
            ->groupBy('completed_at')
            ->where('transaction_type', TransactionType::Expense)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $expense) => [ 'sum' => new Money($expense->sum) ]);

        $total = [
            'sum' => new Money( $expenses->sum(fn (array $expense) => $expense['sum']->pennies()) ?? 0 ),
            'min' => new Money( $expenses->min(fn (array $expense) => $expense['sum']->pennies()) ?? 0 ),
            'max' => new Money( $expenses->max(fn (array $expense) => $expense['sum']->pennies()) ?? 0 )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / $firstDay->daysInMonth );

        return $total;
    }

    private function groupedByCompletedTimeAndType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $expenses = DB::table('transactions')
            ->selectRaw('sum(value) as sum, categories.name as expense_type')
            ->groupBy(['completed_at', 'category_id'])
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', TransactionType::Expense)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $expense) => [
                'type' => $expense->expense_type,
                'sum' => new Money($expense->sum)
            ]);

        return $expenses->groupBy('type')
            ->map(fn (Collection $group, string $type) => [
                'type' => $type,
                'sum' => new Money( $group->sum( fn (array $expense) => $expense['sum']->pennies() ) ),
                'min' => new Money( $group->min( fn (array $expense) => $expense['sum']->pennies() ) ),
                'max' => new Money( $group->max( fn (array $expense) => $expense['sum']->pennies() ) )
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
        $expenses = DB::table('transactions')
            ->selectRaw('name, sum(value) as sum, min(value) as min, max(value) as max, count(value) as count')
            ->groupBy('name')
            ->where('transaction_type', TransactionType::Expense)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->having('count', '>', 1)
            ->orderByDesc('sum')
            ->get();

        return $expenses->map(fn (object $expense) => [
            'name' => $expense->name,
            'sum' => new Money($expense->sum),
            'min' => new Money($expense->min),
            'max' => new Money($expense->max),
            'avg' => new Money($expense->sum / $expense->count),
            'count' => $expense->count
        ]);
    }
}

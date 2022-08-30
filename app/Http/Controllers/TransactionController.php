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

abstract class TransactionController extends Controller
{
    protected TransactionType $transactionType;

    protected string $routeNamePrefix;

    protected string $indexTitle = 'Транзакции';

    protected string $statsTitle = 'Статистика';

    public function index()
    {
        return redirect()->route(
            $this->routeNamePrefix . 'index',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $items = Transaction::where('transaction_type', $this->transactionType)
            ->orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->with('category')
            ->get();

        return view('transactions.index')
            ->with('items', $items)
            ->with('month', $month)
            ->with('title', $this->indexTitle);
    }

    public function stats()
    {
        return redirect()->route(
            $this->routeNamePrefix . 'stats',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function statsByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        return view('transactions.stats')
            ->with('timeAndType', $this->groupedByCompletedTimeAndType($firstDay, $lastDay))
            ->with('type', $this->groupedByType($firstDay, $lastDay))
            ->with('name', $this->groupedByName($firstDay, $lastDay))
            ->with('total', $this->groupedByCompletedTime($firstDay, $lastDay))
            ->with('month', $month)
            ->with('title', $this->statsTitle);
    }

    private function groupedByType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $transactions = DB::table('transactions')
            ->selectRaw('sum(value) as sum, min(value) as min, max(value) as max, count(value) as count, categories.name as category_name')
            ->groupBy('category_id')
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', $this->transactionType)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->orderByDesc('sum')
            ->get();

        return $transactions->map(fn (object $transaction) => [
            'type' => $transaction->category_name,
            'sum' => new Money($transaction->sum),
            'min' => new Money($transaction->min),
            'max' => new Money($transaction->max),
            'avg' => new Money($transaction->sum / $transaction->count)
        ]);
    }

    private function groupedByCompletedTime(Carbon $firstDay, Carbon $lastDay): array
    {
        $transactions = DB::table('transactions')
            ->selectRaw('sum(value) as sum')
            ->groupBy('completed_at')
            ->where('transaction_type', $this->transactionType)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $transaction) => [ 'sum' => new Money($transaction->sum) ]);

        $total = [
            'sum' => new Money( $transactions->sum(fn (array $transaction) => $transaction['sum']->pennies()) ?? 0 ),
            'min' => new Money( $transactions->min(fn (array $transaction) => $transaction['sum']->pennies()) ?? 0 ),
            'max' => new Money( $transactions->max(fn (array $transaction) => $transaction['sum']->pennies()) ?? 0 )
        ];

        $total['avg'] = new Money( $total['sum']->pennies() / $firstDay->daysInMonth );

        return $total;
    }

    private function groupedByCompletedTimeAndType(Carbon $firstDay, Carbon $lastDay): Collection
    {
        $transactions = DB::table('transactions')
            ->selectRaw('sum(value) as sum, categories.name as category_name')
            ->groupBy(['completed_at', 'category_id'])
            ->join('categories', 'category_id', '=', 'categories.id', 'left')
            ->where('transactions.transaction_type', $this->transactionType)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get()
            ->map(fn (object $transaction) => [
                'type' => $transaction->category_name,
                'sum' => new Money($transaction->sum)
            ]);

        return $transactions->groupBy('type')
            ->map(fn (Collection $group, string $type) => [
                'type' => $type,
                'sum' => new Money( $group->sum( fn (array $transaction) => $transaction['sum']->pennies() ) ),
                'min' => new Money( $group->min( fn (array $transaction) => $transaction['sum']->pennies() ) ),
                'max' => new Money( $group->max( fn (array $transaction) => $transaction['sum']->pennies() ) )
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
        $transactions = DB::table('transactions')
            ->selectRaw('name, sum(value) as sum, min(value) as min, max(value) as max, count(value) as count')
            ->groupBy('name')
            ->where('transaction_type', $this->transactionType)
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->having('count', '>', 1)
            ->orderByDesc('sum')
            ->get();

        return $transactions->map(fn (object $transaction) => [
            'name' => $transaction->name,
            'sum' => new Money($transaction->sum),
            'min' => new Money($transaction->min),
            'max' => new Money($transaction->max),
            'avg' => new Money($transaction->sum / $transaction->count),
            'count' => $transaction->count
        ]);
    }
}

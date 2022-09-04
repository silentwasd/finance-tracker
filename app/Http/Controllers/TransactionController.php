<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Chart;
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

    protected \App\Services\Money $money;

    public function __construct(\App\Services\Money $money)
    {
        $this->money = $money;
    }

    public function indexTitle()
    {
        return 'Transactions';
    }

    public function statsTitle()
    {
        return 'Statistics';
    }

    public function index()
    {
        return redirect()->route(
            $this->routeNamePrefix . 'index',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function indexByMonth(Chart $chart, Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $items = Transaction::where('transaction_type', $this->transactionType)
            ->orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->with('category')
            ->get();

        $days = $chart->makePeriod($firstDay, $lastDay, fn (Carbon $date) => [
            'completed_at' => $date,
            'value' => $this->money->make(0)
        ])->merge(
            $items->groupBy(fn (Transaction $transaction) => $transaction->completed_at->toDateTimeString())
                ->map(fn (Collection $group, string $completedAt) => [
                    'completed_at' => Carbon::createFromTimeString($completedAt),
                    'value' => $this->money->make( $group->sum(fn (Transaction $transaction) => $transaction->value->units()) )
                ])
        )->values();

        return view('transactions.index')
            ->with('items', $items)
            ->with('days', $days)
            ->with('firstDay', $firstDay)
            ->with('lastDay', $lastDay)
            ->with('month', $month)
            ->with('title', $this->indexTitle());
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
            ->with('title', $this->statsTitle());
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
            'sum' => $this->money->make($transaction->sum),
            'min' => $this->money->make($transaction->min),
            'max' => $this->money->make($transaction->max),
            'avg' => $this->money->make($transaction->sum / $transaction->count)
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
            ->map(fn (object $transaction) => [ 'sum' => $this->money->make($transaction->sum) ]);

        $total = [
            'sum' => $this->money->make( $transactions->sum(fn (array $transaction) => $transaction['sum']->units()) ?? 0 ),
            'min' => $this->money->make( $transactions->min(fn (array $transaction) => $transaction['sum']->units()) ?? 0 ),
            'max' => $this->money->make( $transactions->max(fn (array $transaction) => $transaction['sum']->units()) ?? 0 )
        ];

        $total['avg'] = $this->money->make( $total['sum']->units() / $firstDay->daysInMonth );

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
                'type' => $transaction->category_name ?? 'none',
                'sum' => $this->money->make($transaction->sum)
            ]);

        return $transactions->groupBy('type')
            ->map(fn (Collection $group, string $type) => [
                'type' => $type == 'none' ? null : $type,
                'sum' => $this->money->make( $group->sum( fn (array $transaction) => $transaction['sum']->units() ) ),
                'min' => $this->money->make( $group->min( fn (array $transaction) => $transaction['sum']->units() ) ),
                'max' => $this->money->make( $group->max( fn (array $transaction) => $transaction['sum']->units() ) )
            ])
            ->map(
                fn (array $group) => array_merge(
                    $group,
                    ['avg' => $this->money->make( $group['sum']->units() / $firstDay->daysInMonth )]
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
            'sum' => $this->money->make($transaction->sum),
            'min' => $this->money->make($transaction->min),
            'max' => $this->money->make($transaction->max),
            'avg' => $this->money->make($transaction->sum / $transaction->count),
            'count' => $transaction->count
        ]);
    }
}

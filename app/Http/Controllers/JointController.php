<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Structures\Money;
use App\Structures\Month;
use App\Structures\TransactionType;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class JointController extends Controller
{
    private \App\Services\Money $money;

    public function __construct(\App\Services\Money $money)
    {
        $this->money = $money;
    }

    public function index()
    {
        return redirect()->route('joint.index', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $transactions = Transaction::orderBy('completed_at')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->with('category')
            ->get();

        return view('joint.index')
            ->with('items', $transactions)
            ->with('month', $month);
    }

    public function balance()
    {
        return redirect()->route('joint.balance', Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3));
    }

    public function balanceByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $transactions = Transaction::groupBy(['completed_at', 'transaction_type'])
            ->selectRaw('completed_at, transaction_type, sum(value) as value')
            ->where('completed_at', '>=', $firstDay)
            ->where('completed_at', '<=', $lastDay)
            ->get();

        $result = $transactions->groupBy('completed_at')
            ->map(function (Collection $row, string $date) {
                $income = $row->first(fn (Transaction $transaction) => $transaction->transaction_type == TransactionType::Income->value) ?? null;
                $expense = $row->first(fn (Transaction $transaction) => $transaction->transaction_type == TransactionType::Expense->value) ?? null;

                $result = [
                    'incomes' => $income->value ?? $this->money->make(0),
                    'expenses' => $expense->value ?? $this->money->make(0),
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s', $date)
                ];

                $result['balance'] = $this->money->make($result['incomes']->units() - $result['expenses']->units());

                return $result;
            })
            ->values()
            ->sortBy('date');

        $total = [
            'income' => $this->money->make( $result->sum(fn (array $row) => $row['incomes']->units()) ),
            'expense' => $this->money->make( $result->sum(fn (array $row) => $row['expenses']->units()) ),
            'balance' => $this->money->make( $result->sum(fn (array $row) => $row['balance']->units()) )
        ];

        return view('joint.balance')
            ->with('result', $result)
            ->with('total', $total)
            ->with('month', $month);
    }
}

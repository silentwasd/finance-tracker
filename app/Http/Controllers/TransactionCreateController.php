<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Structures\Money;
use App\Structures\TransactionType;
use Illuminate\Http\Request;

class TransactionCreateController extends Controller
{
    public function create(Request $request)
    {
        return view('transactions.create')
            ->with('income', $request->query('from') != 'expenses.index')
            ->with('expense', $request->query('from') == 'expenses.index');
    }

    public function store(StoreTransactionRequest $request)
    {
        $item = new Transaction();
        $item->name = $request->input('name');
        $item->value = new Money(round($request->input('value'), 2) * 100);
        $item->transaction_type = TransactionType::from($request->input('type'));
        $item->completed_at = now()->startOfDay();
        $item->save();

        return redirect()->route('transactions.edit', $item->id);
    }
}

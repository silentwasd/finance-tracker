<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Structures\Money;
use App\Structures\TransactionType;

class TransactionCreateController extends Controller
{
    public function create()
    {
        return view('transactions.create');
    }

    public function store(StoreTransactionRequest $request)
    {
        $item = new Transaction();
        $item->name = $request->input('name');
        $item->value = new Money(round($request->input('value'), 2) * 100);
        $item->transaction_type = TransactionType::from($request->input('type'));
        $item->completed_at = now()->startOfDay();
        $item->save();

        return redirect()->route('incomes.index.default');
    }
}

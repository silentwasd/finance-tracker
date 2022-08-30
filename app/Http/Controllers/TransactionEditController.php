<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Structures\Money;

class TransactionEditController extends Controller
{
    public function edit(Transaction $transaction)
    {
        $categories = Category::where('transaction_type', $transaction->transaction_type)->get();

        return view('transactions.edit')
            ->with('transaction', $transaction)
            ->with('categories', $categories);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->name = $request->input('name');
        $transaction->value = new Money(round($request->input('value') * 100, 2));
        $transaction->category_id = $request->input('category');
        $transaction->save();

        return redirect()->route('incomes.index.default');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('incomes.index.default');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Structures\Money;
use App\Structures\Month;
use App\Structures\TransactionType;

class TransactionEditController extends Controller
{
    public function edit(Transaction $transaction)
    {
        $categories = Category::where('transaction_type', $transaction->transaction_type)
            ->with('transactions')
            ->get()
            ->sortByDesc(fn (Category $category) => count($category->transactions));

        return view('transactions.edit')
            ->with('transaction', $transaction)
            ->with('categories', $categories);
    }

    public function update(UpdateTransactionRequest $request, \App\Services\Money $money, Transaction $transaction)
    {
        $transaction->name = $request->input('name');
        $transaction->value = $money->make(round($request->input('value') * 100, 2));
        $transaction->category_id = $request->input('category');
        $transaction->completed_at = $request->date('completed_at');
        $transaction->save();

        return redirect()->route(
            match ($transaction->transaction_type) {
                TransactionType::Income->value => 'incomes.index',
                TransactionType::Expense->value => 'expenses.index'
            }
        , Month::fromDateTime($transaction->completed_at));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route(
            match ($transaction->transaction_type) {
                TransactionType::Income->value => 'incomes.index.default',
                TransactionType::Expense->value => 'expenses.index.default'
            }
        );
    }
}

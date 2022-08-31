<?php

namespace App\Http\Controllers;

use App\Structures\TransactionType;

class ExpenseController extends TransactionController
{
    protected TransactionType $transactionType = TransactionType::Expense;

    protected string $routeNamePrefix = 'expenses.';

    public function indexTitle()
    {
        return __('links.expense');
    }

    public function statsTitle()
    {
        return __('links.expense_stats');
    }
}

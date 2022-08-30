<?php

namespace App\Http\Controllers;

use App\Structures\TransactionType;

class ExpenseController extends TransactionController
{
    protected TransactionType $transactionType = TransactionType::Expense;

    protected string $routeNamePrefix = 'expenses.';

    protected string $indexTitle = 'Расходы';

    protected string $statsTitle = 'Статистика расходов';
}

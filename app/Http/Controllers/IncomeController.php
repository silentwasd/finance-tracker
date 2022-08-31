<?php

namespace App\Http\Controllers;

use App\Structures\TransactionType;

class IncomeController extends TransactionController
{
    protected TransactionType $transactionType = TransactionType::Income;

    protected string $routeNamePrefix = 'incomes.';

    public function indexTitle()
    {
        return __('links.income');
    }

    public function statsTitle()
    {
        return __('links.income_stats');
    }
}

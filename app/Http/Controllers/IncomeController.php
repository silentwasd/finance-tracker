<?php

namespace App\Http\Controllers;

use App\Structures\TransactionType;

class IncomeController extends TransactionController
{
    protected TransactionType $transactionType = TransactionType::Income;

    protected string $routeNamePrefix = 'incomes.';

    protected string $indexTitle = 'Доходы';

    protected string $statsTitle = 'Статистика доходов';
}

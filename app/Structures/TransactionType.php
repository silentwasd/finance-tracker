<?php

namespace App\Structures;

enum TransactionType: string
{
    case Income = "income";
    case Expense = "expense";
}

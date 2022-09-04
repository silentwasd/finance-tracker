<?php

namespace App\Services;

use App\Structures\DollarMoney;

class Money
{
    public function make(float $value): \App\Structures\Money
    {
        return new DollarMoney($value);
    }
}

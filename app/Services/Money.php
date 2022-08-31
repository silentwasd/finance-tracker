<?php

namespace App\Services;

use App\Structures\RubleMoney;

class Money
{
    public function make(int $value): \App\Structures\Money
    {
        return new RubleMoney($value);
    }
}

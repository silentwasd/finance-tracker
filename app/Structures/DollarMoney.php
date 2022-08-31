<?php

namespace App\Structures;

class DollarMoney extends Money
{
    public function full(): float
    {
        return round($this->value / 100, 2);
    }

    public function asString(): string
    {
        return number_format($this->full(), 2, '.', ' ') . " $";
    }
}

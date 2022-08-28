<?php

namespace App\Structures;

class Money
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function pennies(): int
    {
        return $this->value;
    }

    public function rubles(): float
    {
        return round($this->value / 100, 2);
    }

    public function asString(): string
    {
        return number_format($this->rubles(), 2, '.', ' ') . " ₽";
    }

    public function __toString(): string
    {
        return $this->asString();
    }
}

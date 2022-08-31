<?php

namespace App\Structures;

class Money
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function units(): int
    {
        return $this->value;
    }

    public function full(): float
    {
        return round($this->value / 100, 2);
    }

    public function asString(): string
    {
        return number_format($this->full(), 2, '.', ' ') . " ₽";
    }

    public function __toString(): string
    {
        return $this->asString();
    }
}

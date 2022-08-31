<?php

namespace App\Structures;

abstract class Money
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function units(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->asString();
    }

    public abstract function full(): float;

    public abstract function asString(): string;
}

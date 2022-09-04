<?php

namespace App\Structures;

abstract class Money
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function units(): float
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

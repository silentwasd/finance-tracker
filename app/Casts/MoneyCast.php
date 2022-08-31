<?php

namespace App\Casts;

use App\Structures\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class MoneyCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        $money = resolve(\App\Services\Money::class);
        return $money->make($value);
    }

    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof Money) {
            throw new InvalidArgumentException('The given value is not an Money instance.');
        }

        return $value->units();
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Chart
{
    public function makePeriod(Carbon $firstDay, Carbon $lastDay, callable $value): Collection
    {
        $days = collect();

        for ($d = 1; $d <= $lastDay->daysInMonth; $d++) {
            $date = Carbon::create($firstDay->year, $firstDay->month, $d);
            $days[$date->toDateTimeString()] = $value($date);
        }

        return $days;
    }
}

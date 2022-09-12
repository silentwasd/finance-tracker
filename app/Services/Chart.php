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

    public function makeColors(int $count): array
    {
        $lib = [
            '#FFFF00',
            '#FFAE42',
            '#FFA500',
            '#FA4616',
            '#FF0000',
            '#C71585',
            '#9B26B6',
            '#8A2BE2',
            '#0000FF',
            '#0D98BA',
            '#00FF00',
            '#9ACD32'
        ];

        if ($count <= count($lib)) {
            return array_slice($lib, 0, $count);
        }

        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $result[] = $lib[($i + 1) % count($lib)];
        }

        return $result;
    }
}

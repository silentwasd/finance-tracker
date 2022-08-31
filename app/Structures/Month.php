<?php

namespace App\Structures;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

enum Month: string
{
    case January = "jan";
    case February = "feb";
    case March = "mar";
    case April = "apr";
    case May = "may";
    case June = "jun";
    case July = "jul";
    case August = "aug";
    case September = "sep";
    case October = "oct";
    case November = "nov";
    case December = "dec";

    public static function fromDateTime(DateTime $dateTime): Month
    {
        $name = Str::substr(Str::lower((new Carbon($dateTime))->locale('en')->monthName), 0, 3);
        return self::from($name);
    }
}

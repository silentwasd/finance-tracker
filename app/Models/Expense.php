<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps = false;

    protected $casts = [
        'value' => MoneyCast::class,
        'completed_at' => 'datetime'
    ];
}
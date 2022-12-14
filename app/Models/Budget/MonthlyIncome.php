<?php

namespace App\Models\Budget;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class MonthlyIncome extends Model
{
    protected $table = 'budget_monthly_income';

    protected $fillable = [
        'expected_at',
        'value'
    ];

    public $timestamps = false;

    protected $casts = [
        'value' => MoneyCast::class,
        'expected_at' => 'datetime'
    ];
}

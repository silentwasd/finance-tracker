<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    public $timestamps = false;

    protected $casts = [
        'value' => MoneyCast::class,
        'completed_at' => 'datetime'
    ];

    public function incomeType(): BelongsTo
    {
        return $this->belongsTo(IncomeType::class, 'income_type');
    }
}

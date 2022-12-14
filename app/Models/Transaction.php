<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Models\Budget\MonthlyPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    public $timestamps = false;

    protected $casts = [
        'value' => MoneyCast::class,
        'completed_at' => 'datetime'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function monthlyPayment(): HasOne
    {
        return $this->hasOne(MonthlyPayment::class, 'created_transaction_id');
    }
}

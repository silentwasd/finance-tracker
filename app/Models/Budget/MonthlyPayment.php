<?php

namespace App\Models\Budget;

use App\Casts\MoneyCast;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyPayment extends Model
{
    protected $table = 'budget_monthly_payments';

    public $timestamps = false;

    protected $casts = [
        'value' => MoneyCast::class,
        'will_created_at' => 'datetime'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function createdTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}

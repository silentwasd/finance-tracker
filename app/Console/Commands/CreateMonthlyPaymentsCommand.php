<?php

namespace App\Console\Commands;

use App\Models\Budget\MonthlyPayment;
use App\Models\Transaction;
use App\Structures\TransactionType;
use Illuminate\Console\Command;

class CreateMonthlyPaymentsCommand extends Command
{
    protected $signature = 'create:monthly-payments';

    protected $description = 'Create monthly payments.';

    public function handle()
    {
        $today = now()->startOfDay();

        $payments = MonthlyPayment::where('will_created_at', $today)
            ->whereNull('created_transaction_id')
            ->get();

        foreach ($payments as $payment) {
            $transaction = new Transaction();
            $transaction->name = $payment->name;
            $transaction->category_id = $payment->category_id;
            $transaction->transaction_type = TransactionType::Expense;
            $transaction->value = $payment->value;
            $transaction->completed_at = $payment->will_created_at;
            $transaction->save();

            $payment->created_transaction_id = $transaction->id;
            $payment->save();
        }
    }
}

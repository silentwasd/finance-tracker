<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\Budget\MonthlyIncome;
use App\Models\Budget\MonthlyPayment;
use App\Services\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        return redirect()->route(
            'budget.plan.index',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function indexByMonth(Money $money, Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $income = MonthlyIncome::where('expected_at', $firstDay)->first()->value ?? $money->make(0.0);
        $payments = $money->make(
            MonthlyPayment::where('will_created_at', '>=', $firstDay)
                ->where('will_created_at', '<=', $lastDay)
                ->sum('value')
        );

        return view('budget.plan.index')
            ->with('income', $income)
            ->with('payments', $payments)
            ->with('balance', $money->make($income->units() - $payments->units()))
            ->with('month', $month);
    }
}

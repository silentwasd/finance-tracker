<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMonthlyIncomeRequest;
use App\Models\Budget\MonthlyIncome;
use App\Services\Money;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MonthlyIncomeController extends Controller
{
    public function index()
    {
        return redirect()->route(
            'budget.monthly-income.index',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function indexByMonth(Money $money, Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));

        $item = MonthlyIncome::where('expected_at', $firstDay)->first();

        return view('budget.monthly-income.index')
            ->with('value', $item->value ?? $money->make(0.0))
            ->with('month', $month);
    }

    public function update(UpdateMonthlyIncomeRequest $request, Money $money, Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));

        MonthlyIncome::updateOrCreate(
            ['expected_at' => $firstDay],
            ['value' => $money->make(round($request->input('value'), 2) * 100)]
        );

        return redirect()->route('budget.monthly-income.index', Month::fromDateTime($firstDay));
    }
}

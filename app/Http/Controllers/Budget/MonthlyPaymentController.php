<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\Budget\MonthlyPayment;
use App\Structures\Month;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MonthlyPaymentController extends Controller
{
    public function index()
    {
        return redirect()->route(
            'budget.monthly-payments.index',
            Str::substr(Str::lower(now()->locale('en')->monthName), 0, 3)
        );
    }

    public function indexByMonth(Month $month)
    {
        $firstDay = new Carbon(new DateTime("first day of $month->name"));
        $lastDay = new Carbon(new DateTime("last day of $month->name"));

        $items = MonthlyPayment::orderBy('will_created_at')
            ->where('will_created_at', '>=', $firstDay)
            ->where('will_created_at', '<=', $lastDay)
            ->with('category')
            ->get();

        return view('budget.monthly-payments.index')
            ->with('items', $items)
            ->with('firstDay', $firstDay)
            ->with('lastDay', $lastDay)
            ->with('month', $month);
    }
}

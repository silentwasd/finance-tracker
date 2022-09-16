<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyPaymentRequest;
use App\Http\Requests\UpdateMonthlyPaymentRequest;
use App\Models\Budget\MonthlyPayment;
use App\Models\Category;
use App\Services\Money;
use App\Structures\Month;
use App\Structures\TransactionType;
use DateTime;
use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        return view('budget.monthly-payments.create')
            ->with('will_created_at', $request->query('month') ? new Carbon(new DateTime($request->query('month'))) : now());
    }

    public function store(StoreMonthlyPaymentRequest $request, Money $money)
    {
        $item = new MonthlyPayment();
        $item->name = $request->input('name');
        $item->value = $money->make(round($request->input('value'), 2) * 100);
        $item->will_created_at = $request->date('will_created_at');
        $item->save();

        return redirect()->route('budget.monthly-payments.edit', $item->id);
    }

    public function edit(MonthlyPayment $payment)
    {
        $categories = Category::where('transaction_type', TransactionType::Expense)
            ->with('transactions')
            ->get()
            ->sortByDesc(fn (Category $category) => count($category->transactions));

        return view('budget.monthly-payments.edit')
            ->with('payment', $payment)
            ->with('categories', $categories);
    }

    public function update(UpdateMonthlyPaymentRequest $request, Money $money, MonthlyPayment $payment)
    {
        $payment->name = $request->input('name');
        $payment->value = $money->make(round($request->input('value'), 2) * 100);
        $payment->category_id = $request->input('category');
        $payment->will_created_at = $request->date('will_created_at');
        $payment->save();

        return redirect()->route('budget.monthly-payments.index', Month::fromDateTime($payment->will_created_at));
    }

    public function destroy(MonthlyPayment $payment)
    {
        $payment->delete();

        return redirect()->route('budget.monthly-payments.index.default');
    }
}

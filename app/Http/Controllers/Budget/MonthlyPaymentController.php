<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

class MonthlyPaymentController extends Controller
{
    public function index()
    {
        return view('budget.monthly-payments.index');
    }
}

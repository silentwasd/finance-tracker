<?php

use App\Http\Controllers\Budget\MonthlyPaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\JointController;
use App\Http\Controllers\TransactionCreateController;
use App\Http\Controllers\TransactionEditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/incomes');

Route::prefix('incomes')->name('incomes.')->group(function () {

    Route::get('stats', [IncomeController::class, 'stats'])->name('stats.default');

    Route::get('stats/{month}', [IncomeController::class, 'statsByMonth'])->name('stats');

    Route::get('', [IncomeController::class, 'index'])->name('index.default');

    Route::get('{month}', [IncomeController::class, 'indexByMonth'])->name('index');

});

Route::prefix('expenses')->name('expenses.')->group(function () {

    Route::get('stats', [ExpenseController::class, 'stats'])->name('stats.default');

    Route::get('stats/{month}', [ExpenseController::class, 'statsByMonth'])->name('stats');

    Route::get('', [ExpenseController::class, 'index'])->name('index.default');

    Route::get('{month}', [ExpenseController::class, 'indexByMonth'])->name('index');

});

Route::prefix('joint')->name('joint.')->group(function () {

    Route::get('balance', [JointController::class, 'balance'])->name('balance.default');

    Route::get('balance/{month}', [JointController::class, 'balanceByMonth'])->name('balance');

    Route::get('', [JointController::class, 'index'])->name('index.default');

    Route::get('{month}', [JointController::class, 'indexByMonth'])->name('index');

});

Route::prefix('transactions')->name('transactions.')->group(function () {

    Route::get('create', [TransactionCreateController::class, 'create'])->name('create');

    Route::post('store', [TransactionCreateController::class, 'store'])->name('store');

    Route::get('edit/{transaction}', [TransactionEditController::class, 'edit'])->name('edit');

    Route::post('update/{transaction}', [TransactionEditController::class, 'update'])->name('update');

    Route::post('destroy/{transaction}', [TransactionEditController::class, 'destroy'])->name('destroy');

});

Route::prefix('categories')->name('categories.')->group(function () {

    Route::get('', [CategoryController::class, 'index'])->name('index');

    Route::get('create', [CategoryController::class, 'create'])->name('create');

    Route::post('store', [CategoryController::class, 'store'])->name('store');

    Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('edit');

    Route::post('update/{category}', [CategoryController::class, 'update'])->name('update');

    Route::post('destroy/{category}', [CategoryController::class, 'destroy'])->name('destroy');

});

Route::prefix('budget')->name('budget.')->group(function () {

    Route::prefix('monthly-payments')->name('monthly-payments.')->group(function () {

        Route::get('', [MonthlyPaymentController::class, 'index'])->name('index.default');

        Route::get('{month}', [MonthlyPaymentController::class, 'indexByMonth'])->name('index');

    });

});

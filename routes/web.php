<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\JointController;
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

Route::get('/', function () {
    return view('welcome');
});

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

    Route::get('balance', [JointController::class, 'balance'])->name('balance');

    Route::get('', [JointController::class, 'index'])->name('index.default');

    Route::get('{month}', [JointController::class, 'indexByMonth'])->name('index');

});

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

Route::get('/incomes', [IncomeController::class, 'index']);

Route::get('/expenses', [ExpenseController::class, 'index']);

Route::prefix('joint')->group(function () {

    Route::get('', [JointController::class, 'index']);

    Route::get('balance', [JointController::class, 'balance']);

});

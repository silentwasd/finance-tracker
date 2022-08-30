<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class NavViewComposer
{
    public function compose(View $view)
    {
        $view->with('nav', [
            'incomes.index' => 'Доходы',
            'expenses.index' => 'Расходы',
            'joint.index' => 'Общее',
            'joint.balance' => 'Баланс',
            'incomes.stats.default' => ['incomes.stats', 'Статистика доходов'],
            'expenses.stats.default' => ['expenses.stats', 'Статистика расходов']
        ]);
    }
}
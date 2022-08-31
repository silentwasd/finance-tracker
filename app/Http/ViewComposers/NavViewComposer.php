<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class NavViewComposer
{
    public function compose(View $view)
    {
        $view->with('nav', [
            'incomes.index.default' => ['incomes.index', __('links.income')],
            'expenses.index.default' => ['expenses.index', __('links.expense')],
            'joint.index.default' => ['joint.index', __('links.joint')],
            'joint.balance.default' => ['joint.balance', __('links.balance')],
            'incomes.stats.default' => ['incomes.stats', __('links.income_stats')],
            'expenses.stats.default' => ['expenses.stats', __('links.expense_stats')],
            'categories.index' => __('links.categories')
        ]);
    }
}

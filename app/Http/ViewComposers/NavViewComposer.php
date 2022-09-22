<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class NavViewComposer
{
    public function compose(View $view)
    {
        $view->with('nav', [
            [
                'title' => __('links.menu'),
                'items' => [
                    'incomes.index.default' => ['incomes.index', __('links.income')],
                    'expenses.index.default' => ['expenses.index', __('links.expense')],
                    'joint.index.default' => ['joint.index', __('links.joint')],
                    'joint.balance.default' => ['joint.balance', __('links.balance')],
                    'incomes.stats.default' => ['incomes.stats', __('links.income_stats')],
                    'expenses.stats.default' => ['expenses.stats', __('links.expense_stats')],
                    'categories.index' => __('links.categories')
                ]
            ],

            [
                'title' => __('links.budget'),
                'prefix' => 'budget.',
                'items' => [
                    'monthly-income.index.default' => ['monthly-income.index', __('links.budget.monthly-income')],
                    'monthly-payments.index.default' => ['monthly-payments.index', __('links.budget.monthly-payments')]
                ]
            ]
        ]);
    }
}

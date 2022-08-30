<?php

namespace App\View\Components;

use App\Structures\Month;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use UnitEnum;

class MonthSelector extends Component
{
    public Month $month;

    public string $current;

    public ?string $next;

    public ?string $prev;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    private function compute()
    {
        $months = collect(Month::cases());
        $curKey = $months->search(fn (UnitEnum $unit) => $unit->name == $this->month->name);

        $this->current = $this->month->value;
        $this->next = $curKey + 1 < $months->count() ? $months[$curKey + 1]->value : null;
        $this->prev = $curKey - 1 >= 0 ? $months[$curKey - 1]->value : null;
    }

    public function render(): View
    {
        $this->compute();
        return view('components.month-selector');
    }
}

<div class="row">
    <div class="col">
        <div class="list-group">
            <a href="{{ route('incomes.index') }}" class="list-group-item list-group-item-action">
                Доходы
            </a>

            <a href="{{ route('expenses.index') }}" class="list-group-item list-group-item-action">
                Расходы
            </a>

            <a href="{{ route('joint.index') }}" class="list-group-item list-group-item-action">
                Общее
            </a>

            <a href="{{ route('joint.balance') }}" class="list-group-item list-group-item-action">
                Баланс
            </a>

            <a href="{{ route('incomes.stats.default') }}" class="list-group-item list-group-item-action">
                Статистика доходов
            </a>

            <a href="{{ route('expenses.stats.default') }}" class="list-group-item list-group-item-action">
                Статистика расходов
            </a>
        </div>
    </div>
</div>

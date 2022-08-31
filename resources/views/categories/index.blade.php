@extends('layouts.main', ['title' => 'Категории'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>Действия</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    Наверх
                </a>

                <a href="#table-income" class="list-group-item list-group-item-action">
                    Категории дохода
                </a>

                <a href="#table-expense" class="list-group-item list-group-item-action">
                    Категории расхода
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <div class="row">
        <div class="col">
            <table class="table" id="table-income">
                <caption class="caption-top">Категории дохода</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <th>Наименование</th>
                    <th>Кол-во транзакций</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($items->where('transaction_type', \App\Structures\TransactionType::Income->value) as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->transactions()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table" id="table-expense">
                <caption class="caption-top">Категории расхода</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <th>Наименование</th>
                    <th>Кол-во транзакций</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($items->where('transaction_type', \App\Structures\TransactionType::Expense->value) as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->transactions()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

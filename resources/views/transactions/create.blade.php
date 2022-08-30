@extends('layouts.main', ['title' => $title ?? 'Создать транзакцию'])

@section('main')
    <div class="row">
        <div class="col">
            <h3>Создать транзакцию</h3>

            <form method="post" action="{{ route('transactions.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Наименование</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="Проценты на остаток" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Тип транзакции</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type"
                               id="income" value="income"
                            @checked(old('type') ? old('type') == 'income' : $income)>
                        <label class="form-check-label" for="income">
                            Доход
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type"
                               id="expense" value="expense"
                            @checked(old('type') ? old('type') == 'expense' : $expense)>
                        <label class="form-check-label" for="expense">
                            Расход
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">Значение</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01"
                           name="value" value="{{ old('value') }}" required>
                </div>

                <div class="mb-3">
                    <label for="completed_at" class="form-label">Дата совершения транзакции</label>
                    <input type="date" class="form-control" id="completed_at" name="completed_at"
                           value="{{ old('completed_at') ?? now()->startOfDay()->format('Y-m-d') }}"
                           required>
                </div>

                <button class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

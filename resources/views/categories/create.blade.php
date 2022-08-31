@extends('layouts.main', ['title' => 'Создать категорию'])

@section('main')
    <div class="row">
        <div class="col">
            <h3>Создать категорию</h3>

            <form method="post" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Наименование</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="Еда" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Для типа транзакции</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type"
                               id="income" value="{{ \App\Structures\TransactionType::Income->value }}"
                            @checked(old('type') ? old('type') == \App\Structures\TransactionType::Income->value : true)>
                        <label class="form-check-label" for="income">
                            Доход
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type"
                               id="expense" value="{{ \App\Structures\TransactionType::Expense->value }}"
                            @checked(old('type') == \App\Structures\TransactionType::Expense->value)>
                        <label class="form-check-label" for="expense">
                            Расход
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

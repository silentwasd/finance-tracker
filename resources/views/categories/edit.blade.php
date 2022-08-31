@extends('layouts.main', ['title' => 'Изменить категорию'])

@section('main')
    <div class="row">
        <div class="col">
            <h3>Изменить категорию</h3>

            <form class="d-inline" method="post" action="{{ route('categories.update', $item->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Наименование</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="Проценты на остаток" value="{{ old('name') ?? $item->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Для типа транзакции</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="income" value="income" @checked($item->transaction_type == 'income')>
                        <label class="form-check-label" for="income">
                            Доход
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="expense" value="expense" @checked($item->transaction_type == 'expense')>
                        <label class="form-check-label" for="expense">
                            Расход
                        </label>
                    </div>
                </div>

                <button class="btn btn-success">Обновить</button>
            </form>

            <form class="d-inline" method="post" action="{{ route('categories.destroy', $item->id) }}">
                @csrf

                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>
@endsection

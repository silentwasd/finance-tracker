@extends('layouts.main', ['title' => 'Общее'])

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">

            <table class="table">
                <thead class="table-light sticky-top">
                <tr>
                    <td>Тип транзакции</td>
                    <td>Наименование</td>
                    <td>Категория</td>
                    <td>Значение</td>
                    <td>Дата</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->transaction_type == \App\Structures\TransactionType::Income->value ? 'Доход' : 'Расход' }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name ?? '–' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->completed_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

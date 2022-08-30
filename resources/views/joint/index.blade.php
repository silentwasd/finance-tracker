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
                    <td>Тип операции</td>
                    <td>Наименование</td>
                    <td>Тип записи</td>
                    <td>Значение</td>
                    <td>Дата</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['operationType'] == 'income' ? 'Доход' : 'Расход' }}</td>
                        <td>{{ $item['model']->name }}</td>
                        <td>{{ $item['recordType'] ?? '–' }}</td>
                        <td>{{ $item['model']->value }}</td>
                        <td>{{ $item['model']->completed_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

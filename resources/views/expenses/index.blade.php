@extends('layouts.main', ['title' => 'Расходы'])

@section('main')
    <div class="row">
        <div class="col">

            <table class="table">
                <thead>
                <tr>
                    <td>Наименование</td>
                    <td>Тип</td>
                    <td>Значение</td>
                    <td>Дата</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->expenseType->name ?? '–' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->completed_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

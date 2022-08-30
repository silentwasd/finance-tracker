@extends('layouts.main', ['title' => 'Баланс'])

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">

            <table class="table">
                <thead class="table-light sticky-top">
                <tr>
                    <td>Доход</td>
                    <td>Расход</td>
                    <td>Баланс</td>
                    <td>Дата</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($result as $row)
                    <tr>
                        <td>{{ $row['incomes'] }}</td>
                        <td>{{ $row['expenses'] }}</td>
                        <td>{{ $row['balance'] }}</td>
                        <td>{{ $row['date']->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@extends('layouts.main', ['title' => 'Баланс'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>Действия</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    Наверх
                </a>

                <a href="#table-total" class="list-group-item list-group-item-action">
                    Итого
                </a>

                <a href="#table-days" class="list-group-item list-group-item-action">
                    По дням
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">

            <table class="table" id="table-total">
                <caption class="caption-top">Итого</caption>

                <tbody>
                <tr>
                    <td>Доход</td>
                    <td>{{ $total['income'] }}</td>
                </tr>

                <tr>
                    <td>Расход</td>
                    <td>{{ $total['expense'] }}</td>
                </tr>

                <tr>
                    <td>Баланс</td>
                    <td>{{ $total['balance'] }}</td>
                </tr>
                </tbody>
            </table>

            <table class="table" id="table-days">
                <caption class="caption-top">По дням</caption>

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

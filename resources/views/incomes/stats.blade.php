@extends('layouts.main', ['title' => 'Статистика доходов'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>Страница</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    Наверх
                </a>

                <a href="#table-general" class="list-group-item list-group-item-action">
                    Общее
                </a>

                <a href="#table-name" class="list-group-item list-group-item-action">
                    По наименованию
                </a>

                <a href="#table-time-type" class="list-group-item list-group-item-action">
                    По типу (учет по дням)
                </a>

                <a href="#table-type" class="list-group-item list-group-item-action">
                    По типу (учет по записям)
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <x-month-selector :month="$month"></x-month-selector>

    <div class="row">
        <div class="col">

            <table class="table" id="table-general">
                <caption class="caption-top">Общее</caption>

                <tbody>

                <tr>
                    <td>Всего за месяц</td>
                    <td>{{ $total['sum'] }}</td>
                </tr>

                <tr>
                    <td>В среднем за день</td>
                    <td>{{ $total['avg'] }}</td>
                </tr>

                <tr>
                    <td>Минимум за день</td>
                    <td>{{ $total['min'] }}</td>
                </tr>

                <tr>
                    <td>Максимум за день</td>
                    <td>{{ $total['max'] }}</td>
                </tr>

                </tbody>
            </table>

            <table class="table" id="table-name">
                <caption class="caption-top">По наименованию (учитывается расход по записям)</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <td>Наименование</td>
                    <td>Сумма</td>
                    <td>Минимум</td>
                    <td>Максимум</td>
                    <td>Среднее</td>
                    <td>Кол-во</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($name as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['sum'] }}</td>
                        <td>{{ $item['min'] }}</td>
                        <td>{{ $item['max'] }}</td>
                        <td>{{ $item['avg'] }}</td>
                        <td>{{ $item['count'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table" id="table-time-type">
                <caption class="caption-top">По типу (учитывается расход по дням)</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <td>Тип</td>
                    <td>Сумма</td>
                    <td>Минимум</td>
                    <td>Максимум</td>
                    <td>Среднее</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($timeAndType as $item)
                    <tr>
                        <td>{{ $item['type'] ?? 'Без типа' }}</td>
                        <td>{{ $item['sum'] }}</td>
                        <td>{{ $item['min'] }}</td>
                        <td>{{ $item['max'] }}</td>
                        <td>{{ $item['avg'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table" id="table-type">
                <caption class="caption-top">По типу (учитывается расход по записям)</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <td>Тип</td>
                    <td>Сумма</td>
                    <td>Минимум</td>
                    <td>Максимум</td>
                    <td>Среднее</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($type as $item)
                    <tr>
                        <td>{{ $item['type'] ?? 'Без типа' }}</td>
                        <td>{{ $item['sum'] }}</td>
                        <td>{{ $item['min'] }}</td>
                        <td>{{ $item['max'] }}</td>
                        <td>{{ $item['avg'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

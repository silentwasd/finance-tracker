@extends('layout', ['title' => 'Статистика доходов'])

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table">
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
                        <td>Минимальный доход</td>
                        <td>{{ $total['min'] }}</td>
                    </tr>

                    <tr>
                        <td>Максимальный доход</td>
                        <td>{{ $total['max'] }}</td>
                    </tr>

                    </tbody>
                </table>

                <table class="table">
                    <caption class="caption-top">По типу</caption>

                    <thead class="table-light">
                    <tr>
                        <td>Тип</td>
                        <td>Сумма</td>
                        <td>Минимум</td>
                        <td>Максимум</td>
                        <td>Среднее</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($result as $item)
                        <tr>
                            <td>{{ $item['type'] }}</td>
                            <td>{{ $item['value'] }}</td>
                            <td>{{ $item['min'] }}</td>
                            <td>{{ $item['max'] }}</td>
                            <td>{{ $item['avg'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

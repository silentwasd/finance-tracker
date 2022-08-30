@extends('layout', ['title' => 'Статистика расходов'])

@section('body')
    <div class="container py-4">
        <div class="row">
            <div class="col-auto">
                <a class="btn btn-primary {{ $months['prev'] == null ? 'disabled' : '' }}"
                   href="{{ $months['prev'] ? route('expenses.stats', $months['prev']) : '#' }}">
                    Предыдущий
                </a>
            </div>

            <div class="col text-center">
                <h3>{{ Str::ucfirst(__("months.{$months['cur']}")) }}</h3>
            </div>

            <div class="col-auto">
                <a class="btn btn-primary {{ $months['next'] == null ? 'disabled' : '' }}"
                   href="{{ $months['next'] ? route('expenses.stats', $months['next']) : '#' }}">
                    Следующий
                </a>
            </div>
        </div>

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
                        <td>Минимальный расход</td>
                        <td>{{ $total['min'] }}</td>
                    </tr>

                    <tr>
                        <td>Максимальный расход</td>
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

@extends('layout', ['title' => 'Статистика доходов'])

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table">
                    <caption class="caption-top">Общее</caption>

                    <tbody>

                    <tr>
                        <td>Сумма</td>
                        <td>{{ $total['sum'] }}</td>
                    </tr>

                    </tbody>
                </table>

                <table class="table">
                    <caption class="caption-top">По типу</caption>

                    <thead class="table-light">
                    <tr>
                        <td>Тип</td>
                        <td>Сумма</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($result as $item)
                        <tr>
                            <td>{{ $item['type'] }}</td>
                            <td>{{ $item['value'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

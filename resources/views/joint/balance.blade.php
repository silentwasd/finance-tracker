@extends('layout', ['title' => 'Баланс'])

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table">
                    <thead>
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
    </div>
@endsection

@extends('layout', ['title' => 'Общее'])

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table">
                    <thead>
                    <tr>
                        <td>Тип</td>
                        <td>Наименование</td>
                        <td>Значение</td>
                        <td>Дата</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item['type'] == 'income' ? 'Доход' : 'Расход' }}</td>
                            <td>{{ $item['model']->name }}</td>
                            <td>{{ $item['model']->value }}</td>
                            <td>{{ $item['model']->completed_at->format('d.m.Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

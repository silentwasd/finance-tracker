@extends('layouts.main', ['title' => __('links.balance')])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="#table-total" class="list-group-item list-group-item-action">
                    {{ __('tables.total') }}
                </a>

                <a href="#table-days" class="list-group-item list-group-item-action">
                    {{ __('tables.by_days') }} ({{ Str::lower(__('tables.table')) }})
                </a>

                <a href="#chart-days" class="list-group-item list-group-item-action">
                    {{ __('tables.by_days') }} ({{ Str::lower(__('charts.chart')) }})
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
                <caption class="caption-top">{{ __('tables.total') }}</caption>

                <tbody>
                <tr>
                    <td>{{ __('tables.income') }}</td>
                    <td>{{ $total['income'] }}</td>
                </tr>

                <tr>
                    <td>{{ __('tables.expense') }}</td>
                    <td>{{ $total['expense'] }}</td>
                </tr>

                <tr>
                    <td>{{ __('tables.balance') }}</td>
                    <td>{{ $total['balance'] }}</td>
                </tr>
                </tbody>
            </table>

            <table class="table" id="table-days">
                <caption class="caption-top">{{ __('tables.by_days') }}</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <td>{{ __('tables.income') }}</td>
                    <td>{{ __('tables.expense') }}</td>
                    <td>{{ __('tables.balance') }}</td>
                    <td>{{ __('tables.date') }}</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($result as $row)
                    <tr>
                        <td>{{ $row['incomes'] }}</td>
                        <td>{{ $row['expenses'] }}</td>
                        <td>{{ $row['balance'] }}</td>
                        <td>{{ $row['date']->format(config('app.date_format')) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <canvas id="chart-days" width="400" height="200"></canvas>

            <script>
                const ctx = document.getElementById('chart-days').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [{
                            label: '{{ __('tables.balance') }}',
                            data: [
                                    @foreach ($result as $item)
                                {
                                    x: '{{ $item['date']->toIso8601String() }}',
                                    y: {{ $item['balance']->full() }}
                                },
                                @endforeach
                            ],
                            backgroundColor: 'rgba(112,134,255,0.5)',
                            borderColor: 'rgb(38,122,168)',
                            borderWidth: 2,
                            fill: true,
                            stepped: false,
                            tension: 0.2,
                            spanGaps: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                bounds: 'ticks',
                                min: '{{ $firstDay->toIso8601String() }}',
                                max: '{{ $lastDay->toIso8601String() }}',
                                time: {
                                    unit: 'day',
                                    round: 'day'
                                }
                            },
                        }
                    }
                });
            </script>

        </div>
    </div>
@endsection

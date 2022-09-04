@extends('layouts.main', ['title' => __('links.joint')])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="#table" class="list-group-item list-group-item-action">
                    {{ __('tables.table') }}
                </a>

                <a href="#chart" class="list-group-item list-group-item-action">
                    {{ __('charts.chart') }}
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

            <table class="table" id="table">
                <thead class="table-light sticky-top">
                <tr>
                    <td>{{ __('tables.transaction_type') }}</td>
                    <td>{{ __('tables.name') }}</td>
                    <td>{{ __('tables.category') }}</td>
                    <td>{{ __('tables.value') }}</td>
                    <td>{{ __('tables.date') }}</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->transaction_type == \App\Structures\TransactionType::Income->value ? __('tables.income') : __('tables.expense') }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', ['transaction' => $item->id]) }}"
                               class="text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>{{ $item->category->name ?? '–' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->completed_at->format(config('app.date_format')) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <canvas id="chart" width="400" height="200"></canvas>

            <script>
                const ctx = document.getElementById('chart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [{
                            label: '{{ __('tables.income') }}',
                            data: [
                                    @foreach ($days as $item)
                                {
                                    x: '{{ $item['completed_at']->toIso8601String() }}',
                                    y: {{ $item['income']->full() }}
                                },
                                @endforeach
                            ],
                            backgroundColor: 'rgba(55,255,99,0.5)',
                            borderColor: 'rgb(14,143,20)',
                            borderWidth: 2,
                            fill: true,
                            stepped: false,
                            tension: 0.2,
                            spanGaps: false
                        }, {
                            label: '{{ __('tables.expense') }}',
                            data: [
                                    @foreach ($days as $item)
                                {
                                    x: '{{ $item['completed_at']->toIso8601String() }}',
                                    y: {{ $item['expense']->full() }}
                                },
                                @endforeach
                            ],
                            backgroundColor: 'rgba(231,22,22,0.5)',
                            borderColor: 'rgb(185,19,19)',
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

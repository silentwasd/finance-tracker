@extends('layouts.main', ['title' => $title ?? 'Transactions'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="{{ route('transactions.create', ['from' => Route::currentRouteName(), 'month' => $month]) }}"
                   class="list-group-item list-group-item-action">
                    {{ __('links.create') }}
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
                    <td>{{ __('tables.name') }}</td>
                    <td>{{ __('tables.category') }}</td>
                    <td>{{ __('tables.value') }}</td>
                    <td>{{ __('tables.date') }}</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('transactions.edit', $item->id) }}" class="text-decoration-none">
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
                            label: '{{ $title }}',
                            data: [
                                @foreach ($days as $item)
                                {
                                    x: '{{ $item['completed_at']->toIso8601String() }}',
                                    y: {{ $item['value']->full() }}
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

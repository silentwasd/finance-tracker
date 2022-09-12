@inject('chart', '\App\Services\Chart')

@php

$otherPercent = 0.05;

$total = $money->make( $data->sum(fn ($item) => $item['sum']->units()) );
$items = $data->filter(fn ($item) => $item['sum']->units() / $total->units() > $otherPercent);
$small = $money->make( $data->filter(fn ($item) => $item['sum']->units() / $total->units() <= $otherPercent)->sum(fn ($item) => $item['sum']->units()) );

if ($small->units() > 0)
    $items = $items->push([
        'name' => __('charts.other'),
        'sum' => $small
    ]);

@endphp

<div class="col-6">
    <canvas id="chart-name" width="400" height="200"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('chart-name').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [{!! $items->map(fn ($item) => '"' . $item['name'] . '"')->implode(', ') !!}],
                    datasets: [{
                        data: [{!! $items->map(fn ($item) => $item['sum']->full())->implode(', ') !!}],
                        backgroundColor: [{!! collect($chart->makeColors($data->count()))->map(fn ($color) => "'" . $color . "'")->implode(', ') !!}],
                        hoverOffset: 4
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: '{{ __('tables.by_name') }}'
                        }
                    }
                }
            });
        });
    </script>
</div>

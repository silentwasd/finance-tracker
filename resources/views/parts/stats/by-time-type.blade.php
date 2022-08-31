<table class="table" id="table-time-type">
    <caption class="caption-top">{{ __('tables.by_category_daily') }}</caption>

    <thead class="table-light sticky-top">
    <tr>
        <td>{{ __('tables.category') }}</td>
        <td>{{ __('tables.sum') }}</td>
        <td>{{ __('tables.min') }}</td>
        <td>{{ __('tables.max') }}</td>
        <td>{{ __('tables.avg') }}</td>
    </tr>
    </thead>

    <tbody>
    @foreach ($data as $item)
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

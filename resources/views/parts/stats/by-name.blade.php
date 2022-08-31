<table class="table" id="table-name">
    <caption class="caption-top">{{ __('tables.by_name') }}</caption>

    <thead class="table-light sticky-top">
    <tr>
        <td>{{ __('tables.name') }}</td>
        <td>{{ __('tables.sum') }}</td>
        <td>{{ __('tables.min') }}</td>
        <td>{{ __('tables.max') }}</td>
        <td>{{ __('tables.avg') }}</td>
        <td>{{ __('tables.count') }}</td>
    </tr>
    </thead>

    <tbody>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['sum'] }}</td>
            <td>{{ $item['min'] }}</td>
            <td>{{ $item['max'] }}</td>
            <td>{{ $item['avg'] }}</td>
            <td>{{ $item['count'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

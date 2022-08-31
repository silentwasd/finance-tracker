<table class="table" id="table-general">
    <caption class="caption-top">{{ __('tables.general') }}</caption>

    <tbody>

    <tr>
        <td>{{ __('tables.monthly_total') }}</td>
        <td>{{ $data['sum'] }}</td>
    </tr>

    <tr>
        <td>{{ __('tables.daily_avg') }}</td>
        <td>{{ $data['avg'] }}</td>
    </tr>

    <tr>
        <td>{{ __('tables.daily_min') }}</td>
        <td>{{ $data['min'] }}</td>
    </tr>

    <tr>
        <td>{{ __('tables.daily_max') }}</td>
        <td>{{ $data['max'] }}</td>
    </tr>

    </tbody>
</table>

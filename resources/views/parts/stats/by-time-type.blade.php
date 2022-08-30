<table class="table" id="table-time-type">
    <caption class="caption-top">По типу (учитывается расход по дням)</caption>

    <thead class="table-light sticky-top">
    <tr>
        <td>Тип</td>
        <td>Сумма</td>
        <td>Минимум</td>
        <td>Максимум</td>
        <td>Среднее</td>
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

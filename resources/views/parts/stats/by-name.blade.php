<table class="table" id="table-name">
    <caption class="caption-top">По наименованию (учитывается расход по записям)</caption>

    <thead class="table-light sticky-top">
    <tr>
        <td>Наименование</td>
        <td>Сумма</td>
        <td>Минимум</td>
        <td>Максимум</td>
        <td>Среднее</td>
        <td>Кол-во</td>
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

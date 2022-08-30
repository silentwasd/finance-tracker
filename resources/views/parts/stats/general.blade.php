<table class="table" id="table-general">
    <caption class="caption-top">Общее</caption>

    <tbody>

    <tr>
        <td>Всего за месяц</td>
        <td>{{ $data['sum'] }}</td>
    </tr>

    <tr>
        <td>В среднем за день</td>
        <td>{{ $data['avg'] }}</td>
    </tr>

    <tr>
        <td>Минимум за день</td>
        <td>{{ $data['min'] }}</td>
    </tr>

    <tr>
        <td>Максимум за день</td>
        <td>{{ $data['max'] }}</td>
    </tr>

    </tbody>
</table>

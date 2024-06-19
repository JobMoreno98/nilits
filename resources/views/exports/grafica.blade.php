<table>
    <thead>
        <tr>
            <th>Categoria</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

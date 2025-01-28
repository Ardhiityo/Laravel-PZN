<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($todos as $todo)
        <tr>
            <td>{{ $todo['title'] }}</td>
            <td>
            @can('update', $todo)
                Update
            @else
                No Update
            @endcan
            </td>
            <td>
            @can('delete', $todo)
                Delete
            @else
                No Delete
            @endcan
        </td>
        </tr>
    @endforeach
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @while ($i < 5)
        <p>Value loop {{ $i }}</p>
        @php
            $i++;
        @endphp
    @endwhile
</body>

</html>

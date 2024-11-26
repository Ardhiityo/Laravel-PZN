<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- Akan mendisabled jika ada kode di dalamnya --}}
    <h1>Hello @{{ $name }}</h1>

    {{-- Akan mendisabled jika ada kode di dalamnya apabila memiliki kode yang banyak di dalamnya --}}
    @verbatim
        <p>
            Hello {{ $name }}
            Hello {{ $name }}
            Hello {{ $name }}
            Hello {{ $name }}
            Hello {{ $name }}
            Hello {{ $name }}
        </p>
    @endverbatim
</body>

</html>

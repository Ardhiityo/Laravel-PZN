<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- Dengan Unless, akan dieksekusi jika kondisi false --}}
    @unless ($isAdmin)
        <h1>You are not admin</h1>
    @endunless
</body>

</html>

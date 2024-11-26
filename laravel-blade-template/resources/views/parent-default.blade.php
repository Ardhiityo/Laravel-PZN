<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nama Aplikasi - @yield('title')</title>
</head>

<body>

    {{-- Apabila tidak ada section yang di-extends, maka akan menggunakan defaultnya --}}

    {{-- Default Header --}}
    @section('header')
        <h1>Default Header</h1>
    @show

    {{-- Default Content --}}
    @section('content')
        <h1>Default Content</h1>
    @show
</body>

</html>

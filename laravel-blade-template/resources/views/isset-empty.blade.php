<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @isset($name)
        <h1>Hello, {{ $name }}</h1>
    @endisset

    @empty($hobbies)
        <h1>I don't have any hobbies</h1>
    @endempty
</body>

</html>

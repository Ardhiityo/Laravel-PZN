<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="/form" method="post">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <button type="submit">SayHello</button>
    </form>
</body>

</html>

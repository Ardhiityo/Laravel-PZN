<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @error('name')
        <h1>{{ $message }}</h1>
    @enderror
    @error('password')
        <h1>{{ $message }}</h1>
    @enderror
</body>

</html>

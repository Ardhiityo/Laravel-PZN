<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @push('stack')
        <script src="first.js"></script>
    @endpush
    @push('stack')
        <script src="second.js"></script>
    @endpush
    @prepend('stack')
        <script src="third.js"></script>
    @endprepend
    @stack('stack')
</body>

</html>

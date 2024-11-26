<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- Tidak direkomendasikan menggunakan raw php --}}
    @php
        class Person
        {
            public $name;
            public $address;
        }

        $person = new Person();
        $person->name = 'John Doe';
        $person->address = '123 Main St';
    @endphp

    <p>{{ $person->name }}</p>
    <p>{{ $person->address }}</p>
</body>

</html>

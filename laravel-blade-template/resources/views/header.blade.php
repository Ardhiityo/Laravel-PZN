@isset($title)
    <h1>{{ $title }}</h1>
@else
    <h1>PZN</h1>
@endisset

@isset($desc)
    <p>{{ $desc }}</p>
@endisset

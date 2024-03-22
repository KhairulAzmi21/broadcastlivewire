<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
        <script src="https://kit.fontawesome.com/89828a0f02.js" crossorigin="anonymous"></script>
    </head>

    <body>
        {{ $slot }}
    </body>

</html>

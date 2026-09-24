@props(['title' => config('site.name')])

<!DOCTYPE html>
<html lang="hu" class="has-[dialog[open]]:overflow-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-ink antialiased">
        {{ $slot }}
    </body>
</html>

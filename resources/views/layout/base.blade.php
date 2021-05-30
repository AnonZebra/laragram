<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
        <link rel="shortcut icon" href="{{ url('favicon.ico') }}">
        <title>Laragram: @yield('title')</title>
        @yield('script-tags')

    </head>
    <body>
        <header>

        </header>

        <main>
            @yield('content')
        </main>

        <footer>

        </footer>

    </body>


</html>

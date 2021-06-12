<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
        <link rel="shortcut icon" href="{{ url('favicon.ico') }}">
        <title>Laragram: @yield('title')</title>
        <script src="{{ url('/js/app.js') }}" defer></script>
        @yield('script-tags')

    </head>
    <body>
        @include('layout.header')

        <main class="@yield('main-class')">
            @if ($errors->any())
                <div class="message warning-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>

        @include('layout.footer')

    </body>


</html>

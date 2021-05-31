<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
        <link rel="shortcut icon" href="{{ url('favicon.ico') }}">
        <title>Laragram: @yield('title')</title>
        <script src="js/app.js" defer></script>
        @yield('script-tags')

    </head>
    <body>
        <header class="site-header">
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('showLogin') }}">{{ __("Log in") }}</a>
                    </li>
                </ul>
            </nav>
            <div class="language-picker-wrapper">
                <ul class="language-picker">
                    <li>Language</li>
                    <li><a href="{{ route('updateLocale', ['language' => 'ja']) }}">日本語</a></li>
                    <li><a href="{{ route('updateLocale', ['language' => 'en']) }}">EN</a></li>
                    <li><a href="{{ route('updateLocale', ['language' => 'sv']) }}">SV</a></li>
                </ul>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>

        </footer>

    </body>


</html>

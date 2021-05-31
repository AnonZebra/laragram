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
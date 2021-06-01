<header class="site-header">
    <nav>
        <ul>
        @if (!Auth::user())
            <li>
                <a href="{{ route('guest.showLogin') }}">{{ __("Log in") }}</a>
            </li>
        @else
            <li>
                <a href="{{ route('user.home') }}">{{ __("Home") }}</a>
            </li>
            <li>
                <a href="{{ route('user.processLogout') }}">{{ __("Log out") }}</a>
            </li>
        @endif
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
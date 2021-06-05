<header class="site-header">
    <nav>
        <ul>
        @if (!Auth::user())
            <li>
                <a href="{{ route('guest.showLogin') }}">{{ __("Log in") }}</a>
            </li>
            <li>
                <a href="{{ route('guest.showRegistration') }}">{{ __("Register") }}</a>
            </li>
        @else
            <li>
                <a href="{{ route('user.home') }}">{{ __("Home") }}</a>
            </li>
        @endif
        </ul>
    </nav>
    <div class="language-picker-wrapper">
        <ul class="language-picker" id="language-picker">
            <li>文/A</li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'ja']) }}">日本語</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'en']) }}">EN</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'sv']) }}">SV</a></li>
        </ul>
    </div>
</header>
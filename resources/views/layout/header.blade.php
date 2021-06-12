<header class="site-header">
    <div class="site-title-wrapper">
        <a id="site-logo" class="site-logo" href="{{ route('guest.showLogin') }}">LaraGram</a>
    </div>
    <nav class="desktop-nav">
        @include('layout.navcontent')
    </nav>
    <div class="desktop-language-picker-wrapper">
        <ul class="language-picker" id="language-picker">
            <li>文/A</li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'ja']) }}">日本語</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'en']) }}">EN</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'sv']) }}">SV</a></li>
        </ul>
    </div>
    <a id="menu-toggle" href="#" class="menu-toggle">
        <img src="{{ URL::to('/') }}/siteimg/hamburger-menu.svg" alt="An icon consisting of three lines, indicating a menu toggler here."></img>
    </a>
</header>

<nav id="mobile-nav" class="mobile-nav">
    @include('layout.navcontent')
    <ul class="mobile-language-picker" id="mobile-language-picker">
            <li>文/A</li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'ja']) }}">日本語</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'en']) }}">EN</a></li>
            <li class="language-choice display-none"><a href="{{ route('updateLocale', ['language' => 'sv']) }}">SV</a></li>
    </ul>
</nav>
<div id="mobile-nav-shadow" class="mobile-nav-shadow"></div>
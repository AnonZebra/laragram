<ul class="nav-link-list">
    @if (!Auth::user())
        <li>
            <a href="{{ route('guest.showLogin') }}">{{ __("Log in") }}</a>
        </li>
        <li>
            <a href="{{ route('guest.showRegistration') }}">{{ __("Registration") }}</a>
        </li>
    @else
        <li>
            <a href="{{ route('user.profile') }}">{{ __("Home") }}</a>
        </li>
        <li>
            <a href="{{ route('user.showPhotoForm') }}">{{ __("Image upload") }}</a>
        </li>
    @endif
</ul>
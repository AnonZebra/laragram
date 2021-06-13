<ul class="nav-link-list">
    <li>
        <a href="{{ route('newUsers') }}">{{ __("New users") }}</a>
    </li>
    @if (!Auth::user())
        <li>
            <a href="{{ route('guest.showLogin') }}">{{ __("Log in") }}</a>
        </li>
        <li>
            <a href="{{ route('guest.showRegistration') }}">{{ __("Registration") }}</a>
        </li>
    @else
        <li>
            <a href="{{ route('user.profile') }}">{{ __("Profile") }}</a>
        </li>
        <li>
            <a href="{{ route('user.showPhotoForm') }}">{{ __("Image upload") }}</a>
        </li>
    @endif
</ul>
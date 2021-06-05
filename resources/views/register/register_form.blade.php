@extends('..layout.base')

@section('script-tags')
<script src="js/register-form.js" defer></script>
@endsection

@section('title')
{{ __("Create account") }}
@endsection

@section('content')
<h1>@yield('title')</h1>
<form id="register-form" method="POST" class="regular-form" action="{{ route('guest.processRegistration') }}">
    @csrf
    <label for="name">{{ __("Name") }}</label>
    <input id="name" name="name" type="text" placeholder="{{ __('Jane Doe') }}" minlength=3>
    <label for="email">{{ __("E-mail address") }}</label>
    <input id="email" name="email" type="text" placeholder="rei@example.com" pattern=".+@.+\..+">
    <label for="password">{{ __("Password") }}</label>
    <input id="password" name="password" type="password" minlength=6>
    <label for="password_confirmation">{{ __("Password (confirm)") }}</label>
    <input id="password_confirmation" name="password_confirmation" type="password" minlength=6>

    <button type="submit" class="button primary-button column-span-2">{{ __("Register") }}</button>
</form>

<a class="button secondary-button" href="{{ route('guest.showLogin') }}">{{ __("Log in") }}</a>
@endsection
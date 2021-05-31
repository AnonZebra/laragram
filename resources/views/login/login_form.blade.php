@extends('..layout.base')

@section('title')
{{ __("Log in") }}
@endsection

@section('content')
<h1>@yield('title')</h1>
@if ($errors->any())
    <div class="message alert-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="login-form" method="POST" class="regular-form" action="{{ route('processLogin') }}">
    @csrf
    <label for="email">{{ __("E-mail address") }}</label>
    <input id="email" type="text" name="email" placeholder="{{ __('jane@example.com') }}" pattern=".+@.+\..+" required>
    <label for="password">{{ __("Password") }}</label>
    <input id="password" name="password" type="password" minlength=6 required>
    <button type="submit" class="button primary-button column-span-2">{{ __("Log in") }}</button>
</form>
@endsection
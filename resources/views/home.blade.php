@extends('layout.base')

@section('title')
{{ __('Home') }}
@endsection

@section('content')
@if (session('login_success'))
<div class="message primary-message">
    <p>{{ __("You are now logged in") }}</p>
</div>
@endif
<section class="user-profile">
    <h2>{{ __('Profile') }}</h2>
    <ul>
        <li>{{ __("Name") }}: {{ Auth::user()->name }}</li>
        <li>{{ __("E-mail address")}}: {{ Auth::user()->email }}
    </ul>
</section>
@endsection
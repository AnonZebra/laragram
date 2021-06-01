@extends('layout.base')

@section('title')
{{ __('Home') }}
@endsection

@section('content')
@if (session('login_success'))
<x-alert type="primary" :message="session('login_success')"/>
@endif
<section class="user-profile">
    <h2>{{ __('Profile') }}</h2>
    <ul>
        <li>{{ __("Name") }}: {{ Auth::user()->name }}</li>
        <li>{{ __("E-mail address")}}: {{ Auth::user()->email }}
    </ul>
</section>
<form class="single-button-form" method="POST" action="{{ route('user.processLogout') }}">
    @csrf
    <button type="submit" class="button secondary-button">{{ __("Log out") }}</button>
</form>
@endsection
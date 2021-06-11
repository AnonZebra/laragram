@extends('layout.base')

@section('title')
{{ __('Profile') }}
@endsection

@section('content')
@if (session('login_success'))
<x-alert type="primary" :message="session('login_success')"/>
@endif
<form id="profile-form" method="POST" class="regular-form" action="{{ route('user.processUpdateProfile') }}" enctype="multipart/form-data">
    @csrf
    <h2 class="column-span-2">{{ __('Profile') }}</h2>
    <h3 class="column-span-2">{{ Auth::user()->name }}</h3>
    <p class="column-span-2">{{ __("E-mail address")}}: {{ Auth::user()->email }}</p>
    @if (Auth::user()->profile->image)
        <img src="{{ URL::to('/') }}{{ Storage::url(Auth::user()->profile->image) }}" class="column-span-2 profile-image-medium">
    @endif
    <label for="description">{{ __("Self-introduction")}}</label>
    <textarea id="description-input" name="description">{{ Auth::user()->profile->description }}</textarea>
    
    <label for="image">{{ __("Image") }}</label>
    <input id="image" type="file" name="image">
    
    <button type="submit" class="button primary-button column-span-2">{{ __("Update") }}</button>
</form>

<form class="single-button-form" method="POST" action="{{ route('user.processLogout') }}">
    @csrf
    <button type="submit" class="button secondary-button">{{ __("Log out") }}</button>
</form>
@endsection
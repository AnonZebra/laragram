@extends('layout.base')

@section('title')
{{ __("Submit image") }}
@endsection

@section('content')
<h1>@yield('title')</h1>

<form id="profile-form" method="POST" class="regular-form" action="{{ route('user.processPhotoForm') }}" enctype="multipart/form-data">
    @csrf
    <label for="image">{{ __("Image") }}</label>
    <input id="image" type="file" name="image">

    <label for="description">{{ __("imgdesc")}}</label>
    <textarea id="description-input" name="description">{{ Auth::user()->profile->description }}</textarea>    
    
    <button type="submit" class="button primary-button column-span-2">{{ __("submitbtn") }}</button>
</form>

@endsection
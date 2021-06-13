@extends('layout.base')

@section('title')
{{ __('New users') }}
@endsection

@section('main-class')
photo-user-list-main
@endsection

@section('content')
<h1>@yield('title')</h1>
@if ($users)
<ul class="photo-user-list">
    @foreach ($users as $user)
        <li>
            <a href="{{ route('showPhotoList', ['id' => $user->id]) }}" class="photo-user-list-link">
                <p class="photo-user-list-name">{{ $user->name }}</p>
                <div class="photo-user-list-portrait-wrapper">
                    @if ($user->profile->image)
                        <img src="{{ URL::to('/') }}{{ Storage::url($user->profile->image) }}" class="photo-user-list-portrait profile-image-medium"></img>
                    @else
                        <img src="{{ URL::to('/') }}/siteimg/unknown-person.svg" class="photo-user-list-portrait profile-image-medium"></img>
                    @endif
                </div>
            </a>
        </li>
    @endforeach
</ul>
@else
<p>{{ __('nousers') }}</p>
@endif
@endsection

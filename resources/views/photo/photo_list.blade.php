@extends('layout.base')

@section('title')
{{  $username . __('ownparticle') . __('images') }}
@endsection

@section('main-class')
photo-main
@endsection

@section('content')
<h1>@yield('title')</h1>
@if (count($photoPosts) > 0)
<ul class="photo-list">
@foreach ($photoPosts as $photoPost)
    <li>
        <figure class="photo-list-figure">
            <img src="{{ URL::to('/') }}{{ Storage::url($photoPost->image) }}" class="photo-list-image">
            <figcaption class="photo-list-caption">{{ $photoPost->description }}</figcaption>
        </figure>
    </li>
@endforeach
</ul>
@else
<p>{{ __('usernoimages') }}</p>
@endif
@endsection

@extends('layout.base')

@section('title')
Laragram - {{ $postOwnerName }}
@endsection

@section('main-class')
photo-detail-main
@endsection

@section('content')
<figure class="photo-detail-figure">
    <img src="{{ URL::to('/') }}{{ Storage::url($post->image) }}" class="photo-detail-image" alt="{{ $post->description }}">
    <a rel="author" href="{{ route('showPhotoList', ['id' => $postOwnerId]) }}" class="photo-detail-owner">
        @if ($postOwnerPortrait)
            <img src="{{ URL::to('/') }}{{ Storage::url($postOwnerPortrait) }}" class="photo-user-detail-portrait profile-image-small"></img>
        @else
            <img src="{{ URL::to('/') }}/siteimg/unknown-person-black.svg" class="photo-user-detail-portrait profile-image-small"></img>
        @endif
        <span class="photo-detail-owner-name">{{ $postOwnerName }}</span>
    </a>
    <figcaption class="photo-detail-caption">{{ $post->description }}</figcaption>
</figure>
@endsection

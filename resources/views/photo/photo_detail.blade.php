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
    <a rel="author" href="{{ route('showPhotoList', ['id' => $photoOwnerId]) }}" class="photo-detail-owner">
        @if ($postOwnerPortrait)
            <img src="{{ URL::to('/') }}{{ Storage::url($postOwnerPortrait) }}" class="photo-user-detail-portrait profile-image-small"></img>
        @else
            <img src="{{ URL::to('/') }}/siteimg/unknown-person-black.svg" class="photo-user-detail-portrait profile-image-small"></img>
        @endif
        <span class="photo-detail-owner-name">{{ $postOwnerName }}</span>
    </a>
    <figcaption class="photo-detail-caption">{{ $post->description }}</figcaption>
</figure>
<a href="{{ route('user.showPhotoCommentForm', ['photoOwnerId' => $photoOwnerId, 'photoId' => $post->id]) }}" class="button secondary-button">
    {{ __('Add comment') }}
</a>

@if ($comments)
<ul class="photo-comment-list">
    @foreach ($comments as $comment)
        <li class="photo-comment-li">
            <a rel="author" href="{{ route('showPhotoList', ['id' => $comment->user->id]) }}" class="photo-detail-commenter">
                @if ($comment->user->profile->image)
                    <img src="{{ URL::to('/') }}{{ Storage::url($comment->user->profile->image) }}" class="photo-commenter-detail-portrait profile-image-mini"></img>
                @else
                    <img src="{{ URL::to('/') }}/siteimg/unknown-person-black.svg" class="photo-commenter-detail-portrait profile-image-mini"></img>
                @endif
                <span class="photo-detail-commenter-name">{{ $postOwnerName }}</span>
                <span class="photo-detail-comment-date">{{ date_parse($comment->updated_at)['year'] }}</span>
            </a>
            <p class="photo-detail-comment-body">{{ $comment->body }}</span>
        </li>
    @endforeach
</ul>
@else
<p>__("No comments yet.")</p>
@endif
@endsection

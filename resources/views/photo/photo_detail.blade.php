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
    <a rel="author" href="{{ route('showPhotoList', ['photoOwnerId' => $photoOwnerId]) }}" class="photo-detail-owner">
        @if ($postOwnerPortrait)
            <img src="{{ URL::to('/') }}{{ Storage::url($postOwnerPortrait) }}" class="photo-user-detail-portrait profile-image-small"></img>
        @else
            <img src="{{ URL::to('/') }}/siteimg/unknown-person-black.svg" class="photo-user-detail-portrait profile-image-small"></img>
        @endif
        @php
            $pUpdateDate = date_parse($post->updated_at)
        @endphp
        <span class="photo-detail-owner-name">{{ $postOwnerName }}</span>
    </a> 
    <figcaption class="photo-detail-caption">({{ $pUpdateDate['year'] }}-{{ str_pad($pUpdateDate['month'], 2, 0, STR_PAD_LEFT) }}-{{ str_pad($pUpdateDate['day'], 2, 0, STR_PAD_LEFT) }} {{ str_pad($pUpdateDate['hour'], 2, 0, STR_PAD_LEFT) }}:{{ str_pad($pUpdateDate['minute'], 2, 0, STR_PAD_LEFT) }}) {{ $post->description }} </figcaption>
</figure>
<a href="{{ route('user.showPhotoCommentForm', ['photoOwnerId' => $photoOwnerId, 'photoId' => $post->id]) }}" class="button secondary-button">
    {{ __('Add comment') }}
</a>

@if ($comments)
<ul class="photo-comment-list">
    @foreach ($comments as $comment)
        <li class="photo-comment-li">
            <a rel="author" href="{{ route('showPhotoList', ['photoOwnerId' => $comment->user->id]) }}" class="photo-detail-commenter">
                @if ($comment->user->profile->image)
                    <img src="{{ URL::to('/') }}{{ Storage::url($comment->user->profile->image) }}" class="photo-commenter-detail-portrait profile-image-mini"></img>
                @else
                    <img src="{{ URL::to('/') }}/siteimg/unknown-person-black.svg" class="photo-commenter-detail-portrait profile-image-mini"></img>
                @endif
                <span class="photo-detail-commenter-name">{{ $comment->user->name }}</span>
                @php
                $cUpdateDate = date_parse($comment->updated_at)
                @endphp
                <span class="photo-detail-comment-date">{{ $cUpdateDate['year'] }}-{{ str_pad($cUpdateDate['month'], 2, 0, STR_PAD_LEFT) }}-{{ str_pad($cUpdateDate['day'], 2, 0, STR_PAD_LEFT) }} {{ str_pad($cUpdateDate['hour'], 2, 0, STR_PAD_LEFT) }}:{{ str_pad($cUpdateDate['minute'], 2, 0, STR_PAD_LEFT) }}</span>
            </a>
            <p class="photo-detail-comment-body">{{ $comment->body }}</span>
        </li>
    @endforeach
</ul>
@else
<p>__("No comments yet.")</p>
@endif
@endsection

@extends('layout.base')

@section('title')
Laragram - {{ __("Add comment") }}
@endsection

@section('main-class')
photo-detail-main
@endsection

@section('content')
<figure class="photo-detail-figure">
    <img src="{{ URL::to('/') }}{{ Storage::url($post->image) }}" class="photo-detail-image" alt="{{ $post->description }}">
</figure>
<form id="comment-form" method="POST" class="regular-form" action="{{ route('user.processPhotoCommentForm', ['photoOwnerId' => $photoOwnerId, 'photoId' => $post->id]) }}">
    @csrf
    <label for="comment">{{ __("Comment")}}</label>
    <textarea id="comment-input" name="comment" maxlength=800></textarea>
    <button type="submit" class="button primary-button column-span-2">{{ __("submitbtn") }}</button>
</form>
@endsection

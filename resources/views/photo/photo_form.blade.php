@extends('layout.base')

@section('title')
{{ $userName . __('ownparticle') . __('images') }}
@endsection

@section('content')
<h1>@yield('title')</h1>

@endsection
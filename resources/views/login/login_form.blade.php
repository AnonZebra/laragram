@extends('..layout.base')

@section('title')
ログイン
@endsection

@section('content')
<h1>@yield('title')</h1>
@if ($errors->any())
    <div class="message alert-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id="login-form" method="POST" class="regular-form" action="{{ route('processLogin') }}">
    @csrf
    <label for="email">メールアドレス</label>
    <input id="email" type="text" name="email" placeholder="rei@example.com" pattern=".+@.+\..+" required>
    <label for="password">パスワード</label>
    <input id="password" name="password" type="password" minlength=6 required>
    <button type="submit" class="button primary-button column-span-2">ログイン</button>
</form>
@endsection
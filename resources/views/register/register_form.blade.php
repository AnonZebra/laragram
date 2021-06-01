@extends('..layout.base')

@section('script-tags')
<script src="js/register-form.js" defer></script>
@endsection

@section('title')
ユーザ登録
@endsection

@section('content')
<h1>@yield('title')</h1>
<form id="register-form" method="POST" class="regular-form">
    <label for="username">名前</label>
    <input id="username" name="username" type="text" placeholder="ネーム" minlength=3>
    <label for="email">メールアドレス</label>
    <input id="email" name="email" type="text" placeholder="rei@example.com" pattern=".+@.+\..+">
    <label for="password">パスワード</label>
    <input id="password" name="password" type="password" minlength=6>
    <label for="password_confirmation">パスワード（確認用）</label>
    <input id="password_confirmation" name="password_confirmation" type="password" minlength=6>

    <button type="submit" class="button primary-button column-span-2">登録</button>
</form>
@endsection
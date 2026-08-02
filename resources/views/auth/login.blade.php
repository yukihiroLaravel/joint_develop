@extends('layouts.app')
@section('content')
<!-- design-update: タイトル+ロゴのみ表示 -->
<div class="text-center mt-2 pt-1 du-auth-header">
    <h1 class="du-font-title">今日のつぶやき<img src="/images/logo.svg" alt="今日のつぶやきロゴ" class="du-logo-mark"></h1>
</div>
<div class="text-center mt-3">
    <p class="text-center">ログインすると<br>つぶやけるようになります。</p>
</div>
<div class="text-center">
    <h3 class="du-auth-title text-left d-inline-block mt-5">ログイン</h3>
</div>
<div class="row mt-5 mb-5">
    <div class="col-sm-6 offset-sm-3">
        @include('commons.error_messages')
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
            </div>
            <button type="submit" class="btn btn-primary du-btn-link mt-2">ログイン</button>
        </form>
        <div class="mt-2"><a href="{{ route('signup') }}" class="du-text-link">新規ユーザ登録はこちら。</a></div>
    </div>
</div>
@endsection

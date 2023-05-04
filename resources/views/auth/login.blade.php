@extends('layouts.app')
@section('content')
<div class="text-center ">
    <h1><i class="fas fa-baseball-ball pr-3 d-inline "></i>大谷選手の応援掲示板へようこそ</h1>
</div>
<div class="text-center mt-3">
    <h5 class="text-left d-inline-block">ログインすると大谷選手に関する投稿を仲間とシェアできます。<br>みんなで大谷選手を応援しよう⚾️</h5>
</div>
<div class="text-center">
    <h3 class="login_title text-left d-inline-block mt-5">ログイン</h3>
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
            <button type="submit" class="btn btn-success mt-2">ログイン</button>
            <div class="mt-2"><a href="{{ route('signup') }}">新規ユーザ登録する？</a></div>
        </form>
    </div>
</div>
@endsection


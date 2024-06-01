@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h3 class="login_title d-inline-block mt-5">ログイン</h3>
    </div>
    <div class="text-center mt-3">
        <p class="d-inline-block">ログインして<br>あなたの趣味をシェアしましょう！</p>
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
                    <input id="password" type="password" class="form-control" name="password" value="">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-2">ログイン</button>
                </div>
            </form>
            <div class="text-center mt-4"><a href="{{ route('signup') }}">新規ユーザ登録はこちら</a></div> <!-- 新規ユーザ登録画面への遷移ルーティング追記 -->
        </div>
    </div>
@endsection

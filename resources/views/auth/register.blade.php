@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h3 class="login_title d-inlin-block mt-5">新規ユーザ登録<h/3>
    </div>
    <div class="text-center mt-3">
        <p class="d-inlin-black">新規ユーザ登録すると、<br>あなたの趣味を投稿できるようになります。</p>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">
            @include('commons.error_messages')
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                <div class="form-group">
                    <lavel for="name">名前</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <lavel for="email">メールアドレス</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <lavel for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <lavel for="password_confirmation">パスワード確認</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-2">登録</button>
                </div>
            </from>
        </div>
    </div>
@endsection

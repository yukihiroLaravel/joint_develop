@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h1><i class="fas fa-solid fa-headphones"></i>ゲーアニ Music Board</h1>
    </div>
    <div class="text-center mt-3">
        <p class="text-left d-inline-block">ログインすると投稿で<br>コミュニケーションができるようになります。</p>
    </div>
    <div class="text-center">
        <h3 class="login_title text-left d-inline-block mt-5">ログイン</h3>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">
            <div class="w-100 m-auto">@include('commons.error_messages')</div>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input id="password" type="password" class="form-control" name="password" >
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">ログイン</button>
                </form>
            <div class="mt-2"><a href="#">新規ユーザ登録する？</a></div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
<div class="text-center">
       <h1>
            <img src="{{ asset('images/tokyo-DeafLympic2025_Emblem.jpg') }}"
                alt="デフリンピック エンブレム"
                class="mx-2 align-middle"
                style="height: 60px;">
                TOKYO 2025 デフリンピック
        </h1>
    </div>
    <div class="text-center mt-3">
        <p class="text-left d-inline-block">ログインすると投稿で<br>コミュニケーションができるようになります。</p>
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
                <button type="submit" class="btn btn-primary mt-2">ログイン</button>
            </form>
            <div class="mt-2"><a href="{{ route('signup') }}">新規ユーザ登録する？</a></div>
        </div>
    </div>
@endsection
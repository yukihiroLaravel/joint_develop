@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h1><img style="height:40px; width:40px" src="{{ asset('img/icon2.png') }}"  alt="ロゴ画像２">RamenTube<img src="{{ asset('img/icon2.png') }}" style="height:40px; width:40px;" alt="ロゴ画像２"></h1>
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
                    <input id="password" type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-warning mt-2">
                    <i class="fas fa-sign-out-alt"></i> ログイン
                </button>
            </form>
            <div class="mt-2"><a href="{{ route('signup') }}">新規ユーザ登録する？</a></div>
        </div>
    </div>
@endsection
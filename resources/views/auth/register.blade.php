@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h1><i class="fas fa-baseball-ball fa-lg pr-3"></i>大谷選手を応援する仲間になろう</h1></h1>
    </div>
    <div class="text-center mt-3">
        <h5 class="text-left d-inline-block">新しくメンバーになると大谷選手に関する投稿ができます。<br>みんなで応援しましょう🧢</h5>
    </div>
    <div class="text-center">
        <h3 class="login_title text-left d-inline-block mt-5">新規ユーザ登録</h3>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">
            @include('commons.error_messages')
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                <div class="form-group">
                    <label for="name">名前</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">パスワード確認</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                </div>
                <button type="submit" class="btn btn-success mt-2">新規登録</button>
            </form>
        </div>
    </div>
@endsection

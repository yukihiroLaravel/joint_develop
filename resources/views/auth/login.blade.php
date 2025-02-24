@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
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
                <input type="hidden" name="intended" id="intended-url" value="">
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" name="password"
                        value="{{ old('password') }}">
                </div>
                <button type="submit" class="btn mt-2" style="background-color: #2E8B57; color: white;">ログイン</button>
            </form>
            <div class="mt-2"><a href="{{ route('signup') }}">新規ユーザ登録する？</a></div>
        </div>
    </div>
@endsection

<script>
    // ログイン画面遷移前のURLをセッションから取得
    document.addEventListener("DOMContentLoaded", function() {
        var previousUrl = sessionStorage.getItem('previousUrl');
        if (previousUrl) {
            sessionStorage.removeItem('previousUrl');
            document.getElementById("intended-url").value = previousUrl;
        }
    });
</script>

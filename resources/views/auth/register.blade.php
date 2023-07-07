@extends('layouts.app')
@section('content')
<div class="text-center">
    <h1><i class="fab fa-telegram fa-lg pr-3 text-black mt-2 pt-1"></i><span class="text-black">みんなの大喜利「GiriGiri」</span></h1>
</div>
<div class="text-center mt-3 text-black">
    <p class="text-left d-inline-block text-black">新規ユーザ登録すると、お題・ボケの投稿や<br>いいね・ワロタ・フォローができるようになります。
</div>
<div class="text-center">
    <h3 class="login_title text-black d-inline-block mt-5">新規ユーザ登録</h3>
</div>
<div class="row mt-5 mb-5">
    <div class="col-sm-6 offset-sm-3">
        @include('commons.error_messages')
        <form method="POST" action="{{ route('signup.post') }}">
            @csrf
            <div class="form-group">
                <label for="name" class="text-black">名前</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="email" class="text-black">メールアドレス</label>
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password" class="text-black">パスワード</label>
                <input id="password" type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation" >パスワード確認</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary mt-2">新規登録</button>
        </form>
    </div>
</div>
@endsection

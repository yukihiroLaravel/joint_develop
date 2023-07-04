@extends('layouts.app')
@section('title', '新規ユーザー登録ページ')
@section('description', '新規ユーザーとして登録できます。ユーザーになると投稿でコミュニケーションできるようになります。')
@section('content')
<div class="text-center">
    <h1><i class="fas fa-home fa-lg pr-3"></i>おうち時間の過ごし方</h1>
</div>
<div class="text-center mt-3">
    <p class="text-left d-inline-block">新規ユーザ登録すると投稿で<br>コミュニケーションができるようになります。</p>
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
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">パスワード確認</label>
                <input id="password_confirmation" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password_confirmation" value="{{ old('password_confirmation') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">
                <i class="fas fa-user-edit"></i> 新規登録
            </button>
        </form>
    </div>
</div>
@endsection
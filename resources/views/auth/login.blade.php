@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h1><i class="fas fa-home fa-lg pr-3"></i>Topic Posts</h1>
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
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-sign-in-alt"></i> ログイン
                </button>
            </form>
            <div class="mt-2">
                <a href="{{ route('signup') }}">
                    <i class="fas fa-user-edit"></i> 新規ユーザ登録する？
                </a>
            </div>
        </div>
    </div>
@endsection

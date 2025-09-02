@extends('layouts.app')
@section('content')
    <div class="text-center text-white mb-4">
        <h1><i class="fas fa-campground mr-2"></i>Enjoy the Outdoors</h1>
        <p class="lead">キャンプの魅力について語ろう！</p>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3">
            <div class="card shadow-lg" style="background-color: rgba(255, 255, 255, 0.9); border: 2px solid #4a3f35;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 text-success">
                        <i class="fas fa-sign-in-alt"></i> ログイン 
                    </h3>
                    @include('commons.error_messages')
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">メールアドレス</label>
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">パスワード</label>
                            <input id="password" type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-warning btn-block mt-3">
                            <i class="fas fa-sign-in-alt"></i> ログイン
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('signup') }}" class="text-success font-weight-bold">
                            <i class="fas fa-user-plus"></i>新規ユーザ登録はこちら
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
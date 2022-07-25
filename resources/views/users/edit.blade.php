@extends('layouts.app')
@section('content')

    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('users.update', $user->id) }}" >
        @csrf
        @method('PUT')
        <div class="row form-group mt-3 mb-1">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">ユーザ名</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">パスワードの確認</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger">退会する</button>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>

@endsection

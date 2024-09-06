@extends('layouts.app')
@section('content')
    <h2 class="mt-5">ユーザ情報を編集する</h2>
    <form method="POST" action="{{ route('user.update', $user->id) }}">
    <input type="hidden" name="id" value="" />
        @csrf
        @method('PUT')
        <div class="form-group mt-5">
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
            <button type="submit" class="btn btn-primary mt-5 mb-5">更新する</button>
        </div>
    </form>
@endsection
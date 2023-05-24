@extends('layouts.app')
@section('content')
@include('commons.error_messages')
<h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="POST" action="{{ route('update', \Auth::user()->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{ old('name', $user->name) }}" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="{{ old('email', $user->email) }}" name="email" />
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" input class="form-control" type="password" value="{{ old('password') }}" name="password" />

        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input id="password_confirmation" input class="form-control" type="password" name="password_confirmation" />
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
@endsection
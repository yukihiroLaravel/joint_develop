@extends('layouts.app')
@section('content')
    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="POST" action="{{ route('users.update', ['id' => Auth::id()]) }}">
        @csrf
        @method('PUT')
        @include('commons.error_messages')
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
            <input class="form-control" type="password" name="password" />
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input class="form-control" type="password" name="password_confirmation" />
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
@endsection
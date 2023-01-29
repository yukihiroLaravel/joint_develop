@extends('layouts.app')
		
@section('content')

<h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
<div class="w-75 m-auto">@include('commons.error_messages')</div>
<form method="POST" action="{{ route('users.store') }}">
    @csrf
        <input type="hidden" name="id" value="{{ old('name') }}" />
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{ old('name') }}" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="{{ old('email') }}" name="email" />
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
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
</form>

@endsection

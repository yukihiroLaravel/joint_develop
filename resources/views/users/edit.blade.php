@extends('layouts.app')
@section('content')
 <div class="text-center">
    <h1>ユーザ情報を編集する</h1>
 </div>
<div class="row mt-5 mb-5">
    <div class="col-sm-10 offset-sm-1">
        @include('commons.error_messages')
        <form method="POST" action="{{ route('user.update',$user->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">ユーザー名</label for-"name">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email',$user->email) }}">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password',$user->password) }}">
            </div>
            <div class="form-group">
                <label for="password">パスワードの確認</label>
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password',$user->password) }}">
            </div>
            <div class="d-flex justify-content-between">
            <button type="submit" class="mt-3 btn btn-danger ">退会する</button>
            <button type="submit"class="mt-3 btn btn-primary">更新する</a></button>
            </div>
        </form>
    </div>
</div>
@endsection
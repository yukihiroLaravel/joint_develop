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
                    <label>ユーザ名</label>
                    <input type="text" class="form-control" name="user_name" value="{{ old('user_name') }}">
                </div>
                <div class="form-group">
                    <label>メールアドレス</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label>パスワード</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label>パスワードの確認</label>
                    <input type="password" class="form-control" name="confirmPassword">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-danger">退会する</button>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>

        
@endsection

<!-- 
<h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="" action="">
        <input type="hidden" name="id" value="" />
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="" name="" />
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input class="form-control" type="password" name="" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input class="form-control" type="password" name="" />
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
-->






@extends('layouts.app')
@section('content')
    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')
    @include('commons.error_messages')
        <div class="form-group">
            <label for="name">ユーザー名</label for-"name">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="mt-3 btn btn-danger ">退会する</button>
            <button type="submit"class="mt-3 btn btn-primary">更新する</a></button>
        </div>
    </form>

        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-modal-label">退会</h4>
                        <form method="POST" action="{{ route('users.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>本当に退会しますか？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                        <button type="submit" id="delete-button" class="btn btn-danger">退会する</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

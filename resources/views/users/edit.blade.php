@extends('layouts.app')
@section('content')
    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}"> --}}
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
            <a href="#" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger">退会する</a>
            <button type="submit"class="mt-3 btn btn-primary">更新する</a></button>
        </div>
    </form>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">確認</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('users.delete', $user->id) }}">
                @csrf
                @method('DELETE')
                <label>本当に退会しますか？</label>
                <div class="modal-footer">
                  <button type="submit" id="delete-button" class="btn btn-danger">退会する</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>     
@endsection

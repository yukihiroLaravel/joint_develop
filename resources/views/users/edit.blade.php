@extends('layouts.app')
@section('content')
<!-- design-update: 見出しのフォントとボタンの色を変更 -->
<div class="text-center">
    <h2 class="du-auth-title text-left d-inline-block mt-5 mb-3">ユーザ情報を編集する</h2>
</div>
<div class="row mb-5">
    <div class="col-sm-6 offset-sm-3">
        @include('commons.error_messages')
        <form method="POST" action="{{route('users.update', $user->id)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">ユーザ名</label>
                <input class="form-control" value="{{ old('name', $user->name)}}" name="name" />
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input class="form-control" value="{{ old('email', $user->email)}}" name="email" />
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
                <a class="btn btn-danger du-btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
                <button type="submit" class="btn btn-primary du-btn-link">更新する</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>確認</h4>
            </div>
            <div class="modal-body">
                <label>本当に退会しますか？</label>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <form action="{{route('users.destroy', $user->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger du-btn-danger">退会する</button>
                </form>
                <button type="button" class="btn du-btn-muted" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
@endsection

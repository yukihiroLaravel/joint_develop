@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2 class="mb-0">ユーザ情報を編集する</h2>
        <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会</a>
    </div>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        @include('commons.error_messages')
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{ old('name', $user->name) }}" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" class="form-control" value="{{ old('email', $user->email) }}" name="email" />
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" class="form-control" type="password" value="" name="password" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input id="password_confirmation" class="form-control" type="password" value="" name="password_confirmation"/>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mb-2">更新</button>
        </div>
    </form>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>退会手続き</h4>
                </div>
                <div class="modal-body text-center">
                    <label>本当に退会してもよろしいでしょうか？</label>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <form action="{{ route('users.delete', $user->id) }}" method="POST">
                        @csrf <!-- ハッキングの手口から守る（POST実行時は必ず記載） -->
                        @method('DELETE') <!-- HTTPメソッドをDELETEに指定 -->
                        <button type="submit" class="btn btn-danger">退会</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')	
@section('content')    
    <form method="POST" action="{{ route('users.store', $user->id) }}">
        @csrf
        <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>

        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        
        <input type="hidden" name="id">

        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{ old('name') }}" name="name">
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="{{ old('email') }}" name="email">
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input class="form-control" type="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input class="form-control" type="password" name="password_confirmation">
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal{{ $user->id }}">退会する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>

    <div class="modal fade" id="deleteConfirmModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">        
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>確認</h4>
                </div>
                <div class="modal-body">
                    <label>本当に退会しますか？</label>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <form action="{{ route('users.delete', $user->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

@endsection

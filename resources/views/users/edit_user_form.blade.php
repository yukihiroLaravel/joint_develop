{{-- ユーザー編集画面 --}}
@extends('layouts.app')
@section('content')

    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    {{-- バリデーションエラーの表示 --}}
    @include('commons.error_messages')

    {{-- 共通削除モーダル。user_withdrawalボタンの中に入れると、formがネストされる。退会ボタンを押した瞬間に処理が発動してしまう。よって外に出した。 --}}
    @include('commons.delete_modal')

    <form method="POST" action="{{route('users.update', $user->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{$user->name}}" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="{{$user->email}}" name="email" />
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
            @include('buttons.user_withdrawal_button')
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
@endsection

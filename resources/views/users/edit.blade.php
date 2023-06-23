@extends('layouts.app')
@section('content')
<h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
@include('commons.error_messages')
    <form method="POST" action="{{ route('update', \Auth::user()->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="{{ old('name', $user->name) }}" name="name" />
        </div>
        <div class="form-group">
            <label for="profile_image">プロフィール画像</label>
            @if ($user->profile_image === null)
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 55) }}"
                    alt="{{ $user->name }}プロフィール画像">
            @else
                <img class="rounded-circle" src="{{ asset('storage/images/profiles/'.$user->profile_image) }}"
                    alt="{{ $user->name }}プロフィール画像" width="55" height="55">
            @endif
                <input id="profile_image" name="profile_image" type="file"
                    class="mt-1 pb-5 pt-3 form-control @error('profile_image') is-invalid @enderror" accept="image/png, image/jpeg">
                <p class="h6 text-secondary ml-3 ">
                    ※サイズは最大1MB、横幅1000pxまで可能（比率1:1推奨）
                </p>
            @error('profile_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="{{ old('email', $user->email) }}" name="email" />
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" input class="form-control" type="password" value="{{ old('password') }}" name="password" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input id="password_confirmation" input class="form-control" type="password" name="password_confirmation" />
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">
                <i class="fas fa-trash-alt"></i> 退会する
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-square"></i> 更新する
            </button>
        </div>
    </form>

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
                    <form method="POST" action="{{ route('user.delete', \Auth::user()->id) }}" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> 退会する
                        </button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i> 閉じる
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
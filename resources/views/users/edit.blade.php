@extends('layouts.app')
@section('content')
    <h2 class="mb-5 text-center">ユーザ情報を編集する</h2>
    @include('commons.error_messages')
    @if (isset($successMessage))
        <ul class="alert alert-success list-unstyled">
            <li class="ml-4">{{ $successMessage }}</li>
        </ul>
    @endif
    @php
        $id = $user->id;
    @endphp
    <div class="row">
        <aside class="col-sm-4 col-12 mb-5">
            <div class="card bg-info">
                <div class="card-body">
                    @include('commons.user_icon', ['user' => $user])
                    <div class="mt-3 text-center">
                        <a class="btn btn-warning col-10 text-light" data-toggle="modal" data-target="#iconChangeModal"
                            id="iconModalBtn">画像編集</a>
                    </div>
                </div>
            </div>
            <div class="cat1"><img src="https://abeaidesign.com/img/cat1.svg" alt="猫"></div>
        </aside>
        <div class="modal fade" id="iconChangeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" action="{{ route('usersIcon.updata', $id) }}" enctype="multipart/form-data"
                    id="user_icon" class="d-flex justify-content-center">
                    @csrf
                    @method('PUT')
                    <div class="modal-content card bg-info col-10">
                        <div class="card-body">
                            <p class="text-center" style="font-size: 1.3rem; color:white;">プレビュー</p>
                            <div id="user_icon_preview">
                                @include('commons.user_icon', ['user' => $user])
                            </div>
                            <label class="rounded-circle btn-warning add_icon-btn">
                                <i class="fas fa-plus"></i>
                                <input type="file" name="icon" accept=".png, .jpg, .jpeg" form="user_icon"
                                    id="input_user-icon" hidden>
                            </label>
                        </div>
                        <p class="text-center fileSize-text" style="font-size: 0.9rem; color:white;">画像サイズは1MBまでです。</p>
                        <div class="text-center  mb-4">
                            <button type="submit" class="btn btn-danger col-10 saveIcon-btn mb-3" disabled>保存</button>
                            <button type="button" class="btn col-10 cancel-modal-btn" data-dismiss="modal">キャンセル</button>
                        </div>
                </form>
                <button type="button" class="btn btn-default modal_close-btn" data-dismiss="modal"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-12">
        <form method="POST" action="{{ route('users.updata', $id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">ユーザ名</label>
                <input class="form-control" value="{{ old('name', $user->name) }}" name="name" />
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input class="form-control" value="{{ old('email', $user->email) }}" name="email" />
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
                <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
                <button type="submit" class="btn btn-primary">更新する</button>
            </div>
        </form>

        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>確認</h4>
                    </div>
                    <div class="modal-body">
                        <label>本当に退会しますか？</label>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <form action="{{ route('user.delete', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">退会する</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

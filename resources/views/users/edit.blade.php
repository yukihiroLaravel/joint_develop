@extends('layouts.app')
@section('content')
    <h2 class="mt-5 mb-5 text-center">ユーザ情報を編集する</h2>
    @include('commons.error_messages')
    @if (isset($successMessage))
        <ul class="alert alert-success">
            <li class="ml-4">{{ $successMessage }}</li>
        </ul>
    @endif
    @php
        $id = $user->id;
    @endphp
    <div class="d-flex flex-wrap">
        <aside class="col-sm-4 col-12">
            <div class="card bg-info">
                <div class="card-body">
                    @php
                        if ($user->icon == null) {
                            $iconSrc = Gravatar::src($user->email, 400);
                        } else {
                            $iconSrc = asset('storage/images/userIcons/' . $user->icon);
                        }
                    @endphp
                    <div class="preview-box">
                        <img src="{{ $iconSrc }}" alt="ユーザーアバター" id="user_icon_preview" class="rounded-circle img-fluid">
                    </div>
                    <div class="mt-3 text-center" style="gap: 0.5em">
                        <label class="btn btn-warning col-10">
                            画像追加
                            <input type="file" form="user_updata" name="icon" hidden>
                        </label>
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8 col-12">
            <form method="POST" action="{{ route('users.update', $id) }}" id="user_updata" enctype="multipart/form-data">
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

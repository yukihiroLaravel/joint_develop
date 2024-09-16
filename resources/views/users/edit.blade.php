@extends('layouts.app')
@section('content')
    @php
        /*
            更新成功時もトグル状態の復元したい
            (1) 更新成功時で、バリデーションエラーではない時
                sessionのほうは値あり ( 更新成功時にwithのflashで指定している )
                oldのほうは値がなし
            (2) バリデーションエラーの時
                sessionのほうは値なし
                oldのほうは値があり
            (3) 初期表示時は、どちらも値なしのためold()の第2引数のデフォルト値となる。
        */
        if (session('toggleOnOff')) {
            $toggleOnOff = session('toggleOnOff');
        } else {
            $toggleOnOff = old('toggleOnOff', 'OFF');
        }
    @endphp
    <a href="#" id="avatarToggleLink">アバター画像の表示／追加／削除をする</a>

    {{-- スペーサーとしてのdivタグ--}}
    <div style="margin: 15px;"></div>

    <script src="{{ asset('js/views/users/edit.js') }}"></script>

    <div id="divAvatar" class="row" style="margin-left: 50px; display: none;">

        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light" title="{{ $user->name }}">
                        {{ $user->truncateName(9) }}
                    </h3>
                </div>
                <div class="card-body">
                    @include('commons.avatar', [
                        'editFlg' => 'ON',
                        'imageSize' => '280',
                        'user' => $user,
                        'class' => 'rounded-circle img-fluid',
                    ])
                </div>
            </div>
        </aside>

        <div class="col-sm-8">
            <p style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
                <div style="color:red;">
                    アバター画像の画像追加／削除は「更新する」を押さなくても即時適用のため、
                </div>
                <div style="color:red;">
                    ご注意のうえ操作してください。
                </div>
            </p>
            @include('commons.upload', [
                'multiFlg' => 'OFF',
                'editFlg' => 'ON',
                'imageType' => 'avatar',
                'user' => $user,
                'divContainerStyle' => "style='margin-top: 80px;'"
            ])
        </div>
    </div>

    <h2 class="mt-5">ユーザ情報を編集する</h2>

    @include('commons.error_messages')
    <form method="POST" action="{{ route('user.update', $user->id) }}" onsubmit="saveUploadUIInfo(event)">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">名前</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}">
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email',$user->email) }}">
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード確認</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
        </div>
        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>

        {{-- トグル状態の復元のため、このform内のリクエストに前回値を乗せるためのhidden項目 --}}
        <input id="toggleOnOff" name="toggleOnOff" type="hidden" value="{{ $toggleOnOff }}">
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
                    <form action="{{ route('user.delete', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

@endsection
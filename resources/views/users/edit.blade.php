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

    <h2 class="mt-5">ユーザ情報を編集する</h2>

    {{-- スペーサーとしてのdivタグ--}}
    <div style="margin: 15px;"></div>

    <div style="margin-left: 65px;">
        <a href="#" id="avatarToggleLink">アバター画像の表示／追加／削除をする</a>
    </div>

    {{-- スペーサーとしてのdivタグ--}}
    <div style="margin: 15px;"></div>

    <script src="{{ asset('js/views/users/edit.js') }}"></script>

    {{-- 
        formタグの開始位置に関する説明
        画像追加／削除した分のDB反映を「更新する」ボタンのタイミングに変更のため

        非GETでリクエストにfileUuids、fileNamesおよび、fileUploadSubmitFlgをのせて
        バックエンド処理にfileUuids、fileNamesを参照したり、
        upload.blade.php側での「  old('fileUploadSubmitFlg')  」による前回値の有無判定での復元制御を意図通り
        行うためには、formタグの範囲を拡張し「 'commons.upload'を@includeしている箇所 」も範囲内に収める必要があった。

        画像追加／削除した分でリクエストに乗せるのは、ファイルの中身ではない。
        ファイルの中身はPOSTのajax通信でstorage保存まで完了させている。
            ( 一般的にファイルの中身をのせるときはPOSTでないと周辺部品が対応せず誤動作になる可能性があるとのこと )
        アップロード完了後、サムネイル画像を表示するなどのUI表示の変更をするが、
        その際にinput type="file"のタグは、disabledをtrueにしてファイルの中身が送信されないように対処している。
        あくまで、このformタグのsubmitでリクエストに乗せるのは、
        fileUuids、fileNamesについての文字列配列や、fileUploadSubmitFlgのフラグ値であるため、
        PUTの通信でも問題なく送信できることをご理解ください。

        上記の諸事情により、formタグの開始位置を検討していくと、レイアウト考慮でこの位置となった。
    --}}
    <form method="POST" action="{{ route('user.update', $user->id) }}" onsubmit="saveUploadUIInfo(event)">
        @csrf
        @method('PUT')

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
                {{-- スペーサーとしてのdivタグ--}}
                <div style="margin: 180px;"></div>

                @include('commons.upload', [
                    'multiFlg' => 'OFF',
                    'editFlg' => 'ON',
                    'imageType' => 'avatar',
                    'user' => $user,
                    'divContainerStyle' => "style='margin-top: 80px;'"
                ])
                <div style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px; color:red;">
                    アバター画像の変更は「更新する」で適用されます。
                </div>
            </div>
        </div>
        @include('commons.error_messages')
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
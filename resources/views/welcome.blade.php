{{-- トップページ --}}

{{-- app.blade.phpを継承 --}}
@extends('layouts.app')

{{-- 内容 --}}
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>

    {{-- 投稿する --}}
    <div class="text-center mb-3">
        <form method="" action="" class="d-inline-block w-75">
            <div class="form-group">
                <textarea class="form-control" name="" rows=""></textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>

    @if (Auth::check())
    <h2 class="mt-5 mb-3">ユーザ情報を編集する</h2>
    <form method="" action="">
        <input type="hidden" name="id" value="" />
        <div class="form-group">
            <label for="name">ユーザ名</label>
            <input class="form-control" value="" name="name" />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input class="form-control" value="" name="" />
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input class="form-control" type="password" name="" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワードの確認</label>
            <input class="form-control" type="password" name="" />
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
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
                    <form action="{{route('user.delete', Auth::id())}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    @else
    @endif
@endsection



@extends('layouts.app')
@section('content')
<div class="text-center">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
    </div>
    <div class="text-center mt-3">
        <p class="text-left d-inline-block">新規ユーザ登録すると投稿で<br>コミュニケーションができるようになります。</p>
    </div>
    <div class="text-center">
        <h3 class="login_title text-left d-inline-block mt-5">新規ユーザ登録</h3>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                @include('commons.error_messages')
                <div class="form-group">
                    <label for="name">名前</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">パスワード確認</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>
                <button type="submit" class="btn btn-primary mt-2">新規登録</button>
            </form>
        </div>
    </div>

    <div class="modal-footer d-flex justify-content-between">
            <button type="submit" class="btn btn-danger" data-target="#testModal">新規登録する</button>
        </form>
    </div>

    <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>確認</h4>
                </div>
                <div class="modal-body">
                    <label>ユーザー登録が完了しました</label>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
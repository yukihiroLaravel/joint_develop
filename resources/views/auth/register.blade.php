<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>ユーザ新規登録</title>
</head>
<body>

    {{-- ========================================
        暫定レイアウト開始
        共通レイアウト完成後は、このHTML外枠を削除し、
        @extends('layouts.app')
        @section('content')
        に置き換える
    ======================================== --}}

    <div class="container">

        {{-- ========================================
            登録画面本体開始
            共通レイアウトへ切り替えた後も残す範囲
        ======================================== --}}

        <div class="text-center">
            <h1>Topic Posts</h1>
        </div>

        <div class="text-center">
            <h3 class="login_title text-left d-inline-block mt-5">
                新規ユーザ登録
            </h3>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-sm-6 offset-sm-3">
                <form
                    method="POST"
                    action="{{ route('signup.post') }}"
                >
                    @csrf

                    <div class="form-group">
                        <label for="name">名前</label>

                        <input
                            id="name"
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name') }}"
                        >

                        @error('name')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            メールアドレス
                        </label>

                        <input
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                        >

                        @error('email')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            パスワード
                        </label>

                        <input
                            id="password"
                            type="password"
                            class="form-control"
                            name="password"
                        >

                        @error('password')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">
                            パスワード確認
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            class="form-control"
                            name="password_confirmation"
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary mt-2"
                    >
                        新規登録
                    </button>
                </form>
            </div>
        </div>

        {{-- ========================================
            登録画面本体終了
        ======================================== --}}

    </div>

    {{-- ========================================
        暫定レイアウト終了
        共通レイアウト完成後は、ここまでを削除し、
        @endsection
        に置き換える
    ======================================== --}}

</body>
</html>
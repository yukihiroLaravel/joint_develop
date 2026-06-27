@extends('layouts.app')
@section('content')
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
                @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
                @endif
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
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
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
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
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
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
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
@endsection
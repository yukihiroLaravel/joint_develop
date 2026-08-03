@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">管理者情報を変更</h1>

            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                管理者一覧へ戻る
            </a>
        </div>

        <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $admin->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $admin->email) }}"
                    class="form-control @error('email') is-invalid @enderror"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">新しいパスワード</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                >
                <small class="form-text text-muted">
                    変更しない場合は空欄のままにしてください。
                </small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">新しいパスワード（確認）</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                >
            </div>

            <button type="submit" class="btn btn-primary">
                変更を保存
            </button>
        </form>
    </div>
@endsection
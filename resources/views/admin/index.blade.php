@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h1>管理者画面</h1>
        <p>管理する項目を選んでください。</p>

        <div class="mt-4">
            <a href="{{ route('admin.users') }}" class="btn btn-primary mr-2">
                ユーザー管理
            </a>

            <a href="{{ route('admin.posts') }}" class="btn btn-primary">
                投稿管理
            </a>
        </div>
    </div>
@endsection
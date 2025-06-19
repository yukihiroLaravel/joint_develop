@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>{{ $user->name }} さんをフォローしているユーザー</h3>
    {{-- フォロー検索フォーム --}}
    <form method="GET" action="{{ route(Route::currentRouteName(), $user->id) }}" class="mb-4 w-75 mx-auto">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-search"></i> {{-- 虫眼鏡アイコン --}}
                </span>
            </div>
            <input type="text" name="search" class="form-control" placeholder="名前で検索" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">検索</button>
            </div>
        </div>
    </form>
    {{-- ユーザー一覧を表示 --}}
    @include('users.users', ['users' => $users])
</div>
@endsection
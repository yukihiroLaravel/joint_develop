@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザーアバター">
                    <div class="mt-3 text-center">
                        @if (Auth::id() === $user->id)
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        @endif
                        @include('follows.follow_button', ['id' => $user->id])
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{ route('users.show', $user->id) }}"
                        class="nav-link {{ Route::is('users.show') ? 'active' : '' }}">
                        <p>タイムライン</p>
                        <div class="badge badge-secondary">{{ $countPosts }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.follow', $user->id) }}"
                        class="nav-link {{ Route::is('users.follow') ? 'active' : '' }}">
                        <p>フォロー中</p>
                        <div class="badge badge-secondary">{{ $countFollowUsers }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.follower', $user->id) }}"
                        class="nav-link {{ Route::is('users.follower') ? 'active' : '' }}">
                        <p>フォロワー</p>
                        <div class="badge badge-secondary">{{ $countFollowerUsers }}</div>
                    </a>
                </li>
            </ul>
            {{-- 表示エリア --}}
            @if (Route::is('users.follow') || Route::is('users.follower'))
                @include('users.relevantUsers', ['user' => $user])
            @endif
            {{-- 表示エリア --}}
        </div>
    </div>
@endsection

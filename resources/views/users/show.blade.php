@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="">
                    <div class="mt-3">
                        <a href="ユーザー編集のルーター" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                    @include('follow.follow_button', ['user' => $user])
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                @php
                    $id = $user->id;
                    $showUrl = 'users/' . $id;
                @endphp
                <li class="nav-item">
                    <a href="{{ route('users.show', $id) }}" class="nav-link {{ Request::is($showUrl) ? 'active' : '' }}">
                        <p>タイムライン</p>
                        <div class="badge badge-secondary">{{ $countPosts }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.follow', $id) }}"
                        class="nav-link {{ Request::is($showUrl . '/follow') ? 'active' : '' }}">
                        <p>フォロー中</p>
                        <div class="badge badge-secondary">{{ $countFollowUsers }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.follower', $id) }}"
                        class="nav-link {{ Request::is($showUrl . '/follower') ? 'active' : '' }}">
                        <p>フォロワー</p>
                        <div class="badge badge-secondary">{{ $countFollowerUsers }}</div>
                    </a>
                </li>
            </ul>
            {{-- 表示エリア --}}
            <ul>
                @if (Request::is($showUrl))
                    @include('users.timeline', $user)
                @endif
                @if (Request::is($showUrl . '/follow'))
                    @include('users.follows', [
                        'user' => $user,
                        'followUsers' => $followUsers,
                    ])
                @endif
                @if (Request::is($showUrl . '/follower'))
                    @include('users.followers', [
                        'user' => $user,
                        'followerUsers' => $followerUsers,
                    ])
                @endif
            </ul>
            {{-- 表示エリア --}}
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card custom-bg-success">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                    @include('follow.follow_button', ['user' => $user])
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 350) }}" alt="ユーザのアバター画像">
                        @if (Auth::check())
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn custom-btn-warning btn-block">ユーザ情報の編集</a>
                        </div>
                        @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts ?? '' }}</div></a></li>
                <li class="nav-item"><a href="{{ route('timelineFollowing', $user->id) }}" class="nav-link {{ Request::routeIs('timelineFollowing') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowing ?? '' }}</div></a></li>
                <li class="nav-item"><a href="{{ route('timelineFollowers', $user->id) }}" class="nav-link {{ Request::routeIs('timelineFollowers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers ?? '' }}</div></a></li>
            </ul>
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>
@endsection

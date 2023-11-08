@extends('layouts.app')
@section('content')
@include('commons.success_messages')
<div class="row mt-3">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="ユーザのアバター画像">
                @if (Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="text-center">@include('follows.follow_button', ['user' => $user])</div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followings') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
        @if (isset($followers))
            @include('follows.followers', ["followers" => $followers])
        @elseif (isset($followings))
            @include('follows.followings', ["followings" => $followings])
        @else
            @include('posts.posts', ["user" => $user, "posts" => $posts])
        @endif
    </div>
</div>
@endsection
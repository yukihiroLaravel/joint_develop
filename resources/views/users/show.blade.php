@extends('layouts.app')

@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @auth
                    @if( Auth::user()->id == $user->id)
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @else
                        <br>
                        <br>
                        <div class="text-center mb-3">
                            @include('follower.follower_button', ['user' => $user])
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('user.following',['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id . 'following/') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="{{ route('user.followed',['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id . 'followed/') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
        @if (Request::route()->getName() === 'user.show')
            @include('posts.posts', ['posts' => $posts])
        @elseif(Request::route()->getName() === 'user.following')
            @include('users.following', ['users' => $followings])
        @elseif(Request::route()->getName() === 'user.followed')
            @include('users.followed', ['users' => $followers])
        @endif
    </div>
</div>
@endsection

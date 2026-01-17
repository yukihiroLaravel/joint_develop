@extends('layouts.app')
@section('content')
<div class="row">
    <div class="w-100 m-auto">
        @include('commons.flash_messages')
    </div>
    
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{$user->name}}</h3>
                </div>
                <div class="card-body">
                     @include('follow.follow_button', ['user' => $user])
                    <div class="mt-3">
                        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="">
                    </div>
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">
                        タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.followings', $user->id) }}" class="nav-link {{ Request::is('users/*/followings') ? 'active' : '' }}">
                        フォロー中<br><div class="badge badge-secondary">{{ $countFollowings }}</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.followers', $user->id) }}" class="nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}">
                        フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div>
                    </a>
                </li>
                @if (Auth::id() == $user->id)
                    <li class="nav-item">
                        <a href="{{ route('users.favorites', $user->id) }}" class="nav-link {{ Request::is('users/*/favorites') ? 'active' : '' }}">
                            いいね！<br><div class="badge badge-secondary">{{ $countFavorites }}</div>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="mt-2">
                @if (Request::is('users/' . $user->id)|| Request::is('users/*/favorites'))
                    @include('posts.posts', ['posts' => $posts])
                @else
                    @include('users.users', ['users' => $users])
                @endif
            </div>
        </div>
</div>
@endsection

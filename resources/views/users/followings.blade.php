@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                @if (isset($user) && $user->profile_image)
                    <img class="rounded-circle img-fluid" src="{{ asset('storage/images/' . $user->profile_image) }}" alt="ユーザーのプロフィール画像">
                @else
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @endif                                 
                @if (Auth::check() && Auth::user()->id == $user->id)
                <div class="mt-3">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @endif
            </div>
                @include('follows.follow_button')
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div></a></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowings }}</div></a></li>
            <li class="nav-item"><a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
        </ul>
        @include('users.showFollowings', ['user' => $user, 'followings' => $followings])
    </div>
</div>
@endsection
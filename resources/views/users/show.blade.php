@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="{{ $user->name }}">
                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        @include('followers.follow_button')
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('users.followings', $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followings') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('users.followers', $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followers') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
        @if ($tab == 'timeline')
            @include('posts.posts', ['posts' => $posts])
        @elseif ($tab == 'followings')
            @include('followers.followings', [
            'followings' => $followings,
            'emptyMessage' => 'フォロー中のユーザーはいません。'
            ])
        @elseif ($tab == 'followers')
            @include('followers.followers', [
            'followers' => $followers,
            'emptyMessage' => 'フォロワーはいません。'
            ])
        @endif
        </div>
</div>
@endsection

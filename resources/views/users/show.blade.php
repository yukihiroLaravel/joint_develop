@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            @include('layouts.user_profile', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン</a>
                <div class="badge badge-secondary">{{ $counts['countPosts'] }}</div></li>
                <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">フォロー中</a>
                <div class="badge badge-secondary">{{ $counts['countFollowings'] }}</div></li>
                <li class="nav-item"><a href="{{ route('followers', $user->id) }}"  class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">フォロワー</a>
                <div class="badge badge-secondary">{{ $counts['countFollowers'] }}</div></li>
            </ul>
            <!-- ここからタイムライン投稿一覧部分追加 -->
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>
@endsection

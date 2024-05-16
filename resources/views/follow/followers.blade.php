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
        <ul class="list-unstyled">
            @foreach($followers as $follower)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 50) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a></p>
                    </div>
                </li>   
            @endforeach 
        </ul>
        <div class="m-auto" style="width: fit-content">{{ $followers->links('pagination::bootstrap-4') }}</div>
    </div>
</div>    
@endsection

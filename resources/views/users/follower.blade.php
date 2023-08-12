@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info mb-3">
                <div class="card-header">
                    <h3 class="card-title text-light">{{$user->name}}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 777) }}" alt="ユーザのアバター画像">
                        <div class="mt-3">
                            @if (Auth::id() === $user->id )
                            <a href="{{ route('user.edit', Auth::user()->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                            @endif
                        </div>
                </div>
            </div>
            @include('users.follow_follower_count')
        </aside>
    
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id) ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id. '/follows') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollows }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
            </ul>

            <ul class="list-unstyled">
                @foreach ($followers as $follower)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a></p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
</div>
@endsection
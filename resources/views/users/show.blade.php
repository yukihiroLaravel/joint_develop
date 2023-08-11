@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
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
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id) ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id. '/follows') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollows }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Request::is('user/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
            </ul>
            @include('posts.posts')
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')
@if (session('greenMessage'))
    <div class="alert alert-success alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('greenMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('redMessage'))
    <div class="alert alert-danger alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('redMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
@endif
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}"
                        alt="{{ $user->name }}アバター画像">
                    @if ($user->id === Auth::id() )
                        <div class="mt-3">
                            <a href="{{ route('edit',Auth::id()) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @else
                    @endif
                </div>
            </div>
            @include('follow.follow_button')
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}"
                        class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div></a>
                </li>
                <li class="nav-item"><a href="{{ route('user.followingList', $user->id)}}" 
                        class="nav-link {{ Request::is('users/'. $user->id. '/followingList') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowings }}</div></a>
                </li>
                <li class="nav-item"><a href="{{ route('user.followedList', $user->id)}}"
                        class="nav-link  {{ Request::is('users/'. $user->id. '/followedList') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a>
                </li>
            </ul>
            <ul class="list-unstyled">
            @if (Request::is('users/'. $user->id))
                @include('posts.posts')
            @elseif (Request::is('users/'. $user->id. '/followingList'))
                @include('follow.following_list')
            @elseif (Request::is('users/'. $user->id. '/followedList'))
                @include('follow.followed_list')
            @else
                @include('posts.posts')
            @endif
            </ul>
        </div>
    </div>
@endsection

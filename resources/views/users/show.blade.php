@extends('layouts.app')
@section('content')
    {{-- フラッシュメッセージ表示 --}}
    @include('commons.flash_message')

    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{$user->name}}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザーのアバター画像">
                    @if(Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{route('user.edit' , $user->id)}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                    <div class="text-center mt-3">@include('follow.follow_button')</div>
                </div>
                <div class="text-right">
                    <span class="badge badge-pill badge-success">獲得いいね！：{{ $totalFavorites }}</span>
                </div>
            </div>


        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{route('user.show',$user->id)}}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">
                        タイムライン <div class="badge badge-secondary">{{ $countPosts }}</div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('user.favorites',$user->id)}}" class="nav-link {{ Request::routeIs('user.favorites') ? 'active' : '' }}">
                        お気に入り <div class="badge badge-secondary">{{ $countFavorites }}</div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('user.followings',$user->id)}}" class="nav-link {{ Request::routeIs('user.followings') ? 'active' : '' }}">
                        フォロー中
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.followers',$user->id)}}" class="nav-link {{ Request::routeIs('user.followers') ? 'active' : '' }}">
                        フォロワー
                    </a>
                </li>
            </ul>

            {{-- なぜ必要？ --}}
            @if(isset($followers))
                @include('follow.followers' , [ 'followers' => $followers])
            @elseif(isset($followings))
                @include('follow.followings' , ['followings' => $followings])
            {{-- @elseif(isset($favorites))
                @include('users.favorites' , ['favorites' => $favorites]) --}}
            @else
                @include('posts.index' , ['user' => $user, 'posts' => $posts])
            @endif
        </div>
    </div>
@endsection

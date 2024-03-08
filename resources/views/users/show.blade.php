@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src( $user->email , 400 ) }}" alt="ユーザのアバター画像">
                    <div class="mt-3">
                        <a href="{{ route('users.edit' , $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    {{-- <a href="{{ $user->id }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"> タイムライン</a> --}}
                    <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"> タイムライン</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.followingUsers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followingUsers') ? 'active' : '' }}">フォロー</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー</a>
                </li>
            </ul>

            {{-- タイムラインが表示される場合 --}}
            @if(Request::is('users/'. $user->id))
                @include('posts', ['posts' => $posts])
            @endif

            <!-- フォローが表示される場合 -->
            @if(Request::is('users/'. $user->id. '/followingUsers'))
            <ul class="list-unstyled">
                @foreach ($followings as $following)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-flex w-75 mb-2 align-items-center justify-content-between">
                        <div>
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
                            <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $following->name }}</a></p>
                        </div>
                        <!-- フォローボタン -->
                        <div>
                            @include('follow.follow', ['following' => $following])
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif

            <!-- フォロワーが表示される場合 -->
            @if(Request::is('users/'. $user->id. '/followers'))
            <ul class="list-unstyled">
                @foreach ($followers as $follower)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-flex w-75 mb-2 align-items-center justify-content-between">
                        <div>
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
                            <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $follower->name }}</a></p>
                        </div>
                    <!-- フォローボタン -->
                        <div>
                            @include('follow.follow', ['follower' => $follower])
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
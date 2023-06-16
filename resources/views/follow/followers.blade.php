@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{$user->name}}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザの画像">
                <div class="mt-3">
                    <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @include('users.follow_button', ['followUser'=>$user])
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン<br>
                    <div class="badge badge-secondary">{{ $countPosts }}</div>
                </a></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id.'/followings') ? 'active' : '' }}">フォロー中<br>
                    <div class="badge badge-secondary">{{ $countFollowings }}</div>
                </a></li>
            <li class="nav-item"><a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id.'/followers') ? 'active' : '' }}">フォロワー<br>
                    <div class="badge badge-secondary">{{ $countFollowers }}</div>
                </a></li>
        </ul>
        <ul class="list-unstyled">
            @foreach ($followers as $follower)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$follower->id) }}">{{$follower->name}}</a></p>
                    @if (Auth::check() && Auth::id() !== $follower->id)
                        @if (Auth::user()->isFollow($follower->id))
                            <form method="POST" action="{{ route('unFollow', $follower->id) }}" class="d-inline-block ml-4">
                                @csrf
                                @method('DELETE')
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-danger">フォロ―を外す</button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $follower->id) }}" class="d-inline-block ml-4">
                                @csrf
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">フォロ―する</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light" style="color:white">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザのアバター画像">
                @if(Auth::check() && Auth::id() == $user->id)
                <div class="mt-3">
                    <a href="{{ route('user.edit',$user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @endif
            </div>
        </div>
        @include('follows.follows_button', ['user'=>$user])
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('user.followings', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followings') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowings ??'' }}</div></a></li>
            <li class="nav-item"><a href="{{ route('user.followUsers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followUsers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowUsers ??'' }}</div></a></li>
        </ul>
        @include('follows.follows', ['followings' => $followings])
    </div>
</div>
@endsection

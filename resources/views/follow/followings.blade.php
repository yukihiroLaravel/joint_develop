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
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id.'/followings') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
        <ul class="list-unstyled">
            @foreach ($followings as $follow)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follow->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$follow->id) }}">{{$follow->name}}</a></p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
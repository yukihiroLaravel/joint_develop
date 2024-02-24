@extends('layouts.app')
@section('content')
<div class="container">
    <div class="low">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $email ?? '' , 55 ) }}" alt="ユーザのアバター画像">
                </div>
                <div class="card-body">
                    <div class="mt-3">
                        <a href="{{ route('users.edit') }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">
                <a href="{{ $user->id }}" class="nav-link {{ Request::is('users/', $user->id) ? 'active' : '' }}"> タイムライン</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
        <ul class="list-unstyled">
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $email ?? '' , 55 ) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.edit, $post->user_id') }}" >{{ $post->user->name }}</a></p>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
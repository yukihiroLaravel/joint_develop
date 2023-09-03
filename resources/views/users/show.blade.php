@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light"></h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="" alt="">
                        <div class="mt-3">
                            <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                </div>
            </div>
        </aside>
    <h1>{{ $user->name }}</h1>
    <div class="col-sm-8">
    <ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('user.show', $user->id) }}">投稿<br><div class="badge badge-secondary">{{ $countPosts }}</div></a></li>
        <li class="nav-item nav-link><a href="">お気に入り<br><div class="badge badge-secondary"></div></a></li>
    </ul>
    </div>
    @include('posts.posts', ['user' => $user, 'posts' => $posts])
@endsection
@extends('layouts.app')
@section('content')
    <h1>{{ $user->name }}</h1>
    <ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">
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
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
            </ul>
        </div>
    </div>
    @include('posts.posts', ['posts' => $posts]) 
@endsection
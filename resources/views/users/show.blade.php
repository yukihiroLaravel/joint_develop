@extends('layouts.app')
@section('content')
    <h1> </h1>
    <ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザのアバター画像">
                        <div class="mt-3">
                            
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
            @include('posts.posts', ['posts' => $posts]) 
        </div>
    </div>
    
@endsection
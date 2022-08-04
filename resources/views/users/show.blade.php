@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="" alt="">
                        <div class="mt-3">
                            
                            @auth
                                <a class="nav-link" href=""><i class="mr-1"></i>ユーザ情報の編集</a></li>
                            @endauth
    
                            @guest 
                                <li class="nav-item">
                                <a class="nav-link" href=""></a></li>
                            @endguest 
                        </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="" class="nav-link {{ Request::is() ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
            </ul>
                    @include('posts.post', ['posts' => $posts])
        </div>
    </div>
    
@endsection
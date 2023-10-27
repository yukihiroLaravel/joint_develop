@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
              <div class="card-header">
                <h3 class="card-title  text-light">{{ $user->name }}</h3>
              </div>
               <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="ユーザのアバター画像">
                    @if(Auth::id() === $user->id)
                    <div class="mt-3">
                       <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a> 
                    </div>
                    @endif
               </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="#" class="nav-link {{ Request::routeIs('user.show') ? 'side-active' : '' }} ">タイムライン</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
        @include('posts.posts', ['posts' => $posts])
    </div>
</div>
@endsection

    
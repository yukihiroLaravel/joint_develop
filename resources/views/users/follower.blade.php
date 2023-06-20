@extends('layouts.app')
@section('content')
     <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
             <div class="card-header d-inline-block">
               <h3 class="card-title text-light">{{ $user->name }}
                @include('follow.follow_button',['user'=> $user])
               </h3>
                
             </div>
             <div class="card-body">
               <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザーアバター画像">
                @if(Auth::id() === $user->id)
                 <div class="mt-3">
                  <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                 </div>
                @endif
             </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('user.following', $user->id) }}" class="nav-link {{ Request::routeIs('user.following') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('user.follower', $user->id) }}" class="nav-link {{ Request::routeIs('user.follower') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            @include('follow.follower_list', ['follower' => $followers])
        </div>
     </div>
@endsection
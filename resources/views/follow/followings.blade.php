@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
              <div class="card-header d-flex justify-content-between">
                <h3 class="card-title  text-light">{{ $user->name }}</h3>
              </div>
               <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="ユーザのアバター画像">
                    @if(Auth::id() === $user->id)
                        <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a> 
                        </div>
                    @else
                        @if(Auth::check())
                            @if (Auth::user()->isFollows($user->id))
                                <form method="POST" action="{{ route('unfollow', $user->id) }}" class="text-center mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('follow', $user->id) }}" class="text-center mt-4">
                                    @csrf
                                    <button type="submit" class="btn btn-success">フォロー</button>
                                </form>
                            @endif
                        @endif
                @endif
               </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}"  class="nav-link {{ Request::routeIs('user.show') ? 'side-active' : '' }} ">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('users/'. $user->id. '/followings') ? 'active' : '' }}">フォロー中</a></li>                                                                         
            <li class="nav-item"><a href="{{ route('followers', $user->id) }}"  class="nav-link {{ Request::routeIs('users/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
        @foreach($followings as $following)
          <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $following->name }}</a></p>
            </div>
        </li>   
    @endforeach 
    </div>
</div>    
</ul>    
@endsection
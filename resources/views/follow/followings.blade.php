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
                            <a href="{{ route('posts.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a> 
                        </div>
                    @elseif(Auth::check())
                            @if (Auth::user()->isFollowing($user->id))
                                <form method="POST" action="{{ route('unfollow.destroy', $user->id) }}" class="text-center mt-4">
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
                </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン</a>
            <div class="badge badge-secondary">{{ $counts['countPosts'] }}</div></li>
            <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">フォロー中</a>
            <div class="badge badge-secondary">{{ $counts['countFollowings'] }}</div></li>
            <li class="nav-item"><a href="{{ route('followers', $user->id) }}"  class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">フォロワー</a>
            <div class="badge badge-secondary">{{ $counts['countFollowers'] }}</div></li>
        </ul>
        <div class="list-unstyled">
            @foreach($followings as $following)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 50) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a></p>
                    </div>
                </li>   
            @endforeach
        </div> 
        <div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>
    </div>
</div>    
@endsection
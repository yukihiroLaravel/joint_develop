@extends('layouts.layout')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="">
                @if(Auth::check())
                    @if (Auth::id() === $user->id)
                            <div class="mt-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                            </div>
                    @elseif (Auth::user()->followCheck($user->id))
                        <div class="mt-3">
                            <form method="POST" action="{{ route('unfollow', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block">フォローを解除する</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('follow', $user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">フォローする</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('users.following', $user->id) }}" class="nav-link">フォロー中</a></li>
            <li class="nav-item"><a href="{{ route('users.followed', $user->id) }}" class="nav-link">フォロワー</a></li>
        </ul>
        <ul class="list-unstyled">
            @foreach($user->posts()->get() as $post)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>
                    </div>
                    <div class="">
                        <div class="text-left d-inline-block w-75">
                            <p class="mb-2">{{ $post->content }}</p>
                            <p class="text-muted">{{ $post->created_at }}</p>
                        </div>
                        @if (Auth::id() === $user->id)
                            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                                <form method="" action="">
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                                <a href="" class="btn btn-primary">編集する</a>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="m-auto" style="width: fit-content"></div>
    </div>
</div>
@endsection 
@extends('layouts.layout')
@section('content')
@include('layouts.flash')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-success">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="">
                @if(Auth::check())
                    @if (Auth::id() === $user->id)
                            <div class="mt-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary btn-block">ゴルファー情報の編集</a>
                            </div>
                    @elseif (Auth::user()->followCheck($user->id))
                        <div class="mt-3">
                            <form method="POST" action="{{ route('unfollow', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-block">フォローを解除する</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('follow', $user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-block">フォローする</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('users.following', $user->id) }}" class="nav-link {{ Request::routeIs('users.following') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="{{ route('users.followed', $user->id) }}" class="nav-link {{ Request::routeIs('users.followed') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
        @yield('tab')
    </div>
</div>
@endsection
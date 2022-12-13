@extends('layouts.app')
@section('content')
    @if (session('deleteMessage'))
        <div class="alert alert-success text-center">
            {{ session('deleteMessage') }}
        </div>
    @endif
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザの画像">
                    @if (Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                    @include('users.follow_button', ['user' => $user])
                </div>
            </div>
        </aside>

        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('user.show', $user->id) }}">タイムライン<br></a></li>
                <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('followings', $user->id) }}">フォロー中<br>
                        <div class="badge badge-secondary">{{ $countFollowings }}</div>
                    </a></li>
                <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('followers', $user->id) }}">フォロワー<br>
                        <div class="badge badge-secondary">{{ $countFollowers }}</div>
                    </a></li>
            </ul>
            @yield('data')
        </div>
    </div>
@endsection
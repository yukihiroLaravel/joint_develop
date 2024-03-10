@extends('layouts.app')

@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                {{--<img class="rounded-circle img-fluid" src="{{ asset($user->profile_image) }}" alt="User Profile Image">--}}
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                <div class="mt-3">
                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @auth
                  @if( Auth::user()->id == $user->id)
                  @else
                    <br>
                    <div class="text-center mb-3">
                      @include('follower.follower_button', ['user' => $user])
                    </div>
                  @endif
                @endauth
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a href="{{ route('user.show', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ url('/following') }}" class="nav-link {{ Request::is('following') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="{{ url('/followers') }}" class="nav-link {{ Request::is('followers') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
        @include('posts.posts', ['posts' => $posts])
    </div>
</div>
@endsection

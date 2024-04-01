@extends('layouts.app')

@section('content')
<div class="row">

{{-- 
        <!-- @php
            $posts = $user->posts()->get();
            $totalFavorites = 0;
            foreach ($posts as $post){
                $totalFavorites += $post->favoriteUsers()->count();
            }
        @endphp -->
--}}

    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">

            {{--
                <!-- <div class="text-right">
                    <span class="badge badge-pill badge-success">{{ $totalFavorites }} いいね♡</span>
                </div> -->
            --}}
            
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                {{--<img class="rounded-circle img-fluid" src="{{ asset($user->profile_image) }}" alt="User Profile Image">--}}
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @auth
                    @if( Auth::user()->id == $user->id)
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @else
                        <br>
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
            <!-- <li class="nav-item"><a href="{{ url('/favorites') }}" class="nav-link {{ Request::is('favorites') ? 'active' : '' }}">いいね</a></li> -->
            <li class="nav-item nav-link {{ Request::is('users/'. $user->id. '/favorites') ? 'active' : '' }}"><a href="{{ route('user.favorites', $user->id) }}">いいね<br><div class="badge badge-secondary">{{ $countFavorites }}</div></a></li>
        </ul>
        </ul>
        @include('posts.posts', ['posts' => $posts])
    </div>
</div>
@endsection

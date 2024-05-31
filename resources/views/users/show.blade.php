@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
                @if (Auth::check() && Auth::id() !== $user->id)
                    @include('follow.follow_button', ['user' => $user])
                @endif
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src( $user->email , 400) }}" alt="ユーザのアバター画像">
                @if (Auth::check() && Auth::id() === $user->id)
                <div class="mt-3">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('user.show', $user->id) }}">タイムライン</a></li>
            <li class="nav-item nav-link {{ Request::is('users/'. $user->id.'/followings') ? 'active' : '' }}"><a href="{{ route('followings', $user->id) }}">フォロー<br><div class="badge badge-secondary">{{ $countFollows }}</div></a></li>
            <li class="nav-item nav-link {{ Request::is('users/'. $user->id.'/followers') ? 'active' : '' }}"><a href="{{ route('followers', $user->id) }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
        </ul>
        <!-- ここから投稿表示部分追加 -->
        @if(isset($follows))
            <ul class="list-unstyled">
                @foreach($follows as $follow)
                    <li class="mt-5 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $follow->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $follow->id) }}">{{ $follow->name }}</a></p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="m-auto" style="width: fit-content">
                {{ $follows->links('pagination::bootstrap-4') }}
            </div>
        @elseif(isset($followers))
            <ul class="list-unstyled">
                @foreach($followers as $follower)
                    <li class="mt-5 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $follower->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a></p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="m-auto" style="width: fit-content">
                {{ $followers->links('pagination::bootstrap-4') }}
            </div>
        @else
            <ul class="list-unstyled">
                @foreach ($posts as $post)
                    @include('posts.post', ['user' => $user, 'post' => $post])
                    @include('favorite.favorite_button', ['post' => $post])
                    @include('comments.comment', ['post' => $post])
                    <hr>
                @endforeach
            </ul>
            <div class="m-auto" style="width: fit-content">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        @endif
       
    </div>
</div>
@include('commons.flash_message')
@endsection

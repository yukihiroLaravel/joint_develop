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
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class=" nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item nav-link {{ Request::is('users/'. $user->id.'followings') ? 'active' : '' }}"><a href="{{ route('followings', $user->id) }}">フォロー<br><div class="badge badge-secondary">{{ $countFollows }}</div></a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
        <!-- ここから投稿表示部分追加 -->
        <ul class="list-unstyled">
            @foreach ($posts as $post)
                @include('posts.post', ['user' => $user, 'post' => $post])
                @include('favorite.favorite_button', ['post' => $post])
                <hr>
            @endforeach
        </ul>
        <div class="m-auto" style="width: fit-content">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@include('commons.flash_message')
@endsection

@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card')
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab', [
        'countPosts' => $user->posts->count(),
        'countFollowings' => $user->followings()->count(),
        'countFollowers' => $user->followers()->count(),
        'countFavorites' => $user->favorites()->count(),
    ])
        @include('posts.posts', ['posts' => $posts, 'user' => $user])
    </div>
</div>
@endsection
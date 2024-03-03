@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fa-brands fa-x-twitter pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if (Auth::check())
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <ul class="show_category_list list-unstyled">
        <li class="category_btn posts_btn" id="posts">投稿</li>
        <li class="category_btn users_btn" id="users">ユーザー</li>
        @if (Auth::check())
            <li>フォロー中</li>
            <li>いいね一覧</li>
        @endif
    </ul>
    @php
        if (isset($searchWords)) {
            $data = [
                'posts' => $posts,
                'users' => $users,
                'searchWords' => $searchWords,
                'arraySearchWords' => $arraySearchWords,
            ];
        } else {
            $data = [
                'posts' => $posts,
                'users' => $users,
            ];
        }
    @endphp
    <div class="category_container posts_container active">
        @include('posts.posts', $data)
    </div>
    <div class="category_container users_container">
        @include('users.users', $data)
    </div>
@endsection

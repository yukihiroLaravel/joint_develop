@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-w-16 fa-lg pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"趣味や仕事"について140字以内で会話しよう！"</h5>
@if(Auth::check())
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4"></textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif

    <!-- 検索フォームを追加 -->
    <br>
    <form action="{{ route('posts.search') }}" method="GET" class="mb-3 d-flex justify-content-center">
        <div class="form-group d-flex">
            <input type="text" name="search" placeholder="投稿を検索" class="form-control" style="flex: 3; min-width: 350px;">
            <button type="submit" class="btn btn-primary ml-2">検索</button>
        </div>
    </form>

    <!-- 投稿一覧を表示するコンテンツを追加 -->
    <div class="post-list">
        @include('posts', ['$posts' => $posts])
    </div>
@endsection
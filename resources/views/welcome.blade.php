@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-w-16 fa-lg pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"趣味や仕事"について140字以内で会話しよう！</h5>
@guest
    @if (session('successMessage'))
        <div class="alert alert-info mb-3 text-center">
        {{ session('successMessage') }} <!-- ログアウト -->
        </div> 
    @endif
    @if (session('destroyMessage'))
        <div class="alert alert-danger mb-3 text-center">
        {{ session('destroyMessage') }} <!-- 退会処理 -->
        </div> 
    @endif
@endguest
@if(Auth::check())
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        @if (session('updateSuccessMessage'))
            <div class="alert alert-primary mb-3 text-center">
            {{ session('updateSuccessMessage') }} <!-- 新規登録、ユーザー情報変更、投稿内容変更 -->
            </div> 
        @endif
        @if (session('successMessage'))
            <div class="alert alert-info mb-3 text-center">
            {{ session('successMessage') }} <!-- ログイン、投稿 -->
            </div> 
        @endif
        @if (session('deleteMessage'))
            <div class="alert alert-warning mb-3 text-center">
            {{ session('deleteMessage') }} <!-- 投稿削除 -->
            </div> 
        @endif
        @if (session('followedMessage'))
            <div class="rounded border border-success p-2 mb-3 bg-success text-white text-center">
            {{ session('followedMessage') }} <!-- フォローする -->
            </div> 
        @endif
        @if (session('unfollowMessage'))
            <div class="rounded border border-danger p-2 mb-3 text-danger text-center">
            {{ session('unfollowMessage') }} <!-- フォロー解除 -->
            </div> 
        @endif
        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4"></textarea>
                <div class="pt-3">
                    <input type="file" name="image">
                </div>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-info">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif

<!-- 検索フォームを追加 -->
<br>
<form action="{{ route('posts.search') }}" method="GET" class="mb-3 d-flex justify-content-center">
    <div class="form-group d-flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="投稿を検索" class="form-control" style="flex: 3; min-width: 350px;">
        <button type="submit" class="btn btn-primary ml-2">検索</button>
    </div>
</form>

<!-- 投稿一覧を表示するコンテンツを追加 -->
<div class="post-list">
    @include('posts', ['posts' => $posts])
</div>
@endsection

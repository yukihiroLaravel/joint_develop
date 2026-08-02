@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
@if (Auth::check())
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
<div class="w-75 m-auto">@include('commons.error_messages')</div>
<div class="text-center mb-3">
    <form method="post" action="{{ route('posts.store') }}" class="d-inline-block w-75 text-left" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="5">{{ old('content') }}</textarea>
        </div>
        <!-- 画像アップロード -->
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block"><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>

        </div>
        <div class="text-left mt-3">
            <button type="submit" class="btn btn-primary">投稿する</button>
        </div>
    </form>
</div>
@endif
<div class="text-center">
    <form action="{{ route('posts') }}" method="GET">
        <input type="text" name="keyword" value="{{ $keyword ?? '' }}">
        <input type="submit" value="検索">
    </form>
</div>
<!-- 投稿一覧 -->
@include('posts.posts', ['posts' => $posts ])
@endsection

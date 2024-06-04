@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
<div class="w-75 m-auto">
    @include('commons.error_messages')
</div>
@if (Auth::check())
<div class="text-center mb-3">
    <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data">
        <div class="text-left mt-2">
            <label for="tag">タグ：</label>
            <select name="tag" id="tag">
                <option value="{{null}}">未選択</option>
                @foreach ($tags as $tag)
                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
        </div>
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="4"></textarea>
            <div class="text-left mt-3">
            <div>
                <label for="image">画像を追加:</label>
                <input type="file" name="image" id="image">
            </div>
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </div>
    </form>
</div>
@endif
<!-- ここから投稿表示部分追加 -->
<ul class="list-unstyled">
    @foreach ($posts as $post)
        @include('posts.post', ['post' => $post])
        @if ($post->image_path)
            <style>
                .image-container {
                    width: 600px;
                    height: 400px;
                    overflow: hidden;
                    position: relative;
                }
                .image-container img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }
            </style>
            <div class="image-container">
                <img src="{{ asset($post->image_path) }}" alt="Example Image">
            </div>
        @endif
        @include('favorite.favorite_button', ['post' => $post])
        @include('comments.comment', ['post' => $post])
        <hr>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
@include('commons.flash_message')
@endsection

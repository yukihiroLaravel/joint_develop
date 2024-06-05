@extends('layouts.app')
@section('content')
<style>
    .carousel-item {
        height: 100%;
    }
    .carousel-item img {
        width: 100%;
        height: 250px;
        background-size: 100% 100%;
        filter: brightness(90%);
    }
    .title, .title2, .title3 {
        text-align: center;
        position: absolute;
        top: -90%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 45px;
        font-weight: bold;
        letter-spacing: 1px;
        white-space: nowrap;
        overflow: hidden;
    }
    .title {
        color: yellow;
    }
    .title2 {
        color: red;
    }
    .title3 {
        color: orange;
    }
    @media (max-width: 768px) {
        .title, .title2, .title3 {
            font-size: 30px;
        }
        .theme1 {
            font-size: 15px;
        }
    }
    .animated-text {
        display: inline-block;
        font-size: 24px;
        color: blue;
        padding: 10px;
        animation: invertColors 10s infinite;
        }
        @keyframes invertColors {
        0% {
            color: black;
        }
        20% {
            color: black;
        }
        60% {
            background-color: yellow;
            color: red;
        }
        80% {
            background-color: yellow;
            color: blue;
        }
        100% {
            background-color: yellow;
            color: blue;
        }
    }
</style>

<div class="center">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/matsuya.jpg') }}" class="d-block w-100" alt="Image 1">
                <div class="carousel-caption d-block">
                    <h1 class="title"><i class="fas fa-utensils fa-lg pr-3"></i>Don-Don Talks!</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/sukiya.jpg') }}" class="d-block w-100" alt="Image 2">
                <div class="carousel-caption d-block">
                    <h1 class="title2"><i class="fas fa-utensils fa-lg pr-3"></i>Don-Don Talks!</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/yoshinoya.jpg') }}" class="d-block w-100" alt="Image 3">
                <div class="carousel-caption d-block">
                    <h1 class="title3"><i class="fas fa-utensils fa-lg pr-3"></i>Don-Don Talks!</h1>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<h5 class="theme1 text-center mb-2 mt-3">
    <span class="animated-text" style="font-weight: bold; font-size: 24px;">"身近な丼物屋"</span>について<br>140字以内で会話しよう！
</h5>
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

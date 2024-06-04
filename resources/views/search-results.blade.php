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
<h4 class="text-center mb-3" style="background-color: yellow;">検索結果</h4>

@if(isset($message))
    <!-- ブレイドファイルの中で文字を流れるように表示 -->
    <div class="flowing-text-container">
        <div class="flowing-text">
            <p>{{ $message }}</p>
        </div>
    </div>

    <style>
        @keyframes flowing {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .flowing-text {
            white-space: nowrap; /* テキストが改行されないようにする */
            animation: flowing 25s linear infinite; /* アニメーションを追加 */
        }
    </style>
@else
    <!-- 検索結果がある場合の表示 -->
    <div style="text-align: right;">
        投稿記事 {{ $totalPosts }} 件
    </div>

    <ul class="list-unstyled">
        @foreach ($posts as $post)
            @include('posts.post', ['post' => $post])
        @endforeach
    </ul>

    <div class="m-auto" style="width: fit-content">
        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endif

<div style="text-align: right;">
    <a href="{{ route('home') }}" class="btn btn-primary">ホームに戻る</a>
</div>
@endsection

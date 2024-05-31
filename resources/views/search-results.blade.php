@extends('layouts.app')
@section('content')

<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
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

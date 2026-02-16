@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <div class="w-75 m-auto">エラーメッセージが入る場所</div>
        <div class="text-center mb-3">
            <form method="" action="" class="d-inline-block w-75">
                <div class="form-group">
                    <textarea class="form-control" name="" rows=""></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>

    <h5 class="text-center mb-3">＜投稿一覧＞</h5>

    @if($posts->isEmpty())
        <p>投稿はありません。</p>
    @else
        <ul class="list-unstyled">
            @foreach($posts as $post)
                <li class="mb-3 text-center">
                    
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $post->user->name }}</a></p>
                    <p class="mt-3 mb-0 d-inline-block">
                    <small>　投稿日：
                        @if($post->created_at)
                            {{ $post->created_at->format('Y/m/d H:i:s') }}
                        @else
                            日付未設定
                        @endif
                    </small>
                    </p>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $post->title }}</p>
                        <p class="text-muted">{{ $post->content }}</p>
                    </div>
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                </div>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
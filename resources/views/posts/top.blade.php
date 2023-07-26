@extends('layouts.layout')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
@if (Auth::check())
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
@endif
<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ App\User::find($post->user_id)->name }}</a></p>
            </div>
            <div class=""> 
                
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->updated_at }}</p>
                </div>
                <!-- <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="" action="">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="" class="btn btn-primary">編集する</a>
                </div> -->
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>
@endsection
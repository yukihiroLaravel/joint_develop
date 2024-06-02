@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
<div class="text-center mb-3">
    <form method="" action="" class="d-inline-block w-75">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="5"></textarea>
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </div>
    </form>
</div>
<!-- 投稿時のフラッシュメッセージ -->
@if (session('redMessage'))
<div class="alert alert-danger text-center mx-auto w-75 mb-3">
    {{ session('redMessage') }}
</div>
@elseif (session('greenMessage'))
<div class="alert alert-success text-center mx-auto w-75 mb-3">
    {{ session('greenMessage') }}
</div>
@endif
@include('posts.posts', ['posts => $posts'])
@endsection
@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>ザ・ベストテン</h1>
    </div>
</div>
<h5 class="text-center mb-3">"懐メロ"について140字以内で会話しよう！</h5>
<div class="text-center mb-3">
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    @if (Auth::check())
    <!-- <div class="w-75 m-auto">エラーメッセージが入る場所</div> -->
    <div class="text-center mb-3">
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
</div>
@endif
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
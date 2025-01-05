@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fa-brands fa-telegram pr-3 d-inline"></i>Tune Talk</h1>
        <h3><i class="fa-brands fa-telegram pr-3 d-inline"></i>皆で音楽について語りましょう♫</h3>
    </div>
</div>
<h5 class="text-center mb-3">音楽について140字以内で会話しよう！</h5>
@if(Auth::check())
<div class="w-75 m-auto">
    @include('commons.error_messages')
</div>
<div class="text-center mb-3">
    <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="d-inline-block w-75">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary">投稿する</button>
                <input class="ml-3" type="file" name="image">
            </div>
        </div>
    </form>
</div>
@endif
@include('posts.index',['search' => $search])
<div class="mt-4">
    @include('posts.posts', ['posts' => $posts])
</div>
@endsection
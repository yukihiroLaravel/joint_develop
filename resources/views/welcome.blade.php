@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>旅・旅行 Topic Posts</h1>
    </div>
</div>
<h3 class="text-center mb-3">旅行の思い出や計画を140字でシェアしよう！</h3>
@if (Auth::check())
<div class="w-75 m-auto">
        @include('commons.error_messages')
</div>

<form method="POST" action="{{ route('post.store') }}">
    @csrf
    <div class="form-group mt-5 mb-5">
        <p>YouTube動画のURLが<span>https://www.youtube.com/watch?v=-bNMq1Nxn5o</span>ならば、<br>"v="の直後にある<span class="text-success">-bNMq1Nxn5o</span>を入力</p>
        <input name="youtube_id" id="youtube_id" class="form-control"  required value="{{ old('youtube_id') }}" placeholder="シェアしたいYouTube動画 ”ID”">
        <textarea class="form-control mt-3" name="content" rows="4"  required placeholder="旅行の思い出や計画を140字でシェアしよう！">{{ old('content') }}</textarea>
        <button type="submit" class="btn btn-primary mt-3 float-right">
            <i class="fab fa-telegram fa-2x"></i>
        </button>
    </div>
</form>

@endif

@include('posts.posts', ['posts' => $posts])
@endsection
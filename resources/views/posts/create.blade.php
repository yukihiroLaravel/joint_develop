@extends('layouts.app')
@section('content')
<div class="text-center mb-3">@include('commons.flash_message')</div>
    <h2 class="mt-5">動画を投稿する</h2>
    <form method="POST" action="{{ route('movie.store') }}">
        @csrf
        <div class="form-group mt-5">
            <div class="form-group">
                <label for="youtube_id" class="text-success">新規登録YouTube動画 "ID" を入力する</label>
                <p>例）登録したいYouTube動画のURLが?<span>https://www.youtube.com/watch?v=-bNMq1Nxn5o?なら</span>
                   <br>"v="の直後にある?"<span class="text-success">-bNMq1Nxn5o</span>"?を入力
                </p>
                <input id="youtube_id" type="text" class="form-control" name="youtube_id" value="{{ old('youtube_id') }}">
            </div>
            <div class="form-group">
                <label for="title" class="mt-3">動画タイトル(※任意)</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
            </div>
            <button type="submit" class="btn btn-primary mt-5 mb-5">登録する</button>
        </div>
    </form>
    <h2 class="mt-5">あなたの投稿した動画</h2>
    @include('posts.movie_show', ['movies' => $movies])    
@endsection
@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-dark">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-chalkboard-teacher pr-3 d-inline"></i>YouTubeまとめ</h1>
            <h1>× コミュニケーション</h1>
        </div>
    </div>
    @if (Auth::check())
        @include('commons.error_messages')
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="2">{{ old('content') }}</textarea>
                <button type="submit" class="btn btn-primary btn-block">投稿する</button>
            </div>
        </form>
    @endif
    <h5 class="description text-center">みんなの"オススメ"動画を自由にシェアしよう</h5>
    @include('posts.posts', ['posts' => $posts])
@endsection